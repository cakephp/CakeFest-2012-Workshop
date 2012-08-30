<?php
App::uses('AppController', 'Controller');
/**
 * Images Controller
 *
 * @property Image $Image
 */
class ImagesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->set('images', $this->paginate());
		$this->set('_serialize', 'images');
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Image->id = $id;
		if (!$this->Image->exists()) {
			throw new NotFoundException(__('Invalid image'));
		}
		$this->set('image', $this->Image->read(null, $id));
		$this->set('_serialize', 'image');
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Image->create();
			if ($this->Image->save($this->request->data)) {
				return $this->_success('image');
			} else {
				$ex = new ValidationException('Please correct your errors');
				$ex->errors($this->Image->validationErrors);
				throw $ex;
			}
		}
		$products = $this->Image->Product->find('list');
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
		$this->Image->id = $id;
		if (!$this->Image->exists()) {
			throw new NotFoundException(__('Invalid image'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Image->save($this->request->data)) {
				return $this->_success('image');
			} else {
				$ex = new ValidationException('Please correct your errors');
				$ex->errors($this->Image->validationErrors);
				throw $ex;
			}
		} else {
			$this->request->data = $this->Image->read(null, $id);
		}
		$products = $this->Image->Product->find('list');
		$this->set(compact('products'));
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
		$this->Image->id = $id;
		if (!$this->Image->exists()) {
			throw new NotFoundException(__('Invalid image'));
		}
		if ($this->Image->delete()) {
			return $this->_success('image', 'deleted');
		}
		throw new InternalServerError('Record was not deleted');
	}
}
