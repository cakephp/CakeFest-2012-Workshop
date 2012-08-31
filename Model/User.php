<?php
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');

/**
 * User Model
 *
 * @property Order $Order
 */
class User extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'This field is required',
				'allowEmpty' => false,
				'required' => 'create',
			),
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'This field is required',
				'allowEmpty' => false,
				'required' => 'create',
			),
		),
		'role' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'This field is required',
				'allowEmpty' => false,
				'required' => 'create',
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
		'Order' => array(
			'className' => 'Order',
			'foreignKey' => 'user_id',
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

	public function beforeValidate($options = array()) {
		if (empty($this->data[$this->alias]['role'])) {
			$this->whitelist[] = 'role';
			$this->data[$this->alias]['role'] = 'user';
		}
		$this->whitelist[] = 'token';
		$this->data[$this->alias]['token'] = sha1(String::uuid());
		return parent::beforeValidate($options);
	}

	public function beforeSave($options = array()) {
		if (!empty($this->data[$this->alias]['password'])) {
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
		}
		return parent::beforeSave($options);
	}

}

