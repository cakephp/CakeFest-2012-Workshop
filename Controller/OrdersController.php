<?php
App::uses('AppController', 'Controller');
/**
 * Orders Controller
 *
 * @property Order $Order
 */
class OrdersController extends AppController {

	public $components = array(
		'Paginator' => array('settings' => array(
			'contain' => array('User')
		))
	);

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->set('orders', $this->paginate());
		$this->set('_serialize', 'orders');
	}

	public function having($product) {
		$this->Paginator->settings[0] = 'having';
		$this->Paginator->settings['product'] = $product;
		$this->setAction('index');
	}


/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Order->id = $id;
		if (!$this->Order->exists()) {
			throw new NotFoundException(__('Invalid order'));
		}
		$this->set('order', $this->Order->read(null, $id));
		$this->set('_serialize', 'order');
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Order->create();
			$this->request->data('Order.user_id', $this->Auth->user('id'));
			if ($this->Order->createOrder($this->request->data)) {
				return $this->_success('order');
			} else {
				$ex = new ValidationException('Please correct your errors');
				$ex->errors($this->Order->validationErrors);
				throw $ex;
			}
		}
		$products = $this->Order->Product->find('list');
		$this->set(compact('products'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Order->id = $id;
		if (!$this->Order->exists()) {
			throw new NotFoundException(__('Invalid order'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Order->save($this->request->data)) {
				return $this->_success('order');
			} else {
				$ex = new ValidationException('Please correct your errors');
				$ex->errors($this->Order->validationErrors);
				throw $ex;
			}
		} else {
			$this->request->data = $this->Order->read(null, $id);
		}
		$users = $this->Order->User->find('list');
		$products = $this->Order->Product->find('list');
		$this->set(compact('users', 'products'));
	}

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Order->id = $id;
		if (!$this->Order->exists()) {
			throw new NotFoundException(__('Invalid order'));
		}
		if ($this->Order->delete()) {
			return $this->_success('order', 'deleted');
		}
		throw new InternalServerError('Record was not deleted');
	}
}
