<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * This is a placeholder class.
 * Create the same file in app/Controller/AppController.php
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       Cake.Controller
 * @link http://book.cakephp.org/view/957/The-App-Controller
 */
class AppController extends Controller {
    public $uses = array('Program');
    public $components = array(
        'Session',
        'Auth' => array(
            'userModel' => 'Admin',
            'loginAction' => 'admins/login',
            /*array(
                'controller' => 'admins',
                'action' => 'login',
//                'plugin' => 'users'
            ),*/
            'loginRedirect' => '/admin/agencies',
            'logoutRedirect' => array('controller' => 'admins', 'action' => 'login'),
            'authenticate' => array(
                'Form' => array('userModel' => 'Admin', 'fields' => array('username' => 'email')),
            ),
            'authorize' => array('controller'),
        )
    );

    function beforeFilter() {
        if (isset($this->params['prefix']) && $this->params['prefix'] == 'admin') {
            $this->layout = 'admin';
        } 
        $this->Auth->allow('index', 'view', 'display');
    }
    
    public function isAuthorized($admin) {
        if(!isset($admin['user_level_id'])){
            return FALSE;
        }
        $this->set('user_level', $admin['user_level_id']);
        if ($admin['user_level_id'] >= 2000) {
            return true; //Admin can access every action
        }
        return false; // The rest don't
    }
    
    function get_breadcrumbs($info=array()){
        $crumbs = array();
        $main_id = null;
        if(isset($info['cur_title'])){
            $crumbs[''] = $info['cur_title'];
        }
        if(isset($info['program_id'])){
            $program_data = $this->Program->find('first', array('conditions' => array('Program.id' => $info['program_id']), 'contain' => array('Agency')));
            $info['agency_id'] = $program_data['Program']['agency_id'];
            $crumbs['/admin/programs/edit/'.$info['program_id']] = $program_data['Program']['name'];
        }elseif($this->name == 'Programs'){
            $crumbs['/admin/programs'.(isset($info['agency_id']) && !empty($info['agency_id']) ? '/index/'.$info['agency_id'] : '')] = 'All Programs';
        }elseif(isset($info['zip_alias_id'])){
            $crumbs['/admin/zip_aliases/edit/'.$info['zip_alias_id']] = $this->ZipAlias->field('name', array('ZipAlias.id' => $info['zip_alias_id']));
        }
        if(isset($info['agency_id']) && !empty($info['agency_id'])){
            $crumbs['/admin/agencies/edit/'.$info['agency_id']] = $this->Program->Agency->field('name', array('Agency.id' => $info['agency_id']));
        }elseif(!isset($info['no_agency'])){
            $crumbs['/admin/agencies'] = 'All Agencies';
        }elseif(!isset($info['no_top_level']) && $this->action != 'admin_index'){
            if($this->name == 'ZipAliases'){
                $display_name = 'Zip Aliases';
            }elseif($this->name == 'ZipAliasTypes'){
                $display_name = 'Zip Alias Types';
            }elseif($this->name == 'AgencyTypes'){
                $display_name = 'Agency Types';
            }elseif($this->name == 'Admins'){
                $display_name = 'Users';
            }elseif($this->name == 'AgencyAliases'){
                $display_name = 'Agency Aliases';
            }elseif($this->name == 'EligReqs'){
                $display_name = 'Eligibility Requirements';
            }else{
                $display_name = $this->name;
            }
            $crumbs['/admin/'.$this->params->controller] = 'All '.$display_name;
        }
        $crumbs = array_reverse($crumbs, TRUE);
        $last_crumb = array_pop($crumbs);
        $crumbs[''] = $last_crumb;
        return $crumbs;
    }
}
