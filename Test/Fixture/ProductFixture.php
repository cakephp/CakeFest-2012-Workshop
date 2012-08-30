<?php
/**
 * ProductFixture
 *
 */
class ProductFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'category_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'price' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'quantity_left' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'name' => 'CakePHP',
			'description' => 'The best framework out there',
			'category_id' => '1',
			'price' => '0.00',
			'quantity_left' => '0',
			'created' => '2012-08-30 14:16:20',
			'modified' => '2012-08-30 14:16:20'
		),
		array(
			'id' => '2',
			'name' => 'Product 1',
			'description' => 'Foo',
			'category_id' => '1',
			'price' => '10.00',
			'quantity_left' => '30',
			'created' => '2012-08-30 15:26:23',
			'modified' => '2012-08-30 15:26:23'
		),
		array(
			'id' => '3',
			'name' => 'Product 2',
			'description' => 'Bar',
			'category_id' => '1',
			'price' => '28.00',
			'quantity_left' => '41',
			'created' => '2012-08-30 15:26:36',
			'modified' => '2012-08-30 15:26:36'
		),
		array(
			'id' => '4',
			'name' => 'Product 3',
			'description' => 'Baz',
			'category_id' => '1',
			'price' => '27.00',
			'quantity_left' => '0',
			'created' => '2012-08-30 15:26:56',
			'modified' => '2012-08-30 15:26:56'
		),
	);

}
