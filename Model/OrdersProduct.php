<?php
App::uses('AppModel', 'Model');
/**
 * OrdersProduct Model
 *
 * @property Order $Order
 * @property Product $Product
 */
class OrdersProduct extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'order_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'This field is required',
				'allowEmpty' => false,
				'required' => 'create',
			),
		),
		'product_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'This field is required',
				'allowEmpty' => false,
				'required' => 'create',
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
		'Order' => array(
			'className' => 'Order',
			'foreignKey' => 'order_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Product' => array(
			'className' => 'Product',
			'foreignKey' => 'product_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}

