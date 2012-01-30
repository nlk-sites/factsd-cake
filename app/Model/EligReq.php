<?php
App::uses('AppModel', 'Model');
/**
 * EligReq Model
 *
 * @property EligReqOption $EligReqOption
 */
class EligReq extends AppModel {
    
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
        'name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'maxlength' => array(
                'rule' => array('maxlength'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
    public $hasMany = array(
        'EligReqOption' => array(
            'className' => 'EligReqOption',
            'foreignKey' => 'elig_req_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );
    
    public function getSidebarLinks($action, $controller, $extra = array()){
        $name = 'Eligibility Requirements';
        $pages = array(
            'View Eligibility Requirements' => array(
                'link_data' => array(
                    'controller' => 'elig_reqs',
                    'action' => 'admin_index'
                ),
                'subpages' => array(
                    'Add New Eligibility Req' => array(
                        'link_data' => array(
                            'controller' => 'elig_reqs',
                            'action' => 'admin_add'
                        )
                    )
                )
            ),
        );
        return compact('name', 'pages');
    }
    

}
