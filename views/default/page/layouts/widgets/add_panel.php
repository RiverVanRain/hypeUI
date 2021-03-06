<?php
/**
 * Widget add panel
 *
 * @uses $vars['widgets']     Array of current widgets
 * @uses $vars['context']     The context for this widget layout
 * @uses $vars['exact_match'] Only use widgets that match the context
 * @uses $vars['container']   Container to optional limit widgets for. Defaults to page_owner_entity
 */

$widgets = elgg_extract('widgets', $vars);
$context = elgg_extract('context', $vars);
$exact = elgg_extract('exact_match', $vars, false);
$container = elgg_extract('container', $vars, elgg_get_page_owner_entity());

$widget_types = elgg_get_widget_types([
	'context' => $context,
	'exact' => $exact,
	'container' => $container,
]);
uasort($widget_types, function ($a, $b) {
	return strcmp($a->name, $b->name);
});

$current_handlers = [];
foreach ($widgets as $column_widgets) {
	foreach ($column_widgets as $widget) {
		$current_handlers[] = $widget->handler;
	}
}

?>
<div class="elgg-widgets-add-panel hidden clearfix box" id="widgets-add-panel">
    <p class="content">
		<?php echo elgg_echo('widgets:add:description'); ?>
    </p>
    <ul class="elgg-widgets-add-panel-list columns">
		<?php
		foreach ($widget_types as $handler => $widget_type) {
		    $class = ['column is-4'];

			// check if widget added and only one instance allowed
			if ($widget_type->multiple == false && in_array($handler, $current_handlers)) {
				$class[] = 'elgg-state-unavailable';
				$tooltip = elgg_echo('widget:unavailable');
			} else {
				$class[] = 'elgg-state-available';
				$tooltip = $widget_type->description;
			}

			if ($widget_type->multiple) {
				$class[] = 'elgg-widget-multiple';
			} else {
				$class[] = 'elgg-widget-single';
			}

			$name = elgg_format_element('span', [], $widget_type->name);
			echo elgg_format_element('li', [
				'title' => $tooltip,
				'class' => $class,
				'data-elgg-widget-type' => $handler,
			], $name);
		}
		?>
    </ul>
	<?php
	echo elgg_view('input/hidden', [
		'name' => 'widget_context',
		'value' => $context
	]);
	echo elgg_view('input/hidden', [
		'name' => 'show_access',
		'value' => (int)$vars['show_access']
	]);
	?>
</div>
