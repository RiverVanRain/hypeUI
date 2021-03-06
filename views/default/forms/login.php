<?php
/**
 * Elgg login form
 *
 * @package    Elgg
 * @subpackage Core
 */
echo elgg_view_field([
	'#type' => 'text',

	'name' => 'username',
	'autofocus' => true,
	'required' => true,
	'#label' => elgg_echo('loginusername'),
]);

echo elgg_view_field([
	'#type' => 'password',
	'name' => 'password',
	'required' => true,
	'#label' => elgg_echo('password'),
]);

echo elgg_view('login/extend', $vars);

if (isset($vars['returntoreferer'])) {
	echo elgg_view_field([
		'#type' => 'hidden',
		'name' => 'returntoreferer',
		'value' => 'true'
	]);
}

ob_start();
?>
    <div class="elgg-foot">

        <div class="columns is-vcentered">
            <div class="column is-half">
                <label class="mtm float-alt">
                    <input type="checkbox" name="persistent" value="true"/>
					<?php echo elgg_echo('user:persistent'); ?>
                </label>
            </div>
            <div class="column is-half has-text-right">
				<?php
				echo elgg_view('input/submit', ['value' => elgg_echo('login')]);
				?>
            </div>
        </div>

		<?php
		echo elgg_view_menu('login', [
			'sort_by' => 'priority',
			'class' => 'elgg-menu-general elgg-menu-hz mtm',
		]);
		?>
    </div>
<?php
$footer = ob_get_clean();
elgg_set_form_footer($footer);
