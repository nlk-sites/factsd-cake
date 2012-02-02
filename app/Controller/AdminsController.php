<?php
App::uses('AppController', 'Controller');
/**
 * Admins Controller
 *
 * @property Admin $Admin
 */
class AdminsController extends AppController {
    
    public $paginate = array(
        'limit' => 20,
        'maxLimit' => 99999,
        'sort' => 'first_name'
    );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('login', 'logout');
    }
    
    public function beforeRender(){
        parent::beforeRender();
        if($this->Auth->user('user_level_id') >= 2000){
            $this->set('sidebar', $this->Admin->getSidebarLinks($this->action, $this->name));
        }else{
            $this->set('sidebar', null);
        }
    }
    
    public function isAuthorized($admin) {
        if (parent::isAuthorized($admin)) {
            return true;
        }
        if (in_array($this->action, array('admin_edit'))) {
            $this->request->params['pass'][0] = $admin['id'];
            return TRUE;
        }
        return false;
    }

/**
 * admin_add method
 *
 * @return void
 */
    public function admin_add() {
        if ($this->request->is('post')) {
            if($this->request->data['Admin']['user_level_id'] != 500){
                unset($this->request->data['Admin']['agency_id']);
            }
            $this->Admin->create();
            if ($this->Admin->save($this->request->data)) {
                $this->Session->setFlash(__('The admin has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $errors = $this->Admin->validationErrors;
                if(isset($errors['password'])){
                    $this->Admin->invalidate('password2', '');
                }
                unset($this->request->data['Admin']['password']);
                unset($this->request->data['Admin']['password2']);
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
        $userLevels = $this->Admin->UserLevel->find('list');
        $agencies = $this->Admin->Agency->find('list', array('order' => array('Agency.name')));
        $this->set(compact('userLevels', 'agencies'));
        if($this->Auth->user('user_level_id') < 2000){
            $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => 'New User', 'no_agency' => TRUE, 'no_top_level' => TRUE)));
        }else{
            $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => 'New User', 'no_agency' => TRUE)));
        }
        $this->render('admin_edit');
    }
    
    public function login() {
        if($this->Auth->user()){
            $this->logout();
        }
        $this->layout = 'blank';
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->redirect($this->Auth->redirect());
            } else {
                $this->Session->setFlash(__('Invalid email or password'));
            }
        }
        if(isset($this->request->data['Admin']['password'])){
            unset($this->request->data['Admin']['password']);
        }
    }

    public function logout() {
        $this->Session->setFlash('You have been logged out', 'logout_flash');
        $this->redirect($this->Auth->logout());
    }
/**
 * admin_index method
 *
 * @return void
 */
    public function admin_index() {
        $this->Admin->recursive = 0;
        $this->set('admins', $this->paginate());
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => 'Users', 'no_agency' => TRUE)));
    }


/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
    public function admin_edit($id = null) {
        $this->Admin->id = $id;
        if (!$this->Admin->exists()) {
            throw new NotFoundException(__('Invalid admin'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Admin->save($this->request->data)) {
                $this->Session->setFlash(__('The admin has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $errors = $this->Admin->validationErrors;
                if(isset($errors['password'])){
                    $this->Admin->invalidate('password2', '');
                }
                unset($this->request->data['Admin']['password2']);
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
            $this->request->data = $this->Admin->read(null, $id);
        }
        unset($this->request->data['Admin']['password']);
        $userLevels = $this->Admin->UserLevel->find('list');
        $agencies = $this->Admin->Agency->find('list');
        $this->set(compact('userLevels', 'agencies'));
        $user_info = $this->Admin->find('first', array('conditions' => array('Admin.id' => $id), 'fields' => array('first_name', 'last_name')));
        if($this->Auth->user('user_level_id') < 2000){
            $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => 'My Account', 'no_agency' => TRUE, 'no_top_level' => TRUE)));
        }else{
            $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => $user_info['Admin']['first_name'].' '.$user_info['Admin']['last_name'], 'no_agency' => TRUE)));
        }
    }

/**
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
    public function admin_delete($id = null) {
        $this->Admin->id = $id;
        if (!$this->Admin->exists()) {
            throw new NotFoundException(__('Invalid admin'));
        }
        if ($this->Admin->delete()) {
            $this->Session->setFlash(__('Admin deleted'));
            $this->redirect(array('action'=>'index'));
        }
        $this->Session->setFlash(__('Admin was not deleted'));
        $this->redirect(array('action' => 'index'));
    }
}
