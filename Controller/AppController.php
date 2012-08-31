<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');
App::uses('ValidationException', 'Error');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	public $components = array(
		'RequestHandler',
		'Session',
		'Auth' => array(
			'authenticate' => array(
				'Form' => array(
					'fields' => array('username' => 'email')
				),
				'Api'
			),
			'authorize' => array(
				'Workshop',
				'Controller',
			)
		),
		'DebugKit.Toolbar'
	);

/**
 * Dispatches the controller action.  Checks that the action
 * exists and isn't private.
 *
 * @param CakeRequest $request
 * @return mixed The resulting response.
 * @throws PrivateActionException When actions are not public or prefixed by _
 * @throws MissingActionException When actions are not defined and scaffolding is
 *    not enabled.
 */
	public function invokeAction(CakeRequest $request) {
		try {
			return parent::invokeAction($request);
		} catch (ValidationException $e) {
			if (!$this->RequestHandler->prefers('json')) {
				$this->Session->setFlash($e->getMessage(), 'error');
				return;
			}
			throw $e;
		}
	}

	protected function _success($model, $action = 'saved') {
		if ($this->RequestHandler->prefers('json')) {
			$this->set('success', true);
			$this->set('_serialize', array('success'));
			return;
		}
		$this->Session->setFlash(__('The %s has been %s', $model, $action));
		$this->redirect(array('action' => 'index'));
	}

	public function isAuthorized($request) {
		return $this->Auth->user('role') === 'admin';
	}

}
