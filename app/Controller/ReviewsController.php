<?php
App::uses('AppController', 'Controller');
/**
 * Reviews Controller
 *
 * @property Review $Review
 */
class ReviewsController extends AppController {
    
    public $paginate = array(
        'limit' => 20,
        'maxLimit' => 99999,
        'sort' => 'name'
    );

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
        $this->set('sidebar', $this->Review->getSidebarLinks($this->action, $this->name));
    }

/**
 * admin_index method
 *
 * @return void
 */
    public function admin_index($approved = NULL) {
        if(isset($this->passedArgs['limit']) && $this->passedArgs['limit'] == 'all'){
            $this->request->params['named']['limit'] = 99999;
        }
        $this->Review->recursive = 0;
        if(!is_null($approved)){
            $approved = ($approved == 0 ? 0 : 1);
            $this->set('approved', $approved);
            $this->paginate['conditions']['approved'] = $approved;
        }
        $this->paginate['contain'] = array('Program' => array('fields' => array('id', 'name')));
        $this->set('reviews', $this->paginate());
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => (!is_null($approved) ? ($approved == 1 ? 'Approved Reviews' : 'Reviews Awaiting Approval') : 'All Reviews'), 'no_agency' => TRUE)));
    }

/**
 * admin_add method
 *
 * @return void
 */
    public function add() {
        if ($this->request->is('post')) {
            if(isset($this->request->data['Review']['program_id'])){
                $program_id = $this->request->data['Review']['program_id'];
            }
            $this->Review->create();
            if ($this->Review->save($this->request->data)) {
                $this->Session->setFlash(__('The review has been submitted and will be viewable once it is approved.'));
            } else {
                $errors = $this->Review->validationErrors;
                $msg = array();
                if(!empty($errors)){
                    foreach($errors as $e){
                        $msg = array_merge($msg, $e);
                    }
                    $this->Session->setFlash('Please correct the following error'.(count($msg) > 1 ? 's' : '').':<ul><li>'.implode($msg, '</li><li>').'</li></ul>');
                }else{
                    $this->Session->setFlash('There was an error saving your review.');
                }
            }
            if(isset($this->request->data['Review']['program_id'])){
                $this->redirect(array('controller' => 'programs', 'action' => 'view', $this->request->data['Review']['program_id']));
            }else{
                $this->redirect(array('controller' => 'programs', 'action' => 'index'));
            }
        }else{
            $this->redirect(array('controller' => 'programs', 'action' => 'index'));
        }
    }

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
    public function admin_edit($id = null) {
        $this->Review->id = $id;
        if (!$this->Review->exists()) {
            throw new NotFoundException(__('Invalid review'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Review->save($this->request->data)) {
                $this->Session->setFlash(__('The review has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $errors = $this->Review->validationErrors;
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
            $this->request->data = $this->Review->read(null, $id);
        }
        $review = $this->Review->read(null, $id);
        $programs = $this->Review->Program->find('list');
        $this->set(compact('programs', 'review'));
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => 'Review of '.$review['Program']['name'].' by '.$review['Review']['name'], 'no_agency' => TRUE)));
    }

/**
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
    public function admin_delete($id = null) {
        $this->Review->id = $id;
        if (!$this->Review->exists()) {
            throw new NotFoundException(__('Invalid review'));
        }
        if ($this->Review->delete()) {
            $this->Session->setFlash(__('Review deleted'));
            $this->redirect(array('action'=>'index'));
        }
        $this->Session->setFlash(__('Review was not deleted'));
        $this->redirect(array('action' => 'index'));
    }
}
