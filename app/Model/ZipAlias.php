<?php
App::uses('AppModel', 'Model');
/**
 * ZipAlias Model
 *
 * @property ZipAliasType $ZipAliasType
 * @property Region $Region
 * @property Zip $Zip
 */
class ZipAlias extends AppModel {
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
                'message' => 'Please enter a zip alias name',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'maxlength' => array(
                'rule' => array('maxlength', 50),
                'message' => 'Please limit the zip alias name to no more than 50 characters',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'There is already a zip alias by that name'
            )
        ),
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
    public $belongsTo = array(
        'ZipAliasType' => array(
            'className' => 'ZipAliasType',
            'foreignKey' => 'zip_alias_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Region' => array(
            'className' => 'Region',
            'foreignKey' => 'region_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
    public $hasAndBelongsToMany = array(
        'Zip' => array(
            'className' => 'Zip',
            'joinTable' => 'zip_aliases_zips',
            'foreignKey' => 'zip_alias_id',
            'associationForeignKey' => 'zip_id',
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

    public $hasMany = array(
        'ZipAliasesZip' => array()
    );
    
    
    
    
    public function getSidebarLinks($action, $controller, $extra = array()){
        $name = 'Zip Aliases';
        $pages = array(
            'View Zip Aliases' => array(
                'link_data' => array(
                    'controller' => 'zip_aliases',
                    'action' => 'admin_index',
                ),
                'first_param' => FALSE,
                'subpages' => array(
                    'Add New Zip Alias' => array(
                        'link_data' => array(
                            'controller' => 'zip_aliases',
                            'action' => 'admin_add'
                        )
                    )
                )
            ),
            'View Zip Alias Types' => array(
                'link_data' => array(
                    'controller' => 'zip_alias_types',
                    'action' => 'admin_index',
                ),
                'subpages' => array(
                    'Add New Zip Alias Type' => array(
                        'link_data' => array(
                            'controller' => 'zip_alias_types',
                            'action' => 'admin_add'
                        )
                    )
                )
            ),
            'View Regions' => array(
                'link_data' => array(
                    'controller' => 'regions',
                    'action' => 'admin_index',
                ),
                'subpages' => array(
                    'Add New Region' => array(
                        'link_data' => array(
                            'controller' => 'regions',
                            'action' => 'admin_add'
                        )
                    )
                )
            )
        );
        if(isset($extra['problem_zip_aliases']) && $extra['problem_zip_aliases'] > 0){
            $pages = array_merge(array( 'Problem Zip Aliases ('.$extra['problem_zip_aliases'].')' => array(
                'link_data' => array(
                    'controller' => 'zip_aliases',
                    'action' => 'admin_index',
                    1
                ),
                'first_param' => 1
                )), $pages);
        }
        return compact('name', 'pages');
    }
    
    function findProblems(){
        $zip_alias_zips = $this->ZipAliasesZip->find('list', array('fields' => array('ZipAliasesZip.zip_alias_id', 'ZipAliasesZip.zip_alias_id')));
        $duplicate_names = $this->find('all', array('group' => 'ZipAlias.name HAVING count(*) > 1', 'recursive' => -1, 'fields' => array('GROUP_CONCAT(ZipAlias.id) as duplicate_id')));
        $problem_ids = array();
        if(!empty($duplicate_names)){
            foreach($duplicate_names as $d){
                $problem_ids = array_merge($problem_ids, explode(',', $d[0]['duplicate_id']));
            }
        }
        $zip_alias_zips = array_unique(array_diff($zip_alias_zips, $problem_ids));
        sort($zip_alias_zips);
        return array_unique($zip_alias_zips);
    }

}
