<?php
App::uses('AppModel', 'Model');
/**
 * AgencyPhone Model
 *
 * @property Agency $Agency
 */
class AgencyPhone extends AppModel {
/**
 * Display field
 *
 * @var string
 */
    public $displayField = 'phone';
/**
 * Validation rules
 *
 * @var array
 */
    public $validate = array(
        'phone' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Please enter a phone number',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'maxlength' => array(
                'rule' => array('maxlength', 20),
                'message' => 'Please limit the phone number to no more than 20 characters',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'type' => array(
            'maxlength' => array(
                'rule' => array('maxlength', 50),
                'message' => 'Please limit the phone type to no more than 50 characters',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'note' => array(
            'maxlength' => array(
                'rule' => array('maxlength', 100),
                'message' => 'Please limit the note to no more than 100 characters',
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
        'Agency' => array(
            'className' => 'Agency',
            'foreignKey' => 'agency_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    
    public function isOwnedBy($agency_phone_id, $agency_id) {
        return $this->hasAny(array('id' => $agency_phone_id, 'agency_id' => $agency_id));
    }
}
