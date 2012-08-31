<?php
App::uses('AppModel', 'Model');
/**
 * Order Model
 *
 * @property User $User
 * @property Product $Product
 */
class Order extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'user_id' => array(
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
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public $hasMany = array(
		'OrdersProduct' => array(
			'class' => 'OrdersProduct',
			'foreignKey' => 'order_id'
		)
	);

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Product' => array(
			'className' => 'Product',
			'joinTable' => 'orders_products',
			'foreignKey' => 'order_id',
			'associationForeignKey' => 'product_id',
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
		)
	);

	public $findMethods = array('having' => true);

	public function createOrder($data) {
		if (!empty($data['OrdersProduct'])) {
			$products = $data['OrdersProduct']['product_id'];
			$prices = $this->Product->find('list', array(
				'fields' => array('id', 'price'),
				'conditions' => array('id' => $products)
			));

			unset($data['OrdersProduct']);
			foreach ($products as $p) {
				$data['OrdersProduct'][] = array(
					'product_id' => $p,
					'price' => $prices[$p]
				);
			}
		}

		$validator = $this->OrdersProduct->validator();
		unset($validator['order_id']);
		return $this->saveAll($data);
	}

	protected function _findHaving($state, $query, $results = array()) {
		if ($state === 'before') {
			$this->bindModel(array('hasOne' => array(
				'OrdersProduct' => array(
					'className' => 'OrdersProduct',
					'foreignKey' => 'order_id',
					'type' => 'inner',
					'conditions' => array('product_id' => $query['product'])
				)
			)), true);
			$query['contain'] = array('User', 'OrdersProduct');
			return $query;
		}

		return $results;
	}
}

