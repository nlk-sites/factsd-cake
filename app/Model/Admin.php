<?php
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');
/**
 * Admin Model
 *
 * @property UserLevel $UserLevel
 */
class Admin extends AppModel {
/**
 * Display field
 *
 * @var string
 */
    public $displayField = 'email';
/**
 * Validation rules
 *
 * @var array
 */
    public $validate = array(
        'first_name' => array(
            'maxlength' => array(
                'rule' => array('maxlength', 30),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'last_name' => array(
            'maxlength' => array(
                'rule' => array('maxlength', 30),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'email' => array(
            'maxlength' => array(
                'rule' => array('maxlength', 100),
                'message' => 'Please limit your email to 100 characters',
                'allowEmpty' => false,
                'required' => true,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Please enter an email address',
                'allowEmpty' => false,
                'required' => true,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'email' => array(
                'rule' => array('email'),
                'message' => 'Please enter an email address',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'isUnique' => array(
                'rule' => array('isUnique'),
                'message' => 'This email already exists in the system'
            )
        ),
        'password' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Please enter a password',
                //'allowEmpty' => false,
                'required' => true,
                //'last' => false, // Stop validation after this rule
                'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'match_passwords' => array(
                'rule' => array('match_passwords', 'password2'),
                'message' => 'The passwords you entered do not match'
            )
        ),
        'active' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'message' => 'Please state whether this user is active',
                //'allowEmpty' => false,
                //'required' => true,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'user_level_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'message' => 'Please select the user\'s permissions level',
                'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'agency_id' => array(
            'check_user_level' => array(
                'rule' => array('check_user_level'),
                'message' => 'Please select an agency for this user',
                //'allowEmpty' => false,
            )
        )
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
    public $belongsTo = array(
        'UserLevel' => array(
            'className' => 'UserLevel',
            'foreignKey' => 'user_level_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Agency'
    );
    
    public function beforeSave() {
        if(isset($this->data[$this->alias]['password2'])){
            unset($this->data[$this->alias]['password2']);
        }
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
        if(isset($this->data[$this->alias]['user_level_id']) && $this->data[$this->alias]['user_level_id'] > 500){
            $this->data[$this->alias]['agency_id'] = null;
        }
        return true;
    }
    
    public function getSidebarLinks($action, $controller, $extra = array()){
        $name = 'Users';
        $pages = array(
            'View Users' => array(
                'link_data' => array(
                    'controller' => 'admins',
                    'action' => 'admin_index'
                ),
                'subpages' => array(
                    'Add New User' => array(
                        'link_data' => array(
                            'controller' => 'admins',
                            'action' => 'admin_add'
                        )
                    )
                )
            ),
        );
        return compact('name', 'pages');
    }
    
    public function match_passwords( $field=array(), $compare_field=null ) {
        foreach( $field as $key => $value ){
            $v1 = $value;
            $v2 = $this->data[$this->alias][ $compare_field ];                 
            if($v1 !== $v2) {
                return FALSE;
            } else {
                continue;
            }
        }
        return TRUE;
    }
    
    public function check_user_level($field = array()){
        if(isset($this->data[$this->alias]['user_level_id']) && empty($field['agency_id']) && $this->data[$this->alias]['user_level_id'] <= 500){
            return false;
        }
        return true;
    }
}
