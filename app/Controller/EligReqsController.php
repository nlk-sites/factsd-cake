<?php
App::uses('AppController', 'Controller');
/**
 * EligReqs Controller
 *
 * @property EligReq $EligReq
 */
class EligReqsController extends AppController {

    
    public function beforeRender(){
        parent::beforeRender();
        $this->set('sidebar', $this->EligReq->getSidebarLinks($this->action, $this->name));
    }

/**
 * admin_index method
 *
 * @return void
 */
    public function admin_index() {
        $this->EligReq->recursive = 0;
        $this->set('eligReqs', $this->EligReq->find('all', array('recursive' => -1)));
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => 'Eligibility Requirements', 'no_agency' => TRUE)));
    }

/**
 * admin_add method
 *
 * @return void
 */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->EligReq->create();
            if ($this->EligReq->save($this->request->data)) {
                $this->Session->setFlash(__('The eligibility requirement has been saved'));
                $this->redirect(array('action' => 'edit', $this->EligReq->getInsertID()));
            } else {
                $errors = $this->EligReq->validationErrors;
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
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => 'New Eligibility Requirement', 'no_agency' => TRUE)));
        $this->render('admin_edit');
    }
    
    public function admin_edit_zips($id){
        $this->EligReq->id = $id;
        if (!$this->EligReq->exists()) {
            throw new NotFoundException(__('Invalid eligibility requirement'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['EligReq'] = array('id' => $id);
            if ($this->EligReq->save($this->request->data)) {
                $this->Session->setFlash(__('The zips have been saved'));
                $this->redirect(array('action' => 'edit', $id));
            } else {
                $this->Session->setFlash(__('The zips could not be saved. Please, try again.'));
            }
        } else {
            $alias_zips = $this->EligReq->EligReqsZip->find('list', array('conditions' => array('EligReqsZip.zip_alias_id' => $id)));
            if(!empty($alias_zips)){
                $this->request->data['Zip'] = array_combine($alias_zips, $alias_zips);
            }
        }
        $zips = $this->EligReq->Zip->find('all', array('order' => array('Zip.region_id', 'Zip.id'), 'contain' => array('Region')));
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
        $this->EligReq->id = $id;
        if (!$this->EligReq->exists()) {
            throw new NotFoundException(__('Invalid eligibility requirement'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->EligReq->save($this->request->data)) {
                $this->Session->setFlash(__('The eligibility requirement has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $errors = $this->EligReq->validationErrors;
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
            $this->request->data = $this->EligReq->read(null, $id);
        }
        $eligReqOptions = $this->EligReq->EligReqOption->find('all', array('conditions' => array('EligReqOption.elig_req_id' => $id), 'recursive' => -1));
        $this->set(compact('eligReqOptions'));
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => $this->EligReq->field('name', array('EligReq.id' => $id)), 'no_agency' => TRUE)));
    }

/**
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
    public function admin_delete($id = null) {
        $this->EligReq->id = $id;
        if (!$this->EligReq->exists()) {
            throw new NotFoundException(__('Invalid eligibility requirement'));
        }
        $program_elig_reqs = $this->EligReq->find('first', array('conditions' => array('EligReq.id' => $id), 'contain' => array('EligReqOption' => array('Program' => array('fields' => array('id', 'name'))))));
        $programs = array();
        if(isset($program_elig_reqs['EligReqOption']) && !empty($program_elig_reqs['EligReqOption'])){
            foreach($program_elig_reqs['EligReqOption'] as $per){
                if(!empty($per['Program'])){
                    foreach($per['Program'] as $pp){
                        $programs[$pp['id']] = $pp['name'];
                    }
                }
            }
        }
        if(!empty($programs)){
            $this->Session->setFlash('This eligibility requirement cannot be deleted because it is being used by one or more programs.  Below are the programs that have '.$program_elig_reqs['EligReq']['name'].' listed among their eligibility requirements.');
            $this->set('programs', $programs);
            $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => 'Can\'t Delete '.$program_elig_reqs['EligReq']['name'], 'no_agency' => TRUE)));
        }else{
            if ($this->EligReq->delete($id, TRUE)) {
                $this->Session->setFlash(__('Eligibility requirement deleted'));
                $this->redirect(array('action'=>'index'));
            }
            $this->Session->setFlash(__('Eligibility requirement was not deleted'));
            $this->redirect(array('action' => 'index'));
        }
    }
}
