<?php
App::uses('AppModel', 'Model');
/**
 * ZipAliasType Model
 *
 * @property ZipAlias $ZipAlias
 */
class ZipAliasType extends AppModel {
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
                'message' => 'Please enter a name.',
            ),
            'maxlength' => array(
                'rule' => array('maxlength', 50),
                'message' => 'Please limit the name to fewer than 50 characters.',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'There is already a zip alias type by that name'
            )
        ),
        'abbreviation' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Please enter an abbreviation.',
            ),
            'maxlength' => array(
                'rule' => array('maxlength', 10),
                'message' => 'Please limit the abbreviation to fewer than 10 characters.',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'There is already a zip alias type with that abbreviation'
            )
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
        $zip_alias_types_raw = $this->find('all', array('contain' => array('ZipAlias' => array('Zip' => array('fields' => array('id'))))));
        $zip_alias_types = array();
        $zip_aliases = array();
        foreach($zip_alias_types_raw as $type){
            $zip_alias_types[$type['ZipAliasType']['id']] = $type['ZipAliasType']['name'];
            foreach($type['ZipAlias'] as $alias){
                if(!empty($alias['Zip'])){
                    $zip_aliases[$type['ZipAliasType']['id']][$alias['id']] = $alias['name'];
                }
            }
            sort($zip_aliases[$type['ZipAliasType']['id']]);
        }
        return array($zip_aliases, $zip_alias_types);
    }

}
