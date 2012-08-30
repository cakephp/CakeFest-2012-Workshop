<?php
App::uses('AppController', 'Controller');
/**
 * Products Controller
 *
 * @property Product $Product
 */
class ProductsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->set('products', $this->paginate());
		$this->set('_serialize', 'products');
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Product->id = $id;
		if (!$this->Product->exists()) {
			throw new NotFoundException(__('Invalid product'));
		}
		$this->set('product', $this->Product->read(null, $id));
		$this->set('_serialize', 'product');
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Product->create();
			if ($this->Product->save($this->request->data)) {
				return $this->_success('product');
			} else {
				$ex = new ValidationException('Please correct your errors');
				$ex->errors($this->Product->validationErrors);
				throw $ex;
			}
		}
		$categories = $this->Product->Category->find('list');
		$orders = $this->Product->Order->find('list');
		$images = $this->Product->Image->find('list');
		$this->set(compact('categories', 'orders', 'images'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Product->id = $id;
		if (!$this->Product->exists()) {
			throw new NotFoundException(__('Invalid product'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Product->save($this->request->data)) {
				return $this->_success('product');
			} else {
				$ex = new ValidationException('Please correct your errors');
				$ex->errors($this->Product->validationErrors);
				throw $ex;
			}
		} else {
			$this->request->data = $this->Product->read(null, $id);
		}
		$categories = $this->Product->Category->find('list');
		$orders = $this->Product->Order->find('list');
		$images = $this->Product->Image->find('list');
		$this->set(compact('categories', 'orders', 'images'));
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
		$this->Product->id = $id;
		if (!$this->Product->exists()) {
			throw new NotFoundException(__('Invalid product'));
		}
		if ($this->Product->delete()) {
			return $this->_success('product', 'deleted');
		}
		throw new InternalServerError('Record was not deleted');
	}
}
