<?php
App::uses('AppModel', 'Model');
/**
 * Review Model
 *
 * @property Program $Program
 */
class Review extends AppModel {
    
    public $actsAs = array('Containable');
/**
 * Display field
 *
 * @var string
 */
    public $displayField = 'name';
/**
 * Validation rules
 *
 * @var array
 */
    public $validate = array(
        'program_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'message' => 'Please select a program for this review.',
                'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'name' => array(
            'maxlength' => array(
                'rule' => array('maxlength', 45),
                'message' => 'Please enter a name no more than 45 characters.',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Please enter a name.',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'review' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Please enter a review.',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
    public $belongsTo = array(
        'Program' => array(
            'className' => 'Program',
            'foreignKey' => 'program_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    
    public function getSidebarLinks($action, $controller, $extra = array()){
        $name = 'Reviews';
        $pages = array(
            'All Reviews ('.$this->find('count').')' => array(
                'link_data' => array(
                    'controller' => 'reviews',
                    'action' => 'admin_index'
                ),
                'first_param' => FALSE
            ),
            'Approved ('.$this->find('count', array('conditions' => array('Review.approved' => 1))).')' => array(
                'link_data' => array(
                    'controller' => 'reviews',
                    'action' => 'admin_index',
                    1
                ),
                'first_param' => 1
            ),
            'Awaiting Approval ('.$this->find('count', array('conditions' => array('Review.approved' => 0))).')' => array(
                'link_data' => array(
                    'controller' => 'reviews',
                    'action' => 'admin_index',
                    0
                ),
                'first_param' => 0
            )
        );
        return compact('name', 'pages');
    }
}
