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
        'maxLimit' => 99999,
        'sort' => 'name'
    );
    public $uses = array('Program', 'Zip', 'Service', 'ZipAliasType', 'ZipAlias', 'EligReq', 'EligReqOption');
    public $helpers = array('Js' => array('Jquery'));
    public $components = array('RequestHandler', 'Cookie');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('map', 'map_route', 'lists', 'get_results_data');
    }
    
    public function beforeRender(){
        parent::beforeRender();
        if(isset($this->params['prefix']) && $this->params['prefix'] == 'admin'){
            $extra = array();
            if(($this->action == 'admin_index' || $this->action == 'admin_add') && isset($this->request->params['pass'][0]) && !empty($this->request->params['pass'][0])){
                $extra['agency_id'] = $this->request->params['pass'][0];
                $extra['name'] = $this->Program->Agency->field('name', array('Agency.id' => $extra['agency_id']));
                $this->set('sidebar', $this->Program->Agency->getSidebarLinks($this->action, $this->name, $extra));
            }else{
                if(isset($this->request->params['pass'][0]) && !empty($this->request->params['pass'][0])){
                    $extra['program_id'] = $this->request->params['pass'][0];
                }
                $this->set('sidebar', $this->Program->getSidebarLinks($this->action, $this->name, $extra));
            }
        }
    }
    
    public function isAuthorized($admin) {
        if (parent::isAuthorized($admin)) {
            return true;
        }
        if($admin['user_level_id'] >= 1000){
            return true;
        }
        if($this->action == 'admin_index' || $this->action == 'admin_add'){
            $this->request->params['pass'][0] = $admin['agency_id'];
            return true;
        }else return $this->Program->isOwnedBy($this->request->params['pass'][0], $admin['agency_id']);
    }
/**
 * index method
 *
 * @return void
 */
    public function map_route($origin = '', $destination = ''){
        $this->set('origin', $origin);
        $this->set('destination', $destination);
    }
    
    function get_data_cookie($fields){
        $cookie = array();
        unset($fields['filter']);
        $select_fields = array('Service' => 'checkbox', 'Fee' => 'radio', 'Eligibility' => 'radio');
        $field_name = 'radio, ';
        foreach($fields as $name0 => $d0){
            $field_type = isset($select_fields[$name0]) ? $select_fields[$name0] : 'input';
            $this->format_data_cookie($cookie, $field_type, $d0, $name0);
        }
        return $cookie;
    }
    
    function format_data_cookie(&$cookie, $field_type, $data, $full_name, $level_name=''){
        if(is_array($data)){
            foreach($data as $d_name => $d_val){
                $this->format_data_cookie($cookie, $field_type, $d_val, $full_name.ucfirst($level_name), $d_name);
            }
        }else{
            if($field_type == 'radio'){
                $level_name .= $data;
            }
            $name = Inflector::camelize($full_name.ucfirst($level_name));
            if($field_type == 'checkbox'){
                $data = (bool) $data;
            }
            $cookie[$name] = array('value' => $data, 'type' => $field_type);
        }
    }
    
    
    
    public function index($hide_map = FALSE) {
        $this->set('hide_map', (bool) $hide_map);
        $filter_services = array(1, 31, 28, 25, 26);
        //$this->set('services', $this->Service->find('list', array('joins' => array(array('table'=>'programs_services', 'alias'=>'ProgramsService', 'type'=>'INNER', 'conditions'=>'Service.id=ProgramsService.service_id')), 'group' => 'Service.id')));
        $services = $this->Service->find('list', array('conditions' => array('Service.id' => $filter_services), 'order' => array('FIELD(Service.id, '.implode($filter_services, ', ').')')));
        $this->set('services', $services);
        list($zip_aliases, $zip_alias_types) = $this->ZipAliasType->get_aliases();
        $this->set('zip_alias_types', $zip_alias_types);
        $this->set('zip_aliases', $zip_aliases);
        if(!empty($this->data) && isset($this->data['Program'])){
            $submitted_data = array();
            foreach(array('origin', 'destination') as $loc_type){
                if(isset($this->data['Program'][$loc_type]) && !empty($this->data['Program'][$loc_type]) && !in_array($this->data['Program'][$loc_type], array('Your pick up location', 'Going to'))){
                    $submitted_data[$loc_type] = $this->data['Program'][$loc_type];
                }
            }
            if(!empty($submitted_data)){
                $this->set('submitted_data', $submitted_data);
            }
        }
    }
    
    public function get_results_data($hide_map = FALSE) {
        //$this->set('hide_map', (bool) $hide_map);
        $contains = array('Agency');
        $conditions = array('Program.id IS NOT NULL', 'Program.disabled <> 1');
        $joins = array();
        $addresses = array('origin' => null, 'destination' => null);
        $msgs = array();
        $orig_request_data = $this->Cookie->read('search_data');
        if($this->request->data){
            if(isset($this->request->data['Program']['origin']) && $this->request->data['Program']['origin'] == 'Your pick up location'){
                $this->request->data['Program']['origin'] = '';
            }
            if(isset($this->request->data['Program']['destination']) && $this->request->data['Program']['destination'] == 'Going to'){
                $this->request->data['Program']['destination'] = '';
            }
            //Check to see if it's a new search so that visited programs will be reset
            pr($orig_request_data);
            pr($this->request->data);
            if(!isset($orig_request_data['ProgramDestination']) || !isset($orig_request_data['ProgramOrigin']) || $this->request->data['Program']['destination'] != $orig_request_data['ProgramDestination']['value'] || $this->request->data['Program']['origin'] != $orig_request_data['ProgramOrigin']['value']){
                $visited = $this->Cookie->read('visited_programs');
                if(!empty($visited)){
                    $this->Cookie->delete('visited_programs');
                }
            }
            $this->Cookie->write('search_data', $this->get_data_cookie($this->request->data), false);
            $origin = '';
            $destination = '';
            foreach($this->request->data['Program'] as $addresstype => $address){
                if(!in_array($addresstype, array('origin', 'destination'))){
                    continue;
                }
                if(isset($this->request->data['filter']) && $this->request->data['filter'] == 1){
                    if(isset($this->request->data['Location'][$addresstype]) && !empty($this->request->data['Location'][$addresstype])){
                        $$addresstype = explode(',', $this->request->data['Location'][$addresstype]);
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
            if(!empty($this->request->data['Service']['id'])){
                $services = array_filter($this->request->data['Service']['id']);
                if(!empty($services)){
                    $service_programs = $this->Service->ProgramsService->find('list', array('fields' => array('ProgramsService.program_id'), 'conditions' => array('ProgramsService.service_id' => $services), 'group' => array('ProgramsService.program_id HAVING COUNT(DISTINCT(service_id)) = '.count($services))));
                    $conditions['Program.id'] = array_values($service_programs);
                    //$joins[] = array('table'=>'programs_services', 'alias'=>'ProgramsService', 'type'=>'INNER', 'conditions'=>'Program.id=ProgramsService.program_id');
                    //$conditions['ProgramsService.service_id'] = $services;
                }
            }
            if(!empty($this->request->data['Fee']['fee'])){
                $joins[] = array('table'=>'fees', 'alias'=>'Fee', 'type'=>'LEFT', 'conditions'=>'Program.id=Fee.program_id');
                switch($this->request->data['Fee']['fee']){
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
            if(!empty($this->request->data['Eligibility']['reqs'])){
                if($this->request->data['Eligibility']['reqs'] == 1){
                    $joins[] = array('table'=>'elig_req_options_programs', 'alias'=>'EligReqOptionsPrograms', 'type'=>'INNER', 'conditions'=>'Program.id=EligReqOptionsPrograms.program_id AND EligReqOptionsPrograms.elig_req_option_id <> 94');
                }elseif($this->request->data['Eligibility']['reqs'] == 2){
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
        $this->paginate['fields'] = array('Agency.name', 'Program.id', 'Program.name', 'Program.description', 'Program.phone', 'Program.url', 'Program.email', 'Program.slug', 'Program.application_required');
        
        if(!$this->request->data){
            $search_options = $this->Cookie->read('search_options');
            if($search_options){
                $this->paginate = $this->Cookie->read('search_options');
            }
        }

        $this->Cookie->write('search_options', $this->paginate);
        $remove_fields = array('LocationOrigin', 'LocationDestination', 'AddressOrigin', 'AddressDestination', 'OriginZipAliasTypeId', 'OriginZipAliasId1', 'DestinationZipAliasTypeId', 'DestinationZipAliasId1');
        if(isset($this->passedArgs['page'])){
            $this->paginate['page'] = $this->passedArgs['page'];
            $this->Cookie->write('search_page', $this->passedArgs['page']);
        }else{
            $page_cookie = $this->Cookie->read('search_page');
            if(!empty($page_cookie)){
                $current_request_data = $this->Cookie->read('search_data');
                if(isset($orig_request_data) && !is_array($orig_request_data) && !empty($orig_request_data)){
                    $orig_request_data = get_magic_quotes_gpc() ? json_decode(stripslashes($orig_request_data)) : json_decode($orig_request_data);
                    $orig_request_data = (array)$orig_request_data;
                    foreach($orig_request_data as $k => $n){
                        $orig_request_data[$k] = (array)$n;
                    }
                }
                if(isset($orig_request_data) && is_array($orig_request_data) && is_array($current_request_data) && serialize(array_diff_key($orig_request_data, array_keys($remove_fields))) == serialize(array_diff_key($current_request_data, array_keys($remove_fields)))){
                    $this->paginate['page'] = $this->Cookie->read('search_page');
                }else{
                    $this->Cookie->delete('search_page');
                }
            }
        }
        
        $this->viewPath = 'Elements';
        
        $visited_programs = $this->Cookie->read('visited_programs');
        if(empty($visited_programs)){
            $visited_programs = array();
        }
        $this->set('visited_programs', $visited_programs);
        $destination = (isset($this->paginate['conditions']['ProgramDestZip.zip_id']) ? $this->paginate['conditions']['ProgramDestZip.zip_id'] : "");
        $origin = (isset($this->paginate['conditions']['ProgramOrigZip.zip_id']) ? $this->paginate['conditions']['ProgramOrigZip.zip_id'] : "");
        $this->set('locations', array('origin' => $origin, 'destination' => $destination));
        $this->set('programs', $this->paginate('Program'));
        $this->set('addresses', $addresses);
        $this->set('msgs', $msgs);
        $this->render('search_results');
    }

/**
 * view method
 *
 * @param string $id
 * @return void
 */
    
    /*
    function slugify($name){
        if(!empty($name)){
            $str = Inflector::slug($name);
            $str = strtolower($str);
            $temp_str = $str;
            $i = 1;
            while($this->Program->hasAny(array('slug' => $temp_str))){
                $temp_str = $str.$i++;
            }
            $name = $temp_str;
        }
        return $name;
        //prd($programs);
    }

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
*/
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
        $visited_programs = $this->Cookie->read('visited_programs');
        if(empty($visited_programs)){
            $visited_programs = array();
        }
        if(!in_array($id, $visited_programs)){
            $visited_programs[] = $id;
        }
        $this->Cookie->write('visited_programs', $visited_programs);
        $contains = array('Agency', 'Service', 'EligReqOption'=>array('EligReq'), 'Fee', 'Review' => array('conditions' => array('Review.approved' => 1)));
        $program = $this->Program->find('first', array('conditions' => array('Program.id' => $id), 'contain' => $contains));
        $program_id = $id;
        $this->set(compact('program', 'program_id'));
    }
    
/**
 * admin_index method
 *
 * @return void
 */
    public function admin_index($agency_id = NULL) {
        if(!empty($agency_id)){
            $this->set('agency_id', $agency_id);
            $this->set('agency_data', $this->Program->Agency->find('first', array('conditions' => array('Agency.id' => $agency_id))));
            $this->paginate['conditions']['agency_id'] = $agency_id;
        }
        if(isset($this->passedArgs['limit']) && $this->passedArgs['limit'] == 'all'){
            $this->request->params['named']['limit'] = 99999;
        }
        $this->paginate['contain'] = array('Agency');
        $this->set('programs', $this->paginate());
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('agency_id' => $agency_id)));
    }

/**
 * admin_add method
 *
 * @return void
 */
    public function admin_add($agency_id=null) {
        if ($this->request->is('post')) {
            $this->Program->create();
            if ($this->Program->save($this->request->data)) {
                $this->Session->setFlash('The program has been saved.');
                $this->redirect(array('action' => 'edit', $this->Program->getInsertID()));
            } else {
                $errors = $this->Program->validationErrors;
                $msg = array();
                if(!empty($errors)){
                    foreach($errors as $e){
                        $msg = array_merge($msg, $e);
                    }
                    $this->Session->setFlash('Please correct the following error'.(count($msg) > 1 ? 's' : '').':<ul><li>'.implode($msg, '</li><li>').'</li></ul>');
                }else{
                    $this->Session->setFlash('There was an error saving your changes.');
                }
            }
        }
        if(!empty($agency_id)){
            $this->request->data['Program']['agency_id'] = $agency_id;
            $this->set('agency_id', $agency_id);
            $this->set('agency_data', $this->Program->Agency->find('first', array('conditions' => array('Agency.id' => $agency_id))));
        }
        $agencies = $this->Program->Agency->find('list', array('order' => array('Agency.name')));
        $this->set(compact('agencies'));
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('agency_id' => $agency_id, 'cur_title' => 'New Program')));

        $this->render('admin_edit');
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
                $this->Session->setFlash('The program has been saved.');
            } else {
                $errors = $this->Program->validationErrors;
                $msg = array();
                if(!empty($errors)){
                    foreach($errors as $e){
                        $msg = array_merge($msg, $e);
                    }
                    $this->Session->setFlash('Please correct the following error'.(count($msg) > 1 ? 's' : '').':<ul><li>'.implode($msg, '</li><li>').'</li></ul>');
                }else{
                    $this->Session->setFlash('There was an error saving your changes.');
                }
            }
        } else {
            $this->request->data = $this->Program->find('first', array('conditions' => array('Program.id' => $id), 'recursive' => -1));
        }
        $program_info = $this->Program->find('first', array('conditions' => array('Program.id' => $id), 'contain' => array('Agency')));
        $this->set('program_info', $program_info);
        $agencies = $this->Program->Agency->find('list');
        $this->set(compact('agencies'));
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('program_id' => $id)));
    }

/**
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
    public function admin_delete($id = NULL) {
        $this->Program->id = $id;
        if (!$this->Program->exists()) {
            throw new NotFoundException(__('Invalid program'));
        }
        if ($this->Program->delete($id, TRUE)) {
            $this->flash(__('Program deleted'), array('action' => 'index'));
        }
        $this->flash(__('Program was not deleted'), array('action' => 'index'));
        $this->redirect(array('action' => 'index'));
    }
    
    public function admin_zips($id, $type = 'origin'){
        if($type == 'origin'){
            $zip_model = 'ProgramOrigZip';
        }else{
            $zip_model = 'ProgramDestZip';
        }
        $this->Program->id = $id;
        //$this->Program->bindModel(array('hasMany' => array('ProgramOrigZip')));
        if (!$this->Program->exists()) {
            throw new NotFoundException(__('Invalid program'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $data = $this->request->data[$zip_model];
            $save_data = array();
            if(!empty($data)){
                foreach($data as $save_zip => $i){
                    $save_data[] = array('program_id' => $id, 'zip_id' => $save_zip);
                }
            }
            $this->Program->$zip_model->deleteAll(array('program_id' => $id, FALSE));
            if ($this->Program->$zip_model->saveAll($save_data)) {
                $this->Session->setFlash('The program has been saved.');
            } else {
                $this->Session->setFlash('There was an error saving your changes.');
            }
        } else {
            //$alias_zips = $this->ZipAlias->ZipAliasesZip->find('list', array('conditions' => array('ZipAliasesZip.zip_alias_id' => $id)));
            //if(!empty($alias_zips)){
            //    $this->request->data['Zip'] = array_combine($alias_zips, $alias_zips);
            //}
            
            $prog_zips = $this->Program->$zip_model->find('list', array('conditions' => array($zip_model.'.program_id' => $id), 'fields' => array('zip_id')));
            if(!empty($prog_zips)){
                $this->request->data[$zip_model] = array_combine($prog_zips, $prog_zips);
            }
            //foreach($prog_zips as $z){
            //    $this->request->data[$zip_model]['zip_id'][$z] = 1;
            //}
        }
        $this->set('program_info', $this->Program->find('first', array('conditions' => array('Program.id' => $id), 'contain' => array('Agency'))));
        $zips = $this->Zip->find('all', array('order' => array('Zip.region_id', 'Zip.id'), 'contain' => array('Region')));
        $this->set(compact('zips', 'zip_model'));
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('program_id' => $id, 'cur_title' => 'Program '.($type == 'origin' ? 'Origin' : 'Destination').' Zips')));
    }
    
    public function admin_elig($id){
        $this->Program->id = $id;
        if (!$this->Program->exists()) {
            throw new NotFoundException(__('Invalid program'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['EligReqOptionsProgram'] = array_filter(array_map('array_filter', $this->request->data['EligReqOptionsProgram']));
            $save_data = array();
            foreach($this->request->data['EligReqOptionsProgram'] as $d){
                $d['program_id'] = $id;
                $save_data[] = $d;
            }
            $this->Program->EligReqOptionsProgram->deleteAll(array('program_id' => $id, FALSE));
            if ($this->Program->EligReqOptionsProgram->saveAll($save_data)) {
                $this->Session->setFlash('The program has been saved.');
            } else {
                $this->Session->setFlash('There was an error saving your changes.');
            }
        } else {
            $prog_req_options = $this->Program->find('first', array('conditions' => array('Program.id' => $id), 'contain' => array('EligReqOption' => array('fields'=> array('id')))));
            if(!empty($prog_req_options['EligReqOption'])){
                foreach($prog_req_options['EligReqOption'] as $z){
                    $this->request->data['EligReqOptionsProgram'][$z['id']]['elig_req_option_id'] = $z['id'];
                }
            }
        }
        $program_info = $this->Program->find('first', array('conditions' => array('Program.id' => $id), 'contain' => array('Agency')));
        $req_options = $this->EligReq->find('all', array('order' => array('EligReq.name'), 'contain' => array('EligReqOption' => array('conditions' => array('EligReqOption.weight <>' => '0'), 'order' => array('EligReqOption.weight')))));
        $count_options = 0;
        foreach($req_options as $r){
            $count_options += count($r['EligReqOption']);
        }
        $this->set(compact('req_options', 'program_info', 'count_options'));
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('program_id' => $id, 'cur_title' => 'Eligibility Requirements')));
    }
    
    public function admin_services($id){
        $this->Program->id = $id;
        if (!$this->Program->exists()) {
            throw new NotFoundException(__('Invalid program'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['ProgramsService'] = array_filter(array_map('array_filter', $this->request->data['ProgramsService']));
            $save_data = array();
            foreach($this->request->data['ProgramsService'] as $d){
                $d['program_id'] = $id;
                $save_data[] = $d;
            }
            //prd($save_data);
            $this->Program->ProgramsService->deleteAll(array('program_id' => $id, FALSE));
            if ($this->Program->ProgramsService->saveAll($save_data)) {
                $this->Session->setFlash('The program has been saved.');
            } else {
                $this->Session->setFlash('There was an error saving your changes.');
            }
        } else {
            $prog_services = $this->Program->find('first', array('conditions' => array('Program.id' => $id), 'contain' => array('Service' => array('fields'=> array('id')))));
            if(!empty($prog_services['Service'])){
                foreach($prog_services['Service'] as $z){
                    $this->request->data['ProgramsService'][$z['id']]['service_id'] = $z['id'];
                }
            }
        }
        $program_info = $this->Program->find('first', array('conditions' => array('Program.id' => $id), 'contain' => array('Agency')));
        $all_services = $this->Service->find('all', array('order' => array('Service.name'), 'recursive' => -1));
        //prd($services);
        $count_options = count($all_services);
        $this->set(compact('all_services', 'program_info', 'count_options'));
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('program_id' => $id, 'cur_title' => 'Services')));
    }
    
    public function lists(){
        $closed_programs = $this->Program->find('all', array('recursive' => -1, 'fields' => array('Program.name', 'Program.slug'), 'order' => array('name'), 'conditions' => array('Program.clients_only' => 1, 'Program.disabled <> 1')));
        $open_programs = $this->Program->find('all', array('recursive' => -1, 'fields' => array('Program.name', 'Program.slug'), 'order' => array('name'), 'conditions' => array('Program.clients_only <> ' => 1, 'Program.disabled <> 1')));
        $this->set(compact('open_programs', 'closed_programs'));
    }
}
