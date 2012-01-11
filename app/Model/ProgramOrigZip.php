<?php
App::uses('AppModel', 'Model');
/**
 * ProgramOrigZip Model
 *
 * @property Program $Program
 * @property Zip $Zip
 */
class ProgramOrigZip extends AppModel {

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Program' => array(
			'className' => 'Program',
			'foreignKey' => 'program_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Zip' => array(
			'className' => 'Zip',
			'foreignKey' => 'zip_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
