<?php
App::uses('AppController', 'Controller');
/**
 * ZipAliasTypes Controller
 *
 * @property ZipAliasType $ZipAliasType
 */
class ZipAliasTypesController extends AppController {

    public function beforeRender(){
        parent::beforeRender();
        $this->set('sidebar', $this->ZipAliasType->ZipAlias->getSidebarLinks($this->action, $this->name));
    }

/**
 * admin_index method
 *
 * @return void
 */
    public function admin_index() {
        $this->ZipAliasType->recursive = 0;
        $this->set('zipAliasTypes', $this->ZipAliasType->find('all'));
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => 'Zip Alias Types', 'no_agency' => TRUE)));
    }

/**
 * admin_add method
 *
 * @return void
 */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->ZipAliasType->create();
            if ($this->ZipAliasType->save($this->request->data)) {
                $this->Session->setFlash(__('The zip alias type has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $errors = $this->ZipAliasType->validationErrors;
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
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => 'New Zip Alias Type', 'no_agency' => TRUE)));
        $this->render('admin_edit');
    }

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
    public function admin_edit($id = null) {
        $this->ZipAliasType->id = $id;
        if (!$this->ZipAliasType->exists()) {
            throw new NotFoundException(__('Invalid zip alias type'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->ZipAliasType->save($this->request->data)) {
                $this->Session->setFlash(__('The zip alias type has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $errors = $this->ZipAliasType->validationErrors;
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
            $this->request->data = $this->ZipAliasType->read(null, $id);
        }
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => $this->ZipAliasType->field('name', array('ZipAliasType.id' => $id)), 'no_agency' => TRUE)));
    }

/**
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
    public function admin_delete($id = null) {
        $this->ZipAliasType->id = $id;
        if (!$this->ZipAliasType->exists()) {
            throw new NotFoundException(__('Invalid zip alias type'));
        }
        if ($this->ZipAliasType->delete()) {
            $this->Session->setFlash(__('Zip alias type deleted'));
            $this->redirect(array('action'=>'index'));
        }
        $this->Session->setFlash(__('Zip alias type was not deleted'));
        $this->redirect(array('action' => 'index'));
    }
}
