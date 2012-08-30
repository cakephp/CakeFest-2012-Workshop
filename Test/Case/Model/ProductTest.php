<?php
App::uses('Product', 'Model');

/**
 * Product Test Case
 *
 */
class ProductTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.product',
		'app.category'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Product = ClassRegistry::init('Product');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Product);

		parent::tearDown();
	}

	public function testCreate() {
		$data = array();
		$this->assertFalse($this->Product->save($data));

		$data = array('name' => 'Foo');
		$this->Product->create();
		$this->assertFalse($this->Product->save($data));
		$errors = array(
			'description' => array('This field is required'),
			'category_id' => array('This field is required'),
		);
		$this->assertEquals($errors, $this->Product->validationErrors);

		$this->assertCount(4, $this->Product->find('all'));

		$data = array('name' => 'Foo', 'description' => 'Bar', 'category_id' => 1);
		$this->Product->create();
		$this->assertNotEmpty($this->Product->save($data));
		$errors = array(
			'description' => array('This field is required'),
			'category_id' => array('This field is required'),
		);
		$products = $this->Product->find('all');
		$this->assertCount(5, $products);

		$this->assertEquals('Foo', $products[4]['Product']['name']);
	}

	public function testEdit() {
		$this->assertCount(4, $this->Product->find('all'));
	}

	public function testFindRecent() {
		$result = $this->Product->find('recent');
		$expected = array('4', '3', '2', '1');
		$this->assertEquals($expected, Hash::extract($result, '{n}.Product.id'));

		$expected = array_fill(0, 4, array('id' => '1', 'name' => 'Games'));
		$this->assertEquals($expected, Hash::extract($result, '{n}.Category'));

		$fixture = new ProductFixture;
		$records = $fixture->records;
		$expected = array_reverse($records);
		$this->assertEquals($expected, Hash::extract($result, '{n}.Product'));
	}

	public function testFindInStock() {
		$result = $this->Product->find('inStock');
		$fixture = new ProductFixture;
		$records = $fixture->records;
		$expected = Hash::extract($records, '{n}[quantity_left > 0]');
		$expected = Hash::sort($expected, '{n}.name', 'desc');
		$this->assertEquals($expected, Hash::extract($result, '{n}.Product'));
	}

}
