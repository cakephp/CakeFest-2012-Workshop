<?php

class ValidationException extends CakeException {

	protected $_message = 'Please correct validation errors';

	protected $_errors = array();

	public function __construct($message = null, $code = 412) {
		parent::__construct($message, $code);
	}

	public function errors($list = null) {
		if ($list !== null) {
			$this->_errors = $list;
		}
		return $this->_errors;
	}

}