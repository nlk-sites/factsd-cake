<?php
App::uses('AppController', 'Controller');
/**
 * Regions Controller
 *
 * @property Region $Region
 */
class RegionsController extends AppController {

    public function beforeRender(){
        parent::beforeRender();
        $this->set('sidebar', $this->Region->ZipAlias->getSidebarLinks($this->action, $this->name));
    }

/**
 * admin_index method
 *
 * @return void
 */
    public function admin_index() {
        $this->Region->recursive = 0;
        $this->set('regions', $this->Region->find('all'));
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => 'Regions', 'no_agency' => TRUE)));
    }

/**
 * admin_add method
 *
 * @return void
 */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Region->create();
            if ($this->Region->save($this->request->data)) {
                $this->Session->setFlash(__('The region has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $errors = $this->Region->validationErrors;
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
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => 'New Region', 'no_agency' => TRUE)));
        $this->render('admin_edit');
    }

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
    public function admin_edit($id = null) {
        $this->Region->id = $id;
        if (!$this->Region->exists()) {
            throw new NotFoundException(__('Invalid region'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Region->save($this->request->data)) {
                $this->Session->setFlash(__('The region has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $errors = $this->Region->validationErrors;
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
            $this->request->data = $this->Region->read(null, $id);
        }
        $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => $this->Region->field('name', array('Region.id' => $id)), 'no_agency' => TRUE)));
    }

/**
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
    public function admin_delete($id = null) {
        $this->Region->id = $id;
        if (!$this->Region->exists()) {
            throw new NotFoundException(__('Invalid region'));
        }
        $zip_regions = $this->Region->find('first', array('conditions' => array('Region.id' => $id), 'contain' => array('ZipAlias' => array('fields' => array('id', 'name')), 'Zip')));
        if((isset($zip_regions['ZipAlias']) && !empty($zip_regions['ZipAlias'])) || (isset($zip_regions['Zip']) && !empty($zip_regions['Zip']))){
            $this->Session->setFlash('This region cannot be deleted because it is being used by one or more zip aliases or zipcodes.  Below are the zipcodes and zip aliases that have '.$zip_regions['Region']['name'].' listed as their region.');
            $this->set('zip_regions', $zip_regions);
            $this->set('breadcrumbs', $this->get_breadcrumbs(array('cur_title' => 'Can\'t Delete '.$zip_regions['Region']['name'], 'no_agency' => TRUE)));
        }else{
            if ($this->Region->delete()) {
                $this->Session->setFlash(__('Region deleted'));
                $this->redirect(array('action'=>'index'));
            }
            $this->Session->setFlash(__('Region was not deleted'));
            $this->redirect(array('action' => 'index'));
        }
    }
}
