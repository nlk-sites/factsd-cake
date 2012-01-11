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
		'provider_type_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
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


}
