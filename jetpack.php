<?php
if(!class_exists('Jetpack')) {
	// There is absolutely no reason why more than one result should appear, but
	// let's assume a correct search will only have one match.
	if(!class_exists('Sharing_Source')) {
		include_once(WP_PLUGIN_DIR.'/jetpack/modules/sharedaddy/sharing-sources.php');
	}
	add_filter('sharing_services', array('Share_Aigis', 'inject_service'));
	add_action('admin_notices', array('Share_Aigis', 'jetpack_message'));
	
} else {
	// Nothing to see here, move along.
	return;
}

class Share_Aigis extends Sharing_Source {
	var $shortname = 'aigis';

	public function __construct($id, array $settings) {
		parent::__construct($id, $settings);

		if ('official' == $this->button_style)
			$this->smart = true;
		else
			$this->smart = false;
	}

	public function get_name() {
		return __('Aigis', 'aigis');
	}

	public function process_request($post, array $post_data) {
		// Record stats
		parent::process_request($post, $post_data);

		$aigis_url = esc_url_raw('http://s.aigis.pw/?url=' . rawurlencode($this->get_share_url($post->ID)));
		wp_redirect($aigis_url);
		exit;
	}

	public function get_display($post) {
		/*if($this->smart) {
			$post_count = 'horizontal';

			$button = '';
			$button .= '<div class="pocket_button">';
			$button .= sprintf('<a href="https://getpocket.com/save" class="pocket-btn" data-lang="%s" data-save-url="%s" data-pocket-count="%s" >%s</a>', 'en', esc_attr($this->get_share_url($post->ID)), $post_count, esc_attr__('Pocket', 'jetpack'));
			$button .= '</div>';

			return $button;
		} else {*/
			return $this->get_link(get_permalink($post->ID), __('Aigis', 'aigis'), __('Click to shorten with Aigis', 'aigis'), 'share=aigis');
		//}

	}

	function display_footer() {
		/*if($this->smart):
		?>
		<script>
		// Don't use Pocket's default JS as it we need to force init new Pocket share buttons loaded via JS.
		function jetpack_sharing_pocket_init() {
			jQuery.getScript('https://widgets.getpocket.com/v1/j/btn.js?v=1');
		}
		jQuery(document).on('ready', jetpack_sharing_pocket_init);
		jQuery(document.body).on('post-load', jetpack_sharing_pocket_init);
		</script>
		<?php
		else:*/
			$this->js_dialog($this->shortname, array('width' => 768, 'height' => 450));
		//endif;

	}
	public function inject_service ( array $services ) {
		if ( ! array_key_exists( 'aigis', $services ) ) {
			$services['aigis'] = 'Share_Aigis';
		}
		return $services;
	}

	public function jetpack_message() {
		if ( 'jetpack_page_aigis-setting' != get_current_screen()->id ) {
			return;
		}
		echo '<div class="updated"><p>';
		_e('It looks like you have Jetpack installed! Go to the settings screen for the sharebar and you will find an option for adding the Shorten with Aigis Button next to your other share buttons. Come back to this page to customize the text and icon.', 'aigis');
		echo '</p></div>';
	}

}
