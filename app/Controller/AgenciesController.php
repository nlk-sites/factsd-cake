<?php
App::uses('AppController', 'Controller');
/**
 * Agencies Controller
 *
 * @property Agency $Agency
 */
class AgenciesController extends AppController {
    
    public $paginate = array(
        'limit' => 20,
        'maxLimit' => 99999,
        'sort' => 'name'
    );
    
    public function beforeFilter() {
        parent::beforeFilter();
    }
    
    public function isAuthorized($admin) {
        if (parent::isAuthorized($admin)) {
            return true;
        }
        if (in_array($this->action, array('admin_edit'))) {
            if($admin['user_level_id'] == 500){
                $this->request->params['pass'][0] = $admin['agency_id'];
            }
            return true;
        }
        if ($admin['user_level_id'] >= 1000 && $this->action == 'admin_index') {
            return true;
            //$postId = $this->request->params['pass'][0];
            //return $this->Post->isOwnedBy($postId, $user['id']);
        }
        return false;
    }
    
    public function beforeRender(){
        parent::beforeRender();
        $extra = array();
        if($this->action == 'admin_edit'){
            $agency_data = $this->Agency->find('first', array('conditions' => array('Agency.id' => $this->request->params['pass'][0]), 'contain' => array('AgencyPhone')));
            $this->set('agency_data', $agency_data);
            $extra['name'] = $agency_data['Agency']['name'];
            $extra['agency_id'] = $this->request->params['pass'][0];
        }
        $this->set('sidebar', $this->Agency->getSidebarLinks($this->action, $this->name, $extra));
    }

/**
 * admin_index method
 *
 * @return void
 */
    public function admin_index() {
        $this->Agency->recursive = 0;
        $this->set('agencies', $this->paginate());
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => 'Agencies', 'no_agency' => TRUE)));
    }

/**
 * admin_add method
 *
 * @return void
 */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Agency->create();
            if ($this->Agency->save($this->request->data)) {
                $this->Session->setFlash(__('The agency has been saved'));
                $this->redirect(array('action' => 'edit', $this->Agency->getInsertID()));
            } else {
                $errors = $this->Agency->validationErrors;
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
        $agencyTypes = $this->Agency->AgencyType->find('list');
        $this->set(compact('agencyTypes'));
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => 'New Agency')));
        $this->render('admin_edit');
    }

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
    public function admin_edit($id = null) {
        $this->Agency->id = $id;
        if (!$this->Agency->exists()) {
            throw new NotFoundException(__('Invalid agency'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Agency->save($this->request->data)) {
                $this->Session->setFlash(__('The agency has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $errors = $this->Agency->validationErrors;
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
            $this->request->data = $this->Agency->read(null, $id);
        }
        $phones = $this->Agency->AgencyPhone->find('all', array('conditions' => array('AgencyPhone.agency_id' => $id), 'recursive' => -1));
        $agencyTypes = $this->Agency->AgencyType->find('list');
        $this->set(compact('agencyTypes', 'phones'));
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('agency_id' => $id)));
    }

/**
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
    public function admin_delete($id = null) {
        $this->Agency->id = $id;
        if (!$this->Agency->exists()) {
            throw new NotFoundException(__('Invalid agency'));
        }
        $this->Agency->bindModel(array('hasMany' => array('Admin' => array('className' => 'Admin'))));
        $agency_del_data = $this->Agency->find('first', array('conditions' => array('Agency.id' => $id), 'fields' => array('id', 'name'), 'contain' => array('Program' => array('fields' => array('id', 'name')), 'Admin' => array('fields' => array('first_name', 'last_name', 'email', 'id')))));
        if((isset($agency_del_data['Program']) && !empty($agency_del_data['Program'])) || (isset($agency_del_data['Admin']) && !empty($agency_del_data['Admin']))){
            $this->Session->setFlash('This agency cannot be deleted because it is being used by one or more programs or users.  Below are the programs and users that have '.$agency_del_data['Agency']['name'].' listed as their agency.');
            $this->set('agency_del_data', $agency_del_data);
            $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => 'Can\'t Delete '.$agency_del_data['Agency']['name'], 'no_agency' => TRUE)));
        }else{
            if ($this->Agency->delete($id, TRUE)) {
                $this->Session->setFlash(__('Agency deleted'));
                $this->redirect(array('action'=>'index'));
            }
            $this->Session->setFlash(__('Agency was not deleted'));
            $this->redirect(array('action' => 'index'));
        }
    }
}
