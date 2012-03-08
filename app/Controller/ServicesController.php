<?php
App::uses('AppController', 'Controller');
/**
 * Services Controller
 *
 * @property Service $Service
 */
class ServicesController extends AppController {

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
        $this->set('sidebar', $this->Service->getSidebarLinks($this->action, $this->name));
    }

/**
 * admin_index method
 *
 * @return void
 */
    public function admin_index() {
        $this->Service->recursive = 0;
        $this->set('services', $this->Service->find('all', array('recursive' => -1)));
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => 'Services', 'no_agency' => TRUE)));
    }

/**
 * admin_add method
 *
 * @return void
 */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Service->create();
            if ($this->Service->save($this->request->data)) {
                $this->Session->setFlash(__('The service has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $errors = $this->Service->validationErrors;
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
        //$programs = $this->Service->Program->find('list');
        //$this->set(compact('programs'));
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => 'New Service', 'no_agency' => TRUE)));
        $this->render('admin_edit');
    }

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
    public function admin_edit($id = null) {
        $this->Service->id = $id;
        if (!$this->Service->exists()) {
            throw new NotFoundException(__('Invalid service'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Service->save($this->request->data)) {
                $this->Session->setFlash(__('The service has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $errors = $this->Service->validationErrors;
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
            $this->request->data = $this->Service->read(null, $id);
        }
        //$programs = $this->Service->Program->find('list');
        //$this->set(compact('programs'));
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => $this->Service->field('name', array('Service.id' => $id)), 'no_agency' => TRUE)));
    }

/**
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
    public function admin_delete($id = null) {
        $this->Service->id = $id;
        if (!$this->Service->exists()) {
            throw new NotFoundException(__('Invalid service'));
        }
        $program_services = $this->Service->find('first', array('conditions' => array('Service.id' => $id), 'contain' => array('Program' => array('fields' => array('id', 'name')))));
        if(isset($program_services['Program']) && !empty($program_services['Program'])){
            $this->Session->setFlash('This service cannot be deleted because it is being used by one or more programs.  Below are the programs that have '.$program_services['Service']['name'].' listed among their services.');
            $this->set('program_services', $program_services);
            $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => 'Can\'t Delete '.$program_services['Service']['name'], 'no_agency' => TRUE)));
        }else{
            if ($this->Service->delete()) {
                $this->Session->setFlash(__('Service deleted'));
                $this->redirect(array('action'=>'index'));
            }
            $this->Session->setFlash(__('Service was not deleted'));
            $this->redirect(array('action' => 'index'));
        }
    }
}
