<?php
App::uses('AppController', 'Controller');
/**
 * Programs Controller
 *
 * @property Program $Program
 */
class ProgramsController extends AppController {

    public $paginate = array(
        'limit' => 20,
    );
    public $uses = array('Program', 'Zip', 'Service', 'ZipAliasType', 'ZipAlias');
    public $helpers = array('Js' => array('Jquery'));
    public $components = array('RequestHandler');
/**
 * index method
 *
 * @return void
 */
    public function map_route($origin = '', $destination = ''){
        $this->set('origin', $origin);
        $this->set('destination', $destination);
    }
	public function index() {
        $contains = array('Agency');
        $conditions = array('Program.id IS NOT NULL');
        $joins = array();
        $addresses = array('origin' => null, 'destination' => null);
        $msgs = array();
        if($this->data){
            $origin = '';
            $destination = '';
            foreach($this->data['Program'] as $addresstype => $address){
                if(!in_array($addresstype, array('origin', 'destination'))){
                    continue;
                }
                if(isset($this->data['filter']) && $this->data['filter'] == 1){
                    if(isset($this->data['Location'][$addresstype]) && !empty($this->data['Location'][$addresstype])){
                        $$addresstype = explode(',', $this->data['Location'][$addresstype]);
                    }
                    continue;
                }
                $this->set('reset_map', 1);
                $address = trim($address);
                $addresses[$addresstype] = $address;
                if(empty($address)){
                    continue;
                }
                //if the user entered a zip that's in the database, don't bother geocoding it
                if(is_numeric($address) && strlen($address)==5 && $this->Zip->hasAny(array('id'=>$address))){
                    $$addresstype = $address;
                }else{
                    $zip_alias = $this->ZipAlias->find('first', array('conditions' => array('ZipAlias.name' => $address), 'fields' => array('address', 'id')));
                    if(!empty($zip_alias)){
                        //prd($zip_alias);
                        $zips = $this->ZipAlias->ZipAliasesZip->find('list', array('conditions' => array('ZipAliasesZip.zip_alias_id' => $zip_alias['ZipAlias']['id'])));
                        if(!empty($zips)){
                            if(!empty($zip_alias['ZipAlias']['address'])){
                                $addresses[$addresstype] = $zip_alias['ZipAlias']['address'];
                            }else{
                                $addresses[$addresstype] = reset($zips);
                            }
                            $$addresstype = array_values($zips);
                            continue;
                        }
                    }
                    //get the zipcode by geocoding the address
                    list($error, $msg, $zip, $formatted_address) = $this->Zip->get_geocode_zip($address, $addresstype);
                    $addresses[$addresstype] = $formatted_address;
                    if(!empty($msg)){
                        $msgs[] = $msg;
                    }
                    if(!$error){
                        $$addresstype = $zip;
                    }
                }
            }
            if(!empty($origin)){
                $contains[] = 'ProgramOrigZip';
                $conditions['ProgramOrigZip.zip_id'] = $origin;
            }
            if(!empty($destination)){
                $contains[] = 'ProgramDestZip';
                $conditions['ProgramDestZip.zip_id'] = $destination;
            }
            if(!empty($this->data['Service']['id'])){
                $services = array_filter($this->data['Service']['id']);
                if(!empty($services)){
                    $service_programs = $this->Service->ProgramsService->find('list', array('fields' => array('ProgramsService.program_id'), 'conditions' => array('ProgramsService.service_id' => $services), 'group' => array('ProgramsService.program_id HAVING COUNT(DISTINCT(service_id)) = '.count($services))));
                    $conditions['Program.id'] = array_values($service_programs);
                    //$joins[] = array('table'=>'programs_services', 'alias'=>'ProgramsService', 'type'=>'INNER', 'conditions'=>'Program.id=ProgramsService.program_id');
                    //$conditions['ProgramsService.service_id'] = $services;
                }
            }
            if(!empty($this->data['Fee']['fee'])){
                $joins[] = array('table'=>'fees', 'alias'=>'Fee', 'type'=>'LEFT', 'conditions'=>'Program.id=Fee.program_id');
                switch($this->data['Fee']['fee']){
                    case 1:
                        $conditions['Fee.fee_type_id'] = 9;
                        break;
                    case 2:
                        $conditions['Fee.fee_type_id'] = array(2, 8);
                        $conditions['Fee.fee <='] = 5;
                        break;
                    case 3:
                        $conditions['Fee.fee_type_id'] = array(2, 8);
                        $conditions['Fee.fee BETWEEN ? AND ?'] = array(5, 15);
                        break;
                    case 4:
                        $conditions['NOT']['Fee.fee_type_id'] = array(2, 8, 9);
                        break;
                }
            }
            if(!empty($this->data['Eligibility']['reqs'])){
                if($this->data['Eligibility']['reqs'] == 1){
                    $joins[] = array('table'=>'elig_req_options_programs', 'alias'=>'EligReqOptionsPrograms', 'type'=>'INNER', 'conditions'=>'Program.id=EligReqOptionsPrograms.program_id AND EligReqOptionsPrograms.elig_req_option_id <> 94');
                }elseif($this->data['Eligibility']['reqs'] == 2){
                    $joins[] = array('table'=>'elig_req_options_programs', 'alias'=>'EligReqOptionsPrograms', 'type'=>'LEFT', 'conditions'=>'Program.id=EligReqOptionsPrograms.program_id AND EligReqOptionsPrograms.elig_req_option_id');
                    $conditions['OR'][] = 'EligReqOptionsPrograms.elig_req_option_id = 94';
                    $conditions['OR']['EligReqOptionsPrograms.elig_req_option_id'] = null;
                }
            }
        }

        $this->paginate['joins'] = $joins;
        $this->paginate['conditions'] = $conditions;
        $this->paginate['order'] = 'Program.name';
        $this->paginate['contain'] = $contains;
        $this->paginate['group'] = 'Program.id';
        $this->paginate['fields'] = array('Agency.name', 'Program.id', 'Program.name', 'Program.description', 'Program.phone', 'Program.url', 'Program.email', 'Program.slug');

        if($this->RequestHandler->isAjax()){
            if(!$this->data && $this->Session->check('search_options')){
                $this->paginate = $this->Session->read('search_options');
            }
            $this->viewPath = 'Elements';
        }

        $this->Session->write('search_options', $this->paginate);
        $destination = (isset($this->paginate['conditions']['ProgramDestZip.zip_id']) ? $this->paginate['conditions']['ProgramDestZip.zip_id'] : "");
        $origin = (isset($this->paginate['conditions']['ProgramOrigZip.zip_id']) ? $this->paginate['conditions']['ProgramOrigZip.zip_id'] : "");
        $this->set('locations', array('origin' => $origin, 'destination' => $destination));
        $this->set('programs', $this->paginate('Program'));
        $this->set('addresses', $addresses);
        $this->set('msgs', $msgs);

        if($this->viewPath == 'Elements'){
            $this->render('search_results');
        }else{
            $this->set('services', $this->Service->find('list', array('joins' => array(array('table'=>'programs_services', 'alias'=>'ProgramsService', 'type'=>'INNER', 'conditions'=>'Service.id=ProgramsService.service_id')), 'group' => 'Service.id')));
            list($zip_aliases, $zip_alias_types) = $this->ZipAliasType->get_aliases();
            $this->set('zip_alias_types', $zip_alias_types);
            $this->set('zip_aliases', $zip_aliases);
        }
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */

    function slugify($program_id){
        $program_name = $this->Program->find('field', array('Program.id' => $program_id));
        if(!empty($program_name)){
            $str = Inflector::slug($name);
            $str = strtolower($str);
            if($this->Program->hasAny(array('slug' => $str))){
                pr('PROBLEM: '.$str);
            }else{
                $this->Program->create();
                $this->Program->id = $p_id;
                $this->Program->set(array('slug' => $str));
                $this->Program->save();
            }
        }
        //prd($programs);
    }

    public function map(){
        $dir_url = 'http://maps.googleapis.com/maps/api/directions/json?origin=92103&destination=92024&mode=driving&sensor=false';
    }

	public function view($slug = null) {
        $id = $this->Program->field('id', array('slug' => $slug));
        if(empty($id)){
            $id = $slug;
        }
		$this->Program->id = $id;
		if (!$this->Program->exists()) {
			throw new NotFoundException(__('Invalid program'));
		}
        $contains = array('Agency', 'Service', 'EligReqOption'=>array('EligReq'), 'Fee');
        $program = $this->Program->find('first', array('conditions' => array('Program.id' => $id), 'contain' => $contains));
		$this->set('program', $program);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Program->create();
			if ($this->Program->save($this->request->data)) {
				$this->flash(__('Program saved.'), array('action' => 'index'));
			} else {
			}
		}
		$agencies = $this->Program->Agency->find('list');
		$providerTypes = $this->Program->ProviderType->find('list');
		$eligReqOptions = $this->Program->EligReqOption->find('list');
		$searchRequests = $this->Program->SearchRequest->find('list');
		$services = $this->Program->Service->find('list');
		$this->set(compact('agencies', 'providerTypes', 'eligReqOptions', 'searchRequests', 'services'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Program->id = $id;
		if (!$this->Program->exists()) {
			throw new NotFoundException(__('Invalid program'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Program->save($this->request->data)) {
				$this->flash(__('The program has been saved.'), array('action' => 'index'));
			} else {
			}
		} else {
			$this->request->data = $this->Program->read(null, $id);
		}
		$agencies = $this->Program->Agency->find('list');
		$providerTypes = $this->Program->ProviderType->find('list');
		$eligReqOptions = $this->Program->EligReqOption->find('list');
		$searchRequests = $this->Program->SearchRequest->find('list');
		$services = $this->Program->Service->find('list');
		$this->set(compact('agencies', 'providerTypes', 'eligReqOptions', 'searchRequests', 'services'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Program->id = $id;
		if (!$this->Program->exists()) {
			throw new NotFoundException(__('Invalid program'));
		}
		if ($this->Program->delete()) {
			$this->flash(__('Program deleted'), array('action' => 'index'));
		}
		$this->flash(__('Program was not deleted'), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Program->recursive = 0;
		$this->set('programs', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Program->id = $id;
		if (!$this->Program->exists()) {
			throw new NotFoundException(__('Invalid program'));
		}
		$this->set('program', $this->Program->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Program->create();
			if ($this->Program->save($this->request->data)) {
				$this->flash(__('Program saved.'), array('action' => 'index'));
			} else {
			}
		}
		$agencies = $this->Program->Agency->find('list');
		$providerTypes = $this->Program->ProviderType->find('list');
		$eligReqOptions = $this->Program->EligReqOption->find('list');
		$searchRequests = $this->Program->SearchRequest->find('list');
		$services = $this->Program->Service->find('list');
		$this->set(compact('agencies', 'providerTypes', 'eligReqOptions', 'searchRequests', 'services'));
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Program->id = $id;
		if (!$this->Program->exists()) {
			throw new NotFoundException(__('Invalid program'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Program->save($this->request->data)) {
				$this->flash(__('The program has been saved.'), array('action' => 'index'));
			} else {
			}
		} else {
			$this->request->data = $this->Program->read(null, $id);
		}
		$agencies = $this->Program->Agency->find('list');
		$providerTypes = $this->Program->ProviderType->find('list');
		$eligReqOptions = $this->Program->EligReqOption->find('list');
		$searchRequests = $this->Program->SearchRequest->find('list');
		$services = $this->Program->Service->find('list');
		$this->set(compact('agencies', 'providerTypes', 'eligReqOptions', 'searchRequests', 'services'));
	}

/**
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Program->id = $id;
		if (!$this->Program->exists()) {
			throw new NotFoundException(__('Invalid program'));
		}
		if ($this->Program->delete()) {
			$this->flash(__('Program deleted'), array('action' => 'index'));
		}
		$this->flash(__('Program was not deleted'), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
}
