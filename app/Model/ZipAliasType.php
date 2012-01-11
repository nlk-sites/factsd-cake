<?php
App::uses('AppModel', 'Model');
/**
 * ZipAliasType Model
 *
 * @property ZipAlias $ZipAlias
 */
class ZipAliasType extends AppModel {
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
			'maxlength' => array(
				'rule' => array('maxlength'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'abbreviation' => array(
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
		'ZipAlias' => array(
			'className' => 'ZipAlias',
			'foreignKey' => 'zip_alias_type_id',
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

    function get_aliases(){
        $zip_alias_types_raw = $this->find('all');
        $zip_alias_types = array();
        $zip_aliases = array();
        foreach($zip_alias_types_raw as $type){
            $zip_alias_types[$type['ZipAliasType']['id']] = $type['ZipAliasType']['name'];
            foreach($type['ZipAlias'] as $alias){
                $zip_aliases[$type['ZipAliasType']['id']][$alias['id']] = $alias['name'];
            }
            sort($zip_aliases[$type['ZipAliasType']['id']]);
        }
        return array($zip_aliases, $zip_alias_types);
    }

}
