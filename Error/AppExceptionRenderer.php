<?php

App::uses('ExceptionRenderer', 'Error');

class AppExceptionRenderer extends ExceptionRenderer {

	public function validation($error) {
		$url = $this->controller->request->here();
		$code = ($error->getCode() >= 400 && $error->getCode() < 506) ? $error->getCode() : 500;
		$this->controller->response->statusCode($code);
		$this->controller->set(array(
			'code' => $code,
			'url' => h($url),
			'name' => $error->getMessage(),
			'errors' => $error->errors(),
			'error' => $error,
			'_serialize' => array('code', 'url', 'name', 'errors', 'error')
		));
		$this->_outputMessage('error400');
	}
}