<?php
App::uses('AppModel', 'Model');
/**
 * ProductsImage Model
 *
 * @property Image $Image
 * @property Product $Product
 */
class ProductsImage extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'image_id' => array(
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
		'Image' => array(
			'className' => 'Image',
			'foreignKey' => 'image_id',
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

