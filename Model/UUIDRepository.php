<?php
/**
 * UUID Repository model.
 *
 * This class contains everything necessary to globally register UUIDs and
 * later resolve them back into a model.
 *
 * PHP 5
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2011, Benjamin Kleiner <bizzl@users.sourceforge.net>
 * @package       UUIDable.Model
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * UUID Repository model.
 *
 * @package       UUIDable.Model
 */
class UUIDRepository extends UUIDableAppModel {
	public $useTable = 'repository';
	public $validate = array('uuid' => 'uuid');

	private function locateModel($obj) {
		$p = App::location(get_class($obj));
		$p = preg_replace('/(\.?)Model/', '$1' . $obj->toString(), $p);
		return $p;
	}

	/**
	 * Allows you to register a model with an UUID.
	 * @param Model $model A model.
	 * @param string $uuid The UUID that should resolve to $model. If not given, $model->id will be used.
	 * @return boolean
	 */
	public function register($model, $uuid = false) {
		if (!$uuid && is_object($model))
			$uuid = $model->id;
		if (is_object($model))
			$model = $this->locateModel($model);
		if (!$uuid)
			return false;
		$this->create();
		return $this->save(array('uuid' => $uuid, 'model' => $model));
	}

	/**
	 * Deletes a registered UUID.
	 * @param string $uuid The UUID to be removed.
	 * @return boolean
	 */
	public function deregister($uuid) {
		$id = $this->findByUuid($uuid);
		error_log(print_r($id, true));
		return $this->delete($id['UUIDRepository']['id']);
	}

	/**
	 * Resolves an UUID into a model.
	 * The returned model will already be set to the UUID.
	 * @param string $uuid The UUID to be resolved.
	 * @return Model
	 */
	public function resolve($uuid) {
		$id = $this->findByUuid($uuid);
		$model = $id['UUIDRepository']['model'];
		error_log(sprintf('%s %s: %s', __FILE__, __LINE__, $model));
		App::import('Model', $model);
		if (strpos($model, '.') > -1)
			list($package, $model) = explode('.', $model, 2);
		$m = new $model();
		$m->id = $uuid;
		return $m;
	}
}