<?php
/**
 * UUIDable behavior class.
 *
 * Enables models to directly register UUIDs on save.
 *
 * PHP 5
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2011, Benjamin Kleiner <bizzl@users.sourceforge.net>
 * @package       UUIDable.Model.Behavior
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::import('Model', 'UUIDable.UUIDRepository');

/**
 * UUIDable behavior class.
 *
 * @package       UUIDable.Model.Behavior
 */
class UUIDableBehavior extends ModelBehavior {

	private $repository = false;
	private $defaults = array();

	public function setup($model, $settings) {
		$this->settings[$model->alias] = array_merge($this->defaults, $settings);
		if (!$this->repository)
			$this->repository = new UUIDRepository();
	}

	public function afterSave($model, $created) {
		if (!$created)
			return;
		$this->repository->register($model);
	}

	public function beforeDelete($model) {
		return $this->repository->deregister($model->id);
	}
}