<?php
App::uses('AppModel', 'Model');
/**
 * Zip Model
 *
 * @property Region $Region
 * @property ZipAlias $ZipAlias
 */
class Zip extends AppModel {
    public $actsAs = array('Containable');
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'area_name';
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'region_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'area_name' => array(
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
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
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
		'ZipAlias' => array(
			'className' => 'ZipAlias',
			'joinTable' => 'zip_aliases_zips',
			'foreignKey' => 'zip_id',
			'associationForeignKey' => 'zip_alias_id',
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
    function get_geocode_zip($address, $type){
        $geocode_url = 'http://maps.googleapis.com/maps/api/geocode/xml?address='.$address.'&sensor=false&region=us&bounds=32.455698,-117.712778|33.591817,-115.887793';
        $xml = simplexml_load_file($geocode_url);
        $status = (string)$xml->status;
        if($xml->result){
            $all_results = count($xml->result) - 1;
            for($i = $all_results; $i >= 0; $i--){
                $lng = (string) $xml->result[$i]->geometry->location->lng;
                $lat = (string) $xml->result[$i]->geometry->location->lat;
                if($lng > -114.45 || $lng < -117.612778 || $lat > 33.491817 || $lat < 32.533333){
                    unset($xml->result[$i]);
                }elseif($xml->result->partial_match && $xml->result->formatted_address == $address){
                    unset($xml->result[$i]->partial_match);
                }
            }
            if(count($xml->result) == 0){
                $status = 'ZERO_RESULTS';
            }
        }
        if(count($xml->result) > 1 || $xml->result->partial_match){
            $all_addresses = array();
            foreach($xml->result as $r){
                $all_addresses[] = (string)$r->formatted_address;
            }
            return array(1, '<span style="color:red;">We couldn\'t understand the '.($type == 'origin' ? 'pick up location' : $type).' you entered.</span><p/><p>Make sure all names are spelled correctly and are within our service area.<p/><p>Try adding a city, state, or zip code.', null, $all_addresses);
        }
        $formatted_address = (string)$xml->result->formatted_address;
        $error = 0;
        $msg = '';
        $zip = '';
        if(!$xml){
            $error = 1;
            $msg = 'There was an error processing your request';
        }else{
            switch($status){
                case 'OK':
                    if($xml->result->partial_match && $xml->result->formatted_address != $address){
                        $msg = 'Did you mean '.$xml->result->formatted_address.'?';
                    }
                    $zip = (string)reset($xml->result->xpath("//address_component[contains(type, 'postal_code')]/short_name"));
                    break;
                case 'ZERO_RESULTS':
                    $error = 1;
                    $msg = '<span style="color:red;">We couldn\'t understand the '.($type == 'origin' ? 'pick up location' : $type).' you entered.</span><p/><p>Make sure all names are spelled correctly and are within our service area.<p/><p>Try adding a city, state, or zip code.';
                    break;
                case 'OVER_QUERY_LIMIT':
                    $error = 1;
                    $msg = 'There was an error processing your request.  Please contact the website administrator.';
//TODO: ADD EMAIL IF THE DAILY LIMIT IS REACHED
                    break;
                default:
                    $error = 1;
                    $msg = 'There was an error processing your request';
                    break;
            }
        }
        return array($error, $msg, $zip, $formatted_address);
    }

}
