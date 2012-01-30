<?php
App::uses('AppModel', 'Model');
/**
 * Agency Model
 *
 * @property AgencyType $AgencyType
 * @property AgencyAlias $AgencyAlias
 * @property AgencyPhone $AgencyPhone
 * @property Program $Program
 */
class Agency extends AppModel {
    
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
                'message' => 'Please enter the agency\'s name',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'maxlength' => array(
                'rule' => array('maxlength', 50),
                'message' => 'Please limit the agency\'s name to no more than 50 characters',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'street1' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Please enter the agency\'s street address',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'maxlength' => array(
                'rule' => array('maxlength', 50),
                'message' => 'Please limit the street address to no more than 50 characters',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'city' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Please enter the agency\'s city',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'maxlength' => array(
                'rule' => array('maxlength', 50),
                'message' => 'Please limit the city to 50 characters',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'state' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Please enter the agency\'s state',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'maxlength' => array(
                'rule' => array('maxlength', 50),
                'message' => 'Please limit the state to 50 characters',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'zip' => array(
            'postal' => array(
                'rule' => array('postal', null, 'us'),
                'message' => 'Please enter a valid zipcode',
                'allowEmpty' => true,
            )
        ),
        'agency_type_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'message' => 'Please select the agency type',
                'allowEmpty' => false,
                'required' => true,
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
        'AgencyType' => array(
            'className' => 'AgencyType',
            'foreignKey' => 'agency_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

/**
 * hasMany associations
 *
 * @var array
 */
    public $hasMany = array(
        'AgencyAlias' => array(
            'className' => 'AgencyAlias',
            'foreignKey' => 'agency_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'AgencyPhone' => array(
            'className' => 'AgencyPhone',
            'foreignKey' => 'agency_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Program' => array(
            'className' => 'Program',
            'foreignKey' => 'agency_id',
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
        if($controller == 'AgencyTypes' || ($controller == 'Agencies' && in_array($action, array('admin_index', 'admin_add')))){
            $name = 'Agencies';
            $pages = array(
                'View Agencies' => array(
                    'link_data' => array(
                        'controller' => 'agencies',
                        'action' => 'admin_index',
                    ),
                    'subpages' => array(
                        'Add New Agency' => array(
                            'link_data' => array(
                                'controller' => 'agencies',
                                'action' => 'admin_add'
                            )
                        )
                    )
                ),
                'View Agency Types' => array(
                    'link_data' => array(
                        'controller' => 'agency_types',
                        'action' => 'admin_index',
                    ),
                    'subpages' => array(
                        'Add New Agency Type' => array(
                            'link_data' => array(
                                'controller' => 'agency_types',
                                'action' => 'admin_add'
                            )
                        )
                    )
                )
            );
        }else{
            $name = $extra['name'];
            $pages = array(
                'Agency Details' => array(
                    'link_data' => array(
                        'controller' => 'agencies',
                        'action' => 'admin_edit',
                        $extra['agency_id']
                    )
                ),
                'View Programs' => array(
                    'link_data' => array(
                        'controller' => 'programs',
                        'action' => 'admin_index',
                        $extra['agency_id']
                    ),
                    'subpages' => array(
                        'Add New Program' => array(
                            'link_data' => array(
                                'controller' => 'programs',
                                'action' => 'admin_add',
                                $extra['agency_id']
                            )
                        )
                    )
                ),
                'View Agency Aliases' => array(
                    'link_data' => array(
                        'controller' => 'agency_aliases',
                        'action' => 'admin_index',
                        $extra['agency_id']
                    ),
                    'subpages' => array(
                        'Add New Agency Alias' => array(
                            'link_data' => array(
                                'controller' => 'agency_aliases',
                                'action' => 'admin_add',
                                $extra['agency_id']
                            )
                        )
                    )
                )
            );
        }
        return compact('name', 'pages');
    }

}
