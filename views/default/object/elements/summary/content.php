<?php

/**
 * Outputs object summary content
 * @uses $vars['content'] Summary content
 */

$content = elgg_extract('content', $vars);
if (!$content) {
	return;
}
$media = elgg_extract('media', $vars);

echo elgg_view_image_block('', $content, [
	'image_alt' => $media,
	'class' => 'elgg-listing-summary-content elgg-content content',
]);