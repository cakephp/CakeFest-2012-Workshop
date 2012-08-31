<?php

App::uses('BaseAuthorize', 'Controller/Component/Auth');

class WorkshopAuthorize extends BaseAuthorize {

	public function authorize($user, CakeRequest $request) {
		if ($user['role'] === 'admin') {
			return true;
		}
		$checkActions = array('edit', 'delete');
		if ($request->controller !== 'products' || !in_array($request->action, $checkActions)) {
			return true;
		}

		$product = $request->params['pass'][0];
		return ClassRegistry::init('Product')->isOwner($user['id'], $product);
	}

}