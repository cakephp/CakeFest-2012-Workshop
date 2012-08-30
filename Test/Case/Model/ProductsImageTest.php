<?php
App::uses('ProductsImage', 'Model');

/**
 * ProductsImage Test Case
 *
 */
class ProductsImageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.products_image',
		'app.image',
		'app.product',
		'app.category',
		'app.order',
		'app.orders_product'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ProductsImage = ClassRegistry::init('ProductsImage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ProductsImage);

		parent::tearDown();
	}

}
