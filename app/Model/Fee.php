<?php
App::uses('AppModel', 'Model');
/**
 * Fee Model
 *
 * @property Program $Program
 */
class Fee extends AppModel {
    public $actsAs = array('Containable');
/**
 * Display field
 *
 * @var string
 */
    public $displayField = 'fee';
/**
 * Validation rules
 *
 * @var array
 */
    public $validate = array(
        'program_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'notempty' => array(
                'rule' => array('notempty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'fee' => array(
            'no_dollar_sign' => array(
                'rule' => array('noDollarSign'),
                'message' => 'Please do not include a dollar sign.'
            ),
            'money' => array(
                'rule' => '/^\d{0,6}(\.\d{1,2})?$/',
                'message' => 'Please enter a monetary value with no more than 6 digits before the decimal or 2 digits after.'
            ),
            'not_free' => array(
                'rule' => array('not_free'),
                'message' => 'Please enter a fee or select Free as the Fee Type'
            )
        ),
        'per_mile' => array(
            'no_dollar_sign' => array(
                'rule' => array('noDollarSign'),
                'message' => 'Please do not include a dollar sign.'
            ),
            'money' => array(
                'rule' => '/^\d{0,6}(\.\d{1,2})?$/',
                'message' => 'Please enter a monetary amount with no more than 6 digits before the decimal or 2 digits after.'
            )
        ),
        'miles_included' => array(
            'money' => array(
                'rule' => '/^\d{0,6}(\.\d{1,2})?$/',
                'message' => 'Please enter a numeric value with no more than 6 digits before the decimal or 2 digits after.'
            )
        ),
    );
    
    function noDollarSign($val){
        return strpos(reset($val), '$') === FALSE;
    }

    //The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
   // public $hasOne = array(
        
    //);
    public $belongsTo = array(
        'Program' => array(
            'className' => 'Program',
            'foreignKey' => 'program_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    
    function afterFind($results, $primary=false){
        foreach ($results as $key => $val) {
            if (isset($val['Fee']['miles_included'])) {
                $results[$key]['Fee']['miles_included'] = $this->trim_miles($val['Fee']['miles_included']);
            }elseif(isset($val['miles_included'])){
                $results[$key]['miles_included'] = $this->trim_miles($val['miles_included']);
            }
        }
        return $results;
    }
    
    function trim_miles($val){
        return trim(trim($val, '0'), '.');
    }
    
    function beforeValidate(){
        if(isset($this->data['Fee'])){
            $edit_data =& $this->data['Fee'];
        }elseif(isset($this->data['fee_type_id'])){
            $edit_data =& $this->data;
        }
        if(isset($edit_data)){
            if($edit_data['fee_type_id'] != 10){
                $edit_data['misc_fee'] = NULL;
            }
            if($edit_data['fee_type_id'] != 8){
                $edit_data['per_mile'] = 0;
                $edit_data['miles_included'] = 0;
                if(in_array($edit_data['fee_type_id'], array(9, 10))){
                    $edit_data['fee'] = 0;
                }
            }
        }
        return TRUE;
    }
    
    function get_program_id($fee_id){
        return $this->field('program_id', array('Fee.id' => $fee_id));
    }
    
    function get_program_fees($program_id, $show_type=FALSE){
        $this->bindModel(array('belongsTo' => array('FeeType')));
        $fees = $this->find('all', array('conditions' => array('Fee.program_id' => $program_id), 'contain' => array('FeeType')));
        foreach($fees as &$f){
            $fee = '';
            switch($f['Fee']['fee_type_id']){
                case 1:
                    $fee = ($show_type ? 'Flat fare each way: $' : '$').number_format($f['Fee']['fee'], 2);
                    break;
                case 2:
                    $fee = ($show_type ? 'Flat fare round trip: $' : '$').number_format($f['Fee']['fee'], 2);
                    break;
                case 3:
                    $fee = '$'.number_format($f['Fee']['fee'], 2).($show_type ? ' per hour' : '');
                    break;
                case 4:
                    $fee = '$'.number_format($f['Fee']['fee'], 2).($show_type ? ' per day' : '');
                    break;
                case 5:
                    $fee = '$'.number_format($f['Fee']['fee'], 2).($show_type ? ' per month' : '');
                    break;
                case 6:
                    $fee = '$'.number_format($f['Fee']['fee'], 2).($show_type ? ' per year' : '');
                    break;
                case 7:
                    $fee = ($show_type ? 'Wait time: $' : '$').number_format($f['Fee']['fee'], 2).' per hour';
                    break;
                case 8:
                    if(!empty($f['Fee']['fee']) && $f['Fee']['fee'] != 0){
                        $fee = '$'.number_format($f['Fee']['fee'], 2);
                        if(!empty($f['Fee']['miles_included'])){
                            $fee .= ' for the first '.$f['Fee']['miles_included'].' miles, and then ';
                        }else{
                            $fee .= ' flat fee plus ';
                        }
                    }
                    if(!empty($f['Fee']['per_mile']) && $f['Fee']['per_mile'] != 0){
                        $fee .= '$'.number_format($f['Fee']['per_mile'], 2).' per mile';
                    }
                    break;
                case 9:
                    $fee = 'No Fee';
                    break;
                case 10:
                    if(empty($f['Fee']['misc_fee']) || $f['Fee']['misc_fee'] == $f['Fee']['description']){
                        if($show_type){
                            $f['Fee']['misc_fee'] = $f['Fee']['description'];
                            $f['Fee']['description'] = '';
                        }
                    }
                    $fee = $f['Fee']['misc_fee'];
                    break;
            }
            $f['Fee']['fee'] = $fee;
        }
        return $fees;
    }
    
    public function isOwnedBy($fee_id, $agency_id) {
        return ($this->Program->find('count', array('conditions' => array('Program.agency_id' => $agency_id), 'recursive' => -1, 'joins' => array(array('table' => 'fees', 'alias' => 'Fee', 'type' => 'inner', 'conditions' => array('Fee.program_id = Program.id', 'Fee.id' => $fee_id))))) > 0);
    }
    
    public function not_free($field = array()){
        if(empty($field['fee']) && isset($this->data[$this->alias]['fee_type_id']) && !in_array($this->data[$this->alias]['fee_type_id'], array(9, 10))){
            return false;
        }
        return true;
    }
}
