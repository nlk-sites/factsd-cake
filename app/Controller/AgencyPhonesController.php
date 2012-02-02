<?php
App::uses('AppController', 'Controller');
/**
 * AgencyPhones Controller
 *
 * @property AgencyPhone $AgencyPhone
 */
class AgencyPhonesController extends AppController {
    
    public function isAuthorized($admin) {
        if (parent::isAuthorized($admin)) {
            return true;
        }
        if($admin['user_level_id'] >= 1000){
            return true;
        }
        if (in_array($this->action, array('admin_add'))) {
            $this->request->params['pass'][0] = $admin['agency_id'];
            return true;
        }
        if(isset($this->request->params['pass'][0])){
            return $this->AgencyPhone->isOwnedBy($this->request->params['pass'][0], $admin['agency_id']);
        }
        return false;
    }
    
    public function beforeRender(){
        parent::beforeRender();
        $extra['agency_id'] = $this->AgencyPhone->field('agency_id', array('AgencyPhone.id' => $this->request->params['pass'][0]));
        $extra['name'] = $this->AgencyPhone->Agency->field('name', array('Agency.id' => $extra['agency_id']));
        $this->set('sidebar', $this->AgencyPhone->Agency->getSidebarLinks($this->action, $this->name, $extra));
    }
/**
 * admin_add method
 *
 * @return void
 */
    public function admin_add($agency_id) {
        if ($this->request->is('post')) {
            $this->AgencyPhone->create();
            if ($this->AgencyPhone->save($this->request->data)) {
                $this->Session->setFlash(__('The phone has been saved'));
                $this->redirect(array('controller' => 'agencies', 'action' => 'admin_edit', $agency_id));
            } else {
                $errors = $this->AgencyPhone->validationErrors;
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
        $this->set('agency_id', $agency_id);
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => 'New Phone', 'agency_id' => $agency_id)));
        $this->render('admin_edit');
    }

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
    public function admin_edit($id = null) {
        $this->AgencyPhone->id = $id;
        if (!$this->AgencyPhone->exists()) {
            throw new NotFoundException(__('Invalid phone'));
        }
        $agency_id = $this->AgencyPhone->field('AgencyPhone.agency_id', array('AgencyPhone.id' => $id));
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->AgencyPhone->save($this->request->data)) {
                $this->Session->setFlash(__('The phone has been saved'));
                $this->redirect(array('controller' => 'agencies', 'action' => 'admin_edit', $agency_id));
            } else {
                $errors = $this->AgencyPhone->validationErrors;
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
            $this->request->data = $this->AgencyPhone->read(null, $id);
        }
        $this->set('agency_id', $agency_id);
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => 'Edit Phone '.$this->AgencyPhone->field('phone', array('AgencyPhone.id' => $id)), 'agency_id' => $agency_id)));
    }

/**
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
    public function admin_delete($id = null) {
        $this->AgencyPhone->id = $id;
        $agency_id = $this->AgencyPhone->field('agency_id', array('AgencyPhone.id' => $id));
        if (!$this->AgencyPhone->exists()) {
            throw new NotFoundException(__('Invalid phone'));
        }
        if ($this->AgencyPhone->delete()) {
            $this->Session->setFlash(__('Agency phone deleted'));
            $this->redirect(array('controller' => 'agencies', 'action' => 'admin_edit', $agency_id));
        }
        $this->Session->setFlash(__('Agency phone was not deleted'));
        $this->redirect(array('action' => ''));
    }
}
