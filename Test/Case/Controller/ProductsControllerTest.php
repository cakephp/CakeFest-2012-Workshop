<?php
App::uses('ProductsController', 'Controller');

/**
 * ProductsController Test Case
 *
 */
class ProductsControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.product',
		'app.category',
		'app.order',
		'app.image'
	);

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
		$this->generate('Products', array(
			'models' => array('Product' => array('find'))
		));
		$fixture = new ProductFixture;

		$data = array_map(function($r) {
			return array('Product' => $r, 'Category' => array('id' => 1, 'name' => 'foo'));
		}, $fixture->records);
		
		$this->controller->Product->expects($this->at(0))
			->method('find')
			->with('recent')
			->will($this->returnValue($data));
		
		$this->controller->Product->expects($this->at(1))
			->method('find')
			->with('count')
			->will($this->returnValue(4));
		
		$res = $this->testAction('/products/index', array('return' => 'contents'));
		$this->assertContains('<td>Product 1&nbsp;</td>', $res);

		$this->assertEquals($data, $this->vars['products']);
	}

/**
 * testView method
 *
 * @return void
 */
	public function testView() {
	}

/**
 * testAdd method
 *
 * @return void
 */
	public function testAdd() {
	}

/**
 * testEdit method
 *
 * @return void
 */
	public function testEdit() {
	}

/**
 * testDelete method
 *
 * @return void
 */
	public function testDelete() {
	}

}
