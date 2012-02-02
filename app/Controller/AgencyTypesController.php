<?php
App::uses('AppController', 'Controller');
/**
 * AgencyTypes Controller
 *
 * @property AgencyType $AgencyType
 */
class AgencyTypesController extends AppController {
    
    public function beforeRender(){
        parent::beforeRender();
        $this->set('sidebar', $this->AgencyType->Agency->getSidebarLinks($this->action, $this->name));
    }

/**
 * admin_index method
 *
 * @return void
 */
    public function admin_index() {
        $this->AgencyType->recursive = 0;
        $this->set('agency_types', $this->AgencyType->find('all'));
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => 'Agency Types', 'no_agency' => TRUE)));
    }

/**
 * admin_add method
 *
 * @return void
 */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->AgencyType->create();
            if ($this->AgencyType->save($this->request->data)) {
                $this->Session->setFlash(__('The agency type has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $errors = $this->AgencyType->validationErrors;
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
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => 'New Agency Type', 'no_agency' => TRUE)));
        $this->render('admin_edit');
    }

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
    public function admin_edit($id = null) {
        $this->AgencyType->id = $id;
        if (!$this->AgencyType->exists()) {
            throw new NotFoundException(__('Invalid agency type'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->AgencyType->save($this->request->data)) {
                $this->Session->setFlash(__('The agency type has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $errors = $this->AgencyType->validationErrors;
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
            $this->request->data = $this->AgencyType->find('first', array('conditions' => array('AgencyType.id' => $id), 'recursive' => -1));
        }
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => $this->AgencyType->field('name', array('AgencyType.id' => $id)), 'no_agency' => TRUE)));
    }

/**
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
    public function admin_delete($id = null) {
        $this->AgencyType->id = $id;
        if (!$this->AgencyType->exists()) {
            throw new NotFoundException(__('Invalid agency type'));
        }
        if ($this->AgencyType->delete()) {
            $this->Session->setFlash(__('Agency type deleted'));
            $this->redirect(array('action'=>'index'));
        }
        $this->Session->setFlash(__('Agency type was not deleted'));
        $this->redirect(array('action' => 'index'));
    }
}
