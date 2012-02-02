<?php
App::uses('AppController', 'Controller');
/**
 * ZipAliases Controller
 *
 * @property ZipAlias $ZipAlias
 */
class ZipAliasesController extends AppController {

    public $paginate = array(
        'limit' => 20,
        'maxLimit' => 99999,
        'sort' => 'name'
    );
    
    public function beforeRender(){
        $problem_zip_aliases = parent::beforeRender();
        $extra['problem_zip_aliases'] = $problem_zip_aliases['problem_zip_aliases'];
        $this->set('sidebar', $this->ZipAlias->getSidebarLinks($this->action, $this->name, $extra));
    }

/**
 * admin_index method
 *
 * @return void
 */
    public function admin_index($problem = 0) {
        if($problem == 1){
            $this->paginate['conditions'] = array('not' => array('ZipAlias.id' => $this->ZipAlias->findProblems()));
        }
        $this->set('zipAliases', $this->paginate());
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => 'Zip Aliases'.($problem == 1 ? ' With Duplicate Names and/or Without Zips' : ''), 'no_agency' => TRUE)));
    }
    
    public function admin_map_address($id){
        $this->ZipAlias->id = $id;
        if (!$this->ZipAlias->exists()) {
            throw new NotFoundException(__('Invalid zip alias'));
        }
        $zip_alias = $this->ZipAlias->find('first', array('conditions' => array('ZipAlias.id' => $id), 'contain' => array('Zip' => array('limit' => 1))));
        if(!empty($zip_alias['ZipAlias']['address'])){
            $address = $zip_alias['ZipAlias']['address'];
        }elseif(!empty($zip_alias['Zip'])){
            $address = $zip_alias['Zip'][0]['id'];
        }
        if(isset($address)){
            $this->redirect('http://maps.google.com/maps?f=d&saddr='.urlencode($address).'&mrt=loc&t=m');
        }else{
            $this->Session->setFlash('This zip alias does not have any zip codes associated with it or an address.  Please correct this.');
            $this->redirect(array('action' => 'admin_edit', $id));
        }
    }

/**
 * admin_add method
 *
 * @return void
 */
    public function admin_add() {
        if ($this->request->is('post')) {
            if(!isset($this->request->data['Zip']) || empty($this->request->data['Zip'])){
                $this->Session->setFlash('Please select at least one zipcode for this alias');
            }else{
                $this->ZipAlias->create();
                if ($this->ZipAlias->save($this->request->data)) {
                    $this->Session->setFlash(__('The zip alias has been saved'));
                    $this->redirect(array('action' => 'edit', $this->ZipAlias->getInsertID()));
                } else {
                    $errors = $this->ZipAlias->validationErrors;
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
        }
        $zips = $this->ZipAlias->Zip->find('all', array('order' => array('Zip.region_id', 'Zip.id'), 'contain' => array('Region')));
        $zip_model = 'Zip';
        $this->set(compact('zips', 'zip_model'));
        $zipAliasTypes = $this->ZipAlias->ZipAliasType->find('list');
        $regions = $this->ZipAlias->Region->find('list');
        $this->set(compact('zipAliasTypes', 'regions'));
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => 'New Zip Alias', 'no_agency' => TRUE)));
        $this->render('admin_edit');
    }
    
    public function admin_edit_zips($id){
        $this->ZipAlias->id = $id;
        if (!$this->ZipAlias->exists()) {
            throw new NotFoundException(__('Invalid zip alias'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if(!isset($this->request->data['Zip']) || empty($this->request->data['Zip'])){
                $this->Session->setFlash('Please select at least one zipcode for this alias');
            }else{
                $this->request->data['ZipAlias'] = array('id' => $id);
                if ($this->ZipAlias->save($this->request->data)) {
                    $this->Session->setFlash(__('The zips have been saved'));
                    $this->redirect(array('action' => 'edit', $id));
                } else {
                    $this->Session->setFlash(__('The zips could not be saved. Please, try again.'));
                }
            }
        } else {
            $alias_zips = $this->ZipAlias->ZipAliasesZip->find('list', array('conditions' => array('ZipAliasesZip.zip_alias_id' => $id)));
            if(!empty($alias_zips)){
                $this->request->data['Zip'] = array_combine($alias_zips, $alias_zips);
            }
        }
        $zips = $this->ZipAlias->Zip->find('all', array('order' => array('Zip.region_id', 'Zip.id'), 'contain' => array('Region')));
        $zip_model = 'Zip';
        $this->set(compact('zipAliasTypes', 'regions', 'zips', 'zip_model'));
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => 'Edit Zips', 'zip_alias_id' => $id, 'no_agency' => TRUE)));
    }

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
    public function admin_edit($id = null) {
        $this->ZipAlias->id = $id;
        if (!$this->ZipAlias->exists()) {
            throw new NotFoundException(__('Invalid zip alias'));
        }
        if(!$this->ZipAlias->ZipAliasesZip->hasAny(array('ZipAliasesZip.zip_alias_id' => $id))){
            $this->set('select_zips', true);
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            //prd($this->request->data);
            if ($this->ZipAlias->save($this->request->data)) {
                $this->Session->setFlash(__('The zip alias has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $errors = $this->ZipAlias->validationErrors;
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
            $this->request->data = $this->ZipAlias->read(null, $id);
        }
        $alias_zips = $this->ZipAlias->ZipAliasesZip->find('list', array('conditions' => array('ZipAliasesZip.zip_alias_id' => $id), 'fields' => array('ZipAliasesZip.zip_id', 'ZipAliasesZip.zip_id')));
        $zipAliasTypes = $this->ZipAlias->ZipAliasType->find('list');
        $regions = $this->ZipAlias->Region->find('list');
        $this->set(compact('zipAliasTypes', 'regions', 'alias_zips'));
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('zip_alias_id' => $id, 'no_agency' => TRUE)));
    }

/**
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
    public function admin_delete($id = null) {
        $this->ZipAlias->id = $id;
        if (!$this->ZipAlias->exists()) {
            throw new NotFoundException(__('Invalid zip alias'));
        }
        if ($this->ZipAlias->delete()) {
            $this->Session->setFlash(__('Zip alias deleted'));
            $this->redirect(array('action'=>'index'));
        }
        $this->Session->setFlash(__('Zip alias was not deleted'));
        $this->redirect(array('action' => 'index'));
    }
}
