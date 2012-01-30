<?php
App::uses('AppController', 'Controller');
/**
 * AgencyAliases Controller
 *
 * @property AgencyAlias $AgencyAlias
 */
class AgencyAliasesController extends AppController {
    public $paginate = array(
        'limit' => 20,
        'maxLimit' => 99999
    );
    
    public function isAuthorized($admin) {
        if (parent::isAuthorized($admin)) {
            return true;
        }
        if($admin['user_level_id'] >= 1000){
            return true;
        }
        if (in_array($this->action, array('admin_add', 'admin_index'))) {
            $this->request->params['pass'][0] = $admin['agency_id'];
            return true;
        }
        if(isset($this->request->params['pass'][0])){
            return $this->AgencyAlias->isOwnedBy($this->request->params['pass'][0], $admin['agency_id']);
        }
        return false;
    }
    
    public function beforeRender(){
        $extra = array();
        if($this->action == 'admin_edit'){
            $extra['agency_id'] = $this->AgencyAlias->field('agency_id', array('AgencyAlias.id' => $this->request->params['pass'][0]));
        }else{
            $extra['agency_id'] = $this->request->params['pass'][0];
        }
        $extra['name'] = $this->AgencyAlias->Agency->field('name', array('Agency.id' => $extra['agency_id']));
        $this->set('sidebar', $this->AgencyAlias->Agency->getSidebarLinks($this->action, $this->name, $extra));
    }

/**
 * admin_index method
 *
 * @return void
 */
    public function admin_index($agency_id) {
        $this->AgencyAlias->Agency->id = $agency_id;
        if (!$this->AgencyAlias->Agency->exists()) {
            throw new NotFoundException(__('Invalid agency'));
        }
        $this->set('agency_data', $this->Program->Agency->find('first', array('conditions' => array('Agency.id' => $agency_id), 'recursive' => -1)));
        $this->AgencyAlias->recursive = -1;
        $this->paginate['conditions']['agency_id'] = $agency_id;
        $this->set('agency_aliases', $this->paginate());
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => 'Agency Aliases', 'agency_id' => $agency_id)));
    }

/**
 * admin_add method
 *
 * @return void
 */
    public function admin_add($agency_id) {
        $this->AgencyAlias->Agency->id = $agency_id;
        if (!$this->AgencyAlias->Agency->exists()) {
            throw new NotFoundException(__('Invalid agency'));
        }
        if ($this->request->is('post')) {
            $this->AgencyAlias->create();
            if ($this->AgencyAlias->save($this->request->data)) {
                $this->Session->setFlash(__('The agency alias has been saved'));
                $this->redirect(array('action' => 'index', $agency_id));
            } else {
                $errors = $this->AgencyAlias->validationErrors;
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
        $this->set('agency_data', $this->Program->Agency->find('first', array('conditions' => array('Agency.id' => $agency_id), 'recursive' => -1)));
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => 'New Agency Alias', 'agency_id' => $agency_id)));
        $this->render('admin_edit');
    }

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
    public function admin_edit($id = null) {
        $this->AgencyAlias->id = $id;
        if (!$this->AgencyAlias->exists()) {
            throw new NotFoundException(__('Invalid agency alias'));
        }
        $agency_id = $this->AgencyAlias->field('agency_id', array('AgencyAlias.id' => $id));
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->AgencyAlias->save($this->request->data)) {
                $this->Session->setFlash(__('The agency alias has been saved'));
                $this->redirect(array('action' => 'index', $agency_id));
            } else {
                $errors = $this->AgencyAlias->validationErrors;
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
            $this->request->data = $this->AgencyAlias->read(null, $id);
        }
        $this->set('agency_data', $this->Program->Agency->find('first', array('conditions' => array('Agency.id' => $agency_id), 'recursive' => -1)));
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => $this->AgencyAlias->field('name', array('AgencyAlias.id' => $id)), 'no_agency' => TRUE)));
    }

/**
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
    public function admin_delete($id = null) {
        $this->AgencyAlias->id = $id;
        if (!$this->AgencyAlias->exists()) {
            throw new NotFoundException(__('Invalid agency alias'));
        }
        $agency_id = $this->AgencyAlias->field('agency_id', array('AgencyAlias.id' => $id));
        if ($this->AgencyAlias->delete()) {
            $this->Session->setFlash(__('Agency alias was deleted'));
            $this->redirect(array('action'=>'admin_index', $agency_id));
        }
        $this->Session->setFlash(__('Agency alias was not deleted'));
        $this->redirect(array('action' => 'admin_index', $agency_id));
    }
}
