<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
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
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
    $controllers = Cache::read('controllers_list');

    if ($controllers === false){
        $controllerList = App::objects('controller');
        foreach ($controllerList as $value){
            if ($value != 'AppController' && $value != 'ProgramsController'){
                $controllers[] = Inflector::underscore(substr($value, 0, -10));
            }
        }
        $controllers = implode('|', $controllers);  
        Cache::write('controllers_list', $controllers);  
    }

    Router::connect('/', array('controller' => 'programs', 'action' => 'index'));
    
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
    Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
    
    Router::connect('/admin', array('controller' => 'agencies', 'action' => 'index', 'admin' => TRUE));
    Router::connect('/admin/:controller/:action/*', array('admin' => TRUE));
    Router::connect('/admin/:controller/*', array('admin' => TRUE));
    
    Router::connect('/:controller/:action/*', array(), array('controller' => $controllers));
    Router::connect('/:action/*', array('controller' => 'programs'));
    
    /*Router::connect(
        '/programs/view/:slug', // E.g. /blog/3-CakePHP_Rocks
        array('controller' => 'program', 'action' => 'view'),
        array(
            // order matters since this will simply map ":id" to $articleId in your action
            'pass' => array('slug'),
        )
    );*/
/**
 * Load all plugin routes.  See the CakePlugin documentation on 
 * how to customize the loading of plugin routes.
 */
    CakePlugin::routes();

/**
 * Load the CakePHP default routes. Remove this if you do not want to use
 * the built-in default routes.
 */
    require CAKE . 'Config' . DS . 'routes.php';
