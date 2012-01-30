<?php
App::uses('AppModel', 'Model');
/**
 * Program Model
 *
 * @property Fee $Fee
 * @property Agency $Agency
 * @property ProviderType $ProviderType
 * @property ProgramDestZip $ProgramDestZip
 * @property ProgramOrigZip $ProgramOrigZip
 * @property EligReqOption $EligReqOption
 * @property SearchRequest $SearchRequest
 * @property Service $Service
 */
class Program extends AppModel {

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
        'agency_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Please enter a program name.',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'maxlength' => array(
                'rule' => array('maxlength', 50),
                'message' => 'Please enter a program name no more than 50 characters long',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'advance_reservation' => array(
            'boolean' => array(
                'rule' => array('boolean'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'open_hours_24_7' => array(
            'boolean' => array(
                'rule' => array('boolean'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'accept_insurance' => array(
            'boolean' => array(
                'rule' => array('boolean'),
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
 * hasOne associations
 *
 * @var array
 */
    public $hasOne = array(
        'ProgramDestZip' => array(
            'className' => 'ProgramDestZip',
            'foreignKey' => 'program_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'type' => 'INNER'
        ),
        'ProgramOrigZip' => array(
            'className' => 'ProgramOrigZip',
            'foreignKey' => 'program_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'type' => 'INNER'
        )
    );

/**
 * belongsTo associations
 *
 * @var array
 */
    public $belongsTo = array(
        'Agency' => array(
            'className' => 'Agency',
            'foreignKey' => 'agency_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'type' => 'INNER'
        ),
    );

/**
 * hasMany associations
 *
 * @var array
 */
    public $hasMany = array(
        'Fee' => array(
            'className' => 'Fee',
            'foreignKey' => 'program_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        /*
        'ProgramDestZip' => array(
            'className' => 'ProgramDestZip',
            'foreignKey' => 'program_id',
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
        'ProgramOrigZip' => array(
            'className' => 'ProgramOrigZip',
            'foreignKey' => 'program_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )*/
    );


/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
    public $hasAndBelongsToMany = array(
        'EligReqOption' => array(
            'className' => 'EligReqOption',
            'joinTable' => 'elig_req_options_programs',
            'foreignKey' => 'program_id',
            'associationForeignKey' => 'elig_req_option_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ),
        'SearchRequest' => array(
            'className' => 'SearchRequest',
            'joinTable' => 'programs_search_requests',
            'foreignKey' => 'program_id',
            'associationForeignKey' => 'search_request_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ),
        'Service' => array(
            'className' => 'Service',
            'joinTable' => 'programs_services',
            'foreignKey' => 'program_id',
            'associationForeignKey' => 'service_id',
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
    
    public function isOwnedBy($program_id, $agency_id) {
        return $this->hasAny(array('id' => $program_id, 'agency_id' => $agency_id));
    }
    
    public function beforeSave($options){
        if(isset($this->data['Program']['name']) && !empty($this->data['Program']['name'])){
            $this->data['Program']['slug'] = $this->slugify($this->data['Program']['name'], (isset($this->data['Program']['id']) && !empty($this->data['Program']['id']) ? $this->data['Program']['id'] : NULL));
        }
        return true;
    }
    
    public function slugify($name, $id=null){
        $name = Inflector::slug($name);
        $name = strtolower($name);
        $i = 1;
        $conditions = array('Program.slug' => $name);
        if(!empty($id)){
            $conditions['Program.id <>'] = $id;
        }
        while($this->hasAny($conditions)){
            $conditions['Program.slug'] = $name.'_'.$i++;
        }
        $name = $conditions['Program.slug'];
        return $name;
    }
    
    public function getSidebarLinks($action, $controller, $extra = array()){
        if(isset($extra['program_id'])){
            $name = $this->field('name', array('Program.id' => $extra['program_id']));
            $pages = array(
                'Program Details' => array(
                    'link_data' => array(
                        'controller' => 'programs',
                        'action' => 'admin_edit',
                        $extra['program_id']
                    )
                ),
                'Origin Zips' => array(
                    'link_data' => array(
                        'controller' => 'programs',
                        'action' => 'admin_zips',
                        $extra['program_id'],
                        'origin'
                    ),
                    'second_param' => 'origin'
                ),
                'Destination Zips' => array(
                    'link_data' => array(
                        'controller' => 'programs',
                        'action' => 'admin_zips',
                        $extra['program_id'],
                        'destination'
                    ),
                    'second_param' => 'destination'
                ),
                'View Fees' => array(
                    'link_data' => array(
                        'controller' => 'fees',
                        'action' => 'admin_index',
                        $extra['program_id']
                    ),
                    'subpages' => array(
                        'Add New Fee' => array(
                            'link_data' => array(
                                'controller' => 'fees',
                                'action' => 'admin_add',
                                $extra['program_id']
                            )
                        )
                    )
                ),
                'Program Eligibility' => array(
                    'link_data' => array(
                        'controller' => 'programs',
                        'action' => 'admin_elig',
                        $extra['program_id']
                    )
                ),
                'Program Services' => array(
                    'link_data' => array(
                        'controller' => 'programs',
                        'action' => 'admin_services',
                        $extra['program_id']
                    )
                )
            );
        }else{
            $name = 'Programs';
            $pages = array(
                'View Programs' => array(
                    'link_data' => array(
                        'controller' => 'programs',
                        'action' => 'admin_index',
                    ),
                    'subpages' => array(
                        'Add New Program' => array(
                            'link_data' => array(
                                'controller' => 'programs',
                                'action' => 'admin_add'
                            )
                        )
                    )
                )
            );
        }
        return compact('name', 'pages');
    }
    
}
