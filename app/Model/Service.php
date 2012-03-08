<?php
App::uses('AppModel', 'Model');
/**
 * Service Model
 *
 * @property Program $Program
 */
class Service extends AppModel {
/**
 * Display field
 *
 * @var string
 */
    public $displayField = 'name';
    
    public $actsAs = array('Containable');
    
/**
 * Validation rules
 *
 * @var array
 */
    public $validate = array(
        'name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Please enter the service name.',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'maxlength' => array(
                'rule' => array('maxlength', 50),
                'message' => 'Please keep the service name under 50 characters.',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
    public $hasAndBelongsToMany = array(
        'Program' => array(
            'className' => 'Program',
            'joinTable' => 'programs_services',
            'foreignKey' => 'service_id',
            'associationForeignKey' => 'program_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        )
    );
    
    public function getSidebarLinks($action, $controller, $extra = array()){
        $name = 'Services';
        $pages = array(
            'View Services' => array(
                'link_data' => array(
                    'controller' => 'services',
                    'action' => 'admin_index'
                ),
                'subpages' => array(
                    'Add New Service' => array(
                        'link_data' => array(
                            'controller' => 'services',
                            'action' => 'admin_add'
                        )
                    )
                )
            ),
        );
        return compact('name', 'pages');
    }

}
