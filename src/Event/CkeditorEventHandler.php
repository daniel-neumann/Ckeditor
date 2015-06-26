<?php

namespace Croogo\Ckeditor\Event;

use Cake\Core\Configure;
use Cake\Event\EventListenerInterface;
use Croogo\Core\Croogo;

/**
 * Ckeditor Event Handler
 *
 * @category Event
 * @package  Croogo.Ckeditor
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class CkeditorEventHandler implements EventListenerInterface {

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
			list($controllerName, $action) = explode('.', $action);
			Croogo::hookHelper($controllerName, 'Croogo/Ckeditor.Ckeditor');
		}
	}

}
