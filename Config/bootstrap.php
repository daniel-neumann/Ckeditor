<?php
/**
 * Configuration
 */
Configure::write('Ckeditor.actions', array(
	'Nodes/admin_add' => array(
		array(
			'elements' => 'NodeBody',
		),
	),
	'Nodes/admin_edit' => array(
		array(
			'elements' => 'NodeBody',
		),
	),
	'Translate/admin_edit' => array(
		array(
			'elements' => 'NodeBody',
		),
	),
));

/**
 * Hook helper
 */
foreach (Configure::read('Ckeditor.actions') as $action => $settings) {
	$actionE = explode('/', $action);
	Croogo::hookHelper($actionE['0'], 'Ckeditor.Ckeditor');
}
//Croogo::hookHelper('Attachments', 'Ckeditor.Ckeditor');
