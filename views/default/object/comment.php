<?php

/**
 * Elgg comment view
 *
 * @uses $vars['entity']    ElggComment
 * @uses $vars['full_view'] Display full view or brief view
 */
$full_view = elgg_extract('full_view', $vars, true);

$comment = $vars['entity'];
/* @var ElggComment $comment */

$entity = get_entity($comment->container_guid);
$commenter = get_user($comment->owner_guid);
if (!$entity || !$commenter) {
	return true;
}

$friendlytime = elgg_view_friendly_time($comment->time_created);

$commenter_icon = elgg_view_entity_icon($commenter, 'tiny');
$commenter_link = "<a href=\"{$commenter->getURL()}\">$commenter->name</a>";

$entity_title = $entity->title ? $entity->title : elgg_echo('untitled');
$entity_link = "<a href=\"{$entity->getURL()}\">$entity_title</a>";

if ($full_view) {

	$menu = elgg_view_menu('entity', [
		'entity' => $comment,
		'handler' => 'comment',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz float-alt',
	]);

	$comment_text = elgg_view('output/longtext', [
		'value' => $comment->description,
		'class' => 'elgg-inner',
		'data-role' => $comment instanceof ElggDiscussionReply ? 'discussion-reply-text' : 'comment-text',
	]);

	echo elgg_view('object/elements/summary', $vars + [
		'entity' => $comment,
		'metadata' => false,
		'tags' => $menu,
		'icon' => $commenter_icon,
		'content' => $comment_text,
		'access' => false,
	]);
} else {
	// brief view

	$excerpt = elgg_get_excerpt($comment->description, 80);
	$posted = elgg_echo('generic_comment:on', [$commenter_link, $entity_link]);

	$body = <<<HTML
<span class="elgg-subtext">
	$posted ($friendlytime): $excerpt
</span>
HTML;

	echo elgg_view_image_block($commenter_icon, $body);
}