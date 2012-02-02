<?php
App::uses('AppController', 'Controller');
/**
 * Programs Controller
 *
 * @property Program $Program
 */
class FeesController extends AppController {

    public $paginate = array(
        'limit' => 20,
    );
    public $uses = array('Program', 'Fee', 'FeeType');
    public $helpers = array('Js' => array('Jquery'));
    public $components = array('RequestHandler');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('map', 'map_route');
    }
    
    public function beforeRender(){
        parent::beforeRender();
        $extra = array();
        if(isset($this->request->params['pass'][0]) && !empty($this->request->params['pass'][0])){
            if($this->action == 'admin_edit'){
                $extra['program_id'] = $this->Fee->field('program_id', array('Fee.id' => $this->request->params['pass'][0]));
            }else{
                $extra['program_id'] = $this->request->params['pass'][0];
            }
        }
        $this->set('sidebar', $this->Fee->Program->getSidebarLinks($this->action, $this->name, $extra));
    }
    
    public function isAuthorized($admin) {
        if (parent::isAuthorized($admin)) {
            return true;
        }
        if($admin['user_level_id'] >= 1000){
            return true;
        }
        if(in_array($this->action, array('admin_index', 'admin_add'))){
            return $this->Program->isOwnedBy($this->request->params['pass'][0], $admin['agency_id']);
        }else return $this->Fee->isOwnedBy($this->request->params['pass'][0], $admin['agency_id']);
        return false;
    }
/**
 * admin_add method
 *
 * @return void
 */
    public function admin_add($program_id) {
        $this->Program->id = $program_id;
        if (!$this->Program->exists()) {
            throw new NotFoundException(__('Invalid program'));
        }
        if ($this->request->is('post')) {
            $this->Fee->create();
            if ($this->Fee->save($this->request->data)) {
                $this->Session->setFlash('The new fee has been created.');
                $this->redirect(array('action' => 'index', $program_id));
            } else {
                $errors = $this->Fee->validationErrors;
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
        $feeTypes = $this->FeeType->find('list');
        $program_info = $this->Program->find('first', array('conditions' => array('Program.id' => $program_id), 'contain' => array('Agency')));
        $this->set(compact('program_info', 'feeTypes'));
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('program_id' => $program_id, 'cur_title' => 'New Fee')));
        $this->render('admin_edit');
    }

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
    public function admin_edit($id = null) {
        $this->Fee->id = $id;
        if (!$this->Fee->exists()) {
            throw new NotFoundException(__('Invalid fee'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Fee->save($this->request->data)) {
                $this->Session->setFlash('The fee has been saved.');
                $this->redirect(array('action' => 'index', $program_id));
            } else {
                $errors = $this->Fee->validationErrors;
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
            $this->request->data = $this->Fee->read(null, $id);
        }
        $feeTypes = $this->FeeType->find('list');
        $program_id = $this->Fee->field('Fee.program_id', array('Fee.id' => $id));
        $program_info = $this->Program->find('first', array('conditions' => array('Program.id' => $program_id), 'contain' => array('Agency')));
        $this->set(compact('program_info', 'feeTypes'));
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('program_id' => $program_id, 'cur_title' => 'Edit Fee')));
    }

/**
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
    public function admin_delete($id = null) {
        $this->Fee->id = $id;
        $program_id = $this->Fee->get_program_id($id);
        if (!$this->Fee->exists()) {
            throw new NotFoundException(__('Invalid fee'));
        }
        if ($this->Fee->delete()) {
            $this->Session->setFlash('Fee deleted');
        }else{
            $this->Session->setFlash('Fee was not deleted');
        }
        $this->redirect(array('action' => 'index', $program_id));
    }
    
    public function admin_index($program_id){
        $this->Program->id = $program_id;
        if (!$this->Program->exists()) {
            throw new NotFoundException(__('Invalid program'));
        }
        $program_info = $this->Program->find('first', array('conditions' => array('Program.id' => $program_id), 'contain' => array('Agency')));
        $this->set('program_info', $program_info);
        $fees = $this->Program->Fee->get_program_fees($program_id);
        $this->set(compact('fees', 'program_info'));
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('program_id' => $program_id, 'cur_title' => 'Fees')));
    }
}
