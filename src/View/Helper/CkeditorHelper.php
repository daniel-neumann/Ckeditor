<?php

namespace Croogo\Ckeditor\View\Helper;

use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Utility\Inflector;
use Cake\View\Helper;

/**
 * Ckeditor Helper
 *
 * PHP version 5
 *
 * @category Ckeditor.Helper
 * @package  Ckeditor.View.Helper
 * @version  1.5
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class CkeditorHelper extends Helper {

/**
 * Other helpers used by this helper
 *
 * @var array
 * @access public
 */
	public $helpers = array(
		'Html',
		'Js',
	);

/**
 * Actions
 *
 * Format: ControllerName/action_name => settings
 *
 * @var array
 */
	public $actions = array();

/**
 * beforeRender
 *
 * @param string $viewFile
 * @return void
 */
	public function beforeRender($viewFile) {
		$actions = Configure::read('Wysiwyg.actions');
		if (is_array($actions)) {
			foreach ($actions as $key => $value) {
				if (is_string($value)) {
					$this->actions[] = $value;
				} else {
					$this->actions[] = $key;
				}
			}
		}

        $pluginPath = $controller = null;
        $namespace = 'Controller';
        if (!empty($this->request->params['plugin'])) {
            $pluginPath = $this->request->params['plugin'] . '.';
        }
        if (!empty($this->request->params['controller'])) {
            $controller = $this->request->params['controller'];
        }
        if (!empty($this->request->params['prefix'])) {
            $prefixes = array_map(
                'Cake\Utility\Inflector::camelize',
                explode('/', $this->request->params['prefix'])
            );
            $namespace .= '/' . implode('/', $prefixes);
        }

        $className = App::classname($pluginPath . $controller, $namespace, 'Controller');
		$action = $className . '.' . $this->request->params['action'];
		if (!empty($actions) && in_array($action, $this->actions)) {
			$this->Html->script('Croogo/Ckeditor.wysiwyg', ['block' => true]);
			$this->Html->script('Croogo/Ckeditor.ckeditor', ['block' => true]);

			$ckeditorActions = Configure::read('Wysiwyg.actions');
			if (!isset($ckeditorActions[$action])) {
				return;
			}
			$actionItems = $ckeditorActions[$action];
			$out = null;
			foreach ($actionItems as $actionItem) {
				$element = $actionItem['elements'];
				unset($actionItem['elements']);
				$config = empty($actionItem) ? '{}' : $this->Js->object($actionItem);
				$out .= sprintf(
					'Croogo.Wysiwyg.Ckeditor.setup("%s", %s);',
					$element, $config
				);
			}
			$this->Html->scriptBlock($out, ['block' => 'scriptBottom']);
		}
	}
}
