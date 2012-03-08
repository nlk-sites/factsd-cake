<?php
App::uses('AppController', 'Controller');
/**
 * EligReqOptions Controller
 *
 * @property EligReqOption $EligReqOption
 */
class EligReqOptionsController extends AppController {

    public function isAuthorized($admin) {
        if (parent::isAuthorized($admin)) {
            return true;
        }
        if ($admin['user_level_id'] >= 1000) {
            return true;
        }
        return false;
    }
    
    public function beforeRender(){
        parent::beforeRender();
        $this->set('sidebar', $this->EligReqOption->EligReq->getSidebarLinks($this->action, $this->name));
    }

/**
 * admin_index method
 *
 * @return void
 */
    public function admin_index() {
        $this->EligReqOption->recursive = 0;
        $this->set('eligReqOptions', $this->EligReqOption->find('all', array('recursive' => -1)));
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => 'EligReqOptions', 'no_agency' => TRUE)));
    }
    
/**
 * admin_add method
 *
 * @return void
 */
    public function admin_add($elig_req_id) {
        if ($this->request->is('post')) {
            $this->EligReqOption->create();
            if ($this->EligReqOption->save($this->request->data)) {
                $this->Session->setFlash(__('The eligibility requirement option has been saved'));
                $this->redirect(array('controller' => 'elig_reqs', 'action' => 'admin_edit', $elig_req_id));
            } else {
                $errors = $this->EligReqOption->validationErrors;
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
        //$programs = $this->EligReqOption->Program->find('list');
        $this->set(compact('elig_req_id'));
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => 'New Eligibility Requirement Option', 'no_agency' => TRUE)));
        $this->render('admin_edit');
    }

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
    public function admin_edit($id = null) {
        $this->EligReqOption->id = $id;
        if (!$this->EligReqOption->exists()) {
            throw new NotFoundException(__('Invalid eligibility requirement option'));
        }
        $elig_req_id = $this->EligReqOption->field('elig_req_id', array('EligReqOption.id' => $id));
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->EligReqOption->save($this->request->data)) {
                $this->Session->setFlash(__('The eligibility requirement option has been saved'));
                $this->redirect(array('controller' => 'elig_reqs', 'action' => 'admin_edit', $elig_req_id));
            } else {
                $errors = $this->EligReqOption->validationErrors;
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
            $this->EligReqOption->recursive = -1;
            $this->request->data = $this->EligReqOption->read(null, $id);
        }
        //$programs = $this->EligReqOption->Program->find('list');
        $this->set(compact('elig_req_id'));
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => $this->EligReqOption->field('name', array('EligReqOption.id' => $id)), 'no_agency' => TRUE)));
    }

/**
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
    public function admin_delete($id = null) {
        $this->EligReqOption->id = $id;
        if (!$this->EligReqOption->exists()) {
            throw new NotFoundException(__('Invalid eligibility requirement option'));
        }
        $program_elig_reqs = $this->EligReqOption->find('first', array('conditions' => array('EligReqOption.id' => $id), 'contain' => array('Program' => array('fields' => array('id', 'name')))));
        if(isset($program_elig_reqs['Program']) && !empty($program_elig_reqs['Program'])){
            $this->Session->setFlash('This eligibility requirement option cannot be deleted because it is being used by one or more programs.  Below are the programs that have '.$program_elig_reqs['EligReqOption']['name'].' listed among their eligibility requirements.');
            $this->set('program_elig_reqs', $program_elig_reqs);
            $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => 'Can\'t Delete '.$program_elig_reqs['EligReqOption']['name'], 'no_agency' => TRUE)));
        }else{
            $elig_req_id = $this->EligReqOption->field('elig_req_id', array('EligReqOption.id' => $id));
            if ($this->EligReqOption->delete()) {
                $this->Session->setFlash(__('Eligibility requirement option deleted'));
                $this->redirect(array('controller' => 'elig_reqs', 'action' => 'admin_edit', $elig_req_id));
            }
            $this->Session->setFlash(__('Eligibility requirement option was not deleted'));
            $this->redirect(array('controller' => 'elig_reqs', 'action' => 'admin_edit', $elig_req_id));
        }
    }
}
