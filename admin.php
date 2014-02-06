<?php

class Aigis {
	function __construct() {
		add_action('admin_menu', array(&$this, 'aigis_admin_menu'), 9);
	}
	function aigis_admin_menu() {
		if(class_exists('Jetpack') ) {
			add_action('jetpack_admin_menu', array(&$this, 'aigis_load_menu'));
		} else {
			$this->aigis_load_menu();
		}
	}
	
	
	function aigis_load_menu() {
		if( class_exists('Jetpack') ) {
			add_submenu_page(
				'jetpack',
			//	__('Aigis', 'aigis'),
				'Aigis',
			//	__('Aigis', 'aigis'),
				'Aigis',
				'manage_options',
				'aigis-setting',
				array(&$this,'conf')
			);
		} else {
			add_options_page(
			//	__('Aigis Settings', 'aigis'),
				'Aigis Settings',
			//	__('Aigis', 'aigis'),
				'Aigis',
				'manage_options',
				'aigis-setting',
				array(&$this,'conf')
			);
		}
	}
	function conf() {
		if(!empty($_POST) && check_admin_referer('aigis-update', '_wpnonce')) {
			foreach($_POST as $key => $value){
				if(($key=='aigis-uid' or $key=='aigis-key') and preg_match("/\w+$/",$value)) {
					$options[$key] = $value;
				}
			}
			$updated = update_option('aigis-option', $options);
		}
		$options = get_option('aigis-option');
		$options = isset($options) ? $options: null;
	?>
		<div class="wrap">
			<h2>Aigis Settings</h2>
			<?php if($updated): ?>
			<div class="updated"><p><strong><?php _e('Options saved.'); esc_html_e(var_export($options, true)); ?></strong></p></div>
			<?php endif; ?>
			<form action="" method="post">
				<?php wp_nonce_field('aigis-update', '_wpnonce'); ?>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><label for="uid">User ID</label></th>
						<td><input name="aigis-uid" type="text" id="uid" value="<?php echo $options['aigis-uid'] ?>" class="regular-text" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="key">Access Key</label></th>
						<td><input name="aigis-key" type="text" id="key" value="<?php echo $options['aigis-key'] ?>" class="regular-text" /></td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</form>
		</div><!-- /.wrap -->
		<?php
	}
}

function aigis_loader() {
	$showtext = new Aigis;
}
add_action('init', 'aigis_loader');


?>