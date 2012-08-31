<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
	
	public $recursive = -1;

	public $actsAs = array('Containable');

	public function find($type = 'first', $query = array()) {
		return $this->cacheFind($this->cachePrefix(), $type, $query);
	}

    protected function cachePrefix() {
        $plugin = $this->plugin ? $this->plugin . '.' : '';
        return $plugin . $this->alias;
    }
   
    protected function cacheFind($prefix, $type = 'first', $params = array()) {
        $key = sha1(json_encode(array($prefix, $type, $params)));
        if (!($result = Cache::read($key))) {
            $result = parent::find($type, $params);
            Cache::write($key, $result);
        }
        return $result;
    }
   
    protected function _clearCache($type = null) {
        Cache::clearGroup($this->name);
        return parent::_clearCache();
    }

}
