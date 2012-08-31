<?php

App::uses('BaseAuthenticate', 'Controller/Component/Auth');
class ApiAuthenticate extends BaseAuthenticate {

	public function authenticate(CakeRequest $request, CakeResponse $response) {
		return false;
	}

	public function getUser($request) {
		$token = $request->header('Authorization');
		if (!$token) {
			if ($request->accepts('application/json')) {
				throw new ForbiddenException('Invalid Token');
			} else {
				return false;
			}
		}

		$user = ClassRegistry::init('User');
		$result = $user->find('first', array(
			'conditions' => array(
				'token' => $token
			)
		));

		if (empty($result)) {
			throw new ForbiddenException('Invalid Token');
		}
		return $result['User'];
	}
}