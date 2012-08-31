<?php
App::uses('AppModel', 'Model');
/**
 * Product Model
 *
 * @property Category $Category
 * @property Order $Order
 * @property Image $Image
 */
class Product extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'This field is required',
				'allowEmpty' => false,
				'required' => 'create',
			),
		),
		'description' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'This field is required',
				'allowEmpty' => false,
				'required' => 'create',
			),
		),
		'category_id' => array(
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
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Owner' => array(
			'className' => 'User',
			'foreignKey' => 'owner_id',
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
		'Order' => array(
			'className' => 'Order',
			'joinTable' => 'orders_products',
			'foreignKey' => 'product_id',
			'associationForeignKey' => 'order_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => '',
			'with' => 'OrdersProduct'
		),
		'Image' => array(
			'className' => 'Image',
			'joinTable' => 'products_images',
			'foreignKey' => 'product_id',
			'associationForeignKey' => 'image_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => '',
			'with' => 'ProductsImage'
		)
	);

	public $findMethods = array(
		'inStock' => true,
		'outOfStock' => true,
		'recent' => true
	);

	protected function _findInStock($state, $query, $results = array()) {
		if ($state === 'before') {
			$query['conditions']['Product.quantity_left >'] = 0;
			$query['order']['Product.name'] = 'desc';
			$query['contain']['Category'] = array('fields' => array('id', 'name'));
			return $query;
		}

		return $results;
	}
	
	protected function _findOutOfStock($state, $query, $results = array()) {
		if ($state === 'before') {
			$query['conditions']['Product.quantity_left <='] = 0;
			$query['contain']['Category'] = array('fields' => array('id', 'name'));
			return $query;
		}

		return $results;
	}

	protected function _findRecent($state, $query, $results = array()) {
		if ($state === 'before') {
			$query['order']['Product.created'] = 'desc';
			$query['contain']['Category'] = array('fields' => array('id', 'name'));
			return $query;
		}

		return $results;
	}

	public function isOwner($user, $id) {
		return (bool)$this->find('first', array(
			'conditions' => array('owner_id' => $user, 'id' => $id)
		));
	}
}

