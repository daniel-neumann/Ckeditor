<?php

App::uses('CakeEventListener', 'Event');

/**
 * Ckeditor Event Handler
 *
 * @category Event
 * @package  Croogo.Ckeditor
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class CkeditorEventHandler implements CakeEventListener {

/**
 * implementedEvents
 *
 * @return array
 */
	public function implementedEvents() {
		return array(
			'Croogo.bootstrapComplete' => array(
				'callable' => 'onBootstrapComplete',
			),
		);
	}

/**
 * Hook helper
 */
	public function onBootstrapComplete($event) {
		foreach ((array)Configure::read('Wysiwyg.actions') as $action => $settings) {
			if (is_numeric($action)) {
				$action = $settings;
			}
			$actionE = explode('/', $action);
			Croogo::hookHelper($actionE['0'], 'Ckeditor.Ckeditor');
		}
	}

}
