<?php

/**
 * Functions specific to the administration interface
 *
 * @package Code_Snippets
 */
class Code_Snippets_Admin {

	public $menus = array();

	function __construct() {

		if ( is_admin() ) {
			$this->load_classes();
			$this->run();
		}
	}

	private function load_classes() {
		$this->menus['manage'] = new Code_Snippets_Manage_Menu();
		$this->menus['edit']   = new Code_Snippets_Edit_Menu();
		$this->menus['import'] = new Code_Snippets_Import_Menu();

		if ( ! is_network_admin() ) {
			$this->menus['settings'] = new Code_Snippets_Settings_Menu();
		}
	}

	function run() {
		add_filter( 'mu_menu_items', array( $this, 'mu_menu_items' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_stylesheet' ) );
		add_filter( 'plugin_action_links_' . plugin_basename( CODE_SNIPPETS_FILE ), array( $this, 'plugin_settings_link' ) );
		add_filter( 'plugin_row_meta', array( $this, 'plugin_meta_links' ), 10, 2 );
		add_action( 'code_snippets/admin/manage', array( $this, 'survey_message' ) );
	}

	/**
	 * Allow super admins to control site admin access to
	 * snippet admin menus
	 *
	 * Adds a checkbox to the *Settings > Network Settings*
	 * network admin menu
	 *
	 * @since 1.7.1
	 *
	 * @param  array $menu_items The current mu menu items
	 *
	 * @return array             The modified mu menu items
	 */
	function mu_menu_items( $menu_items ) {
		$menu_items['snippets'] = __( 'Snippets', 'code-snippets' );
		return $menu_items;
	}

	/**
	 * Enqueue the stylesheet for a snippet menu
	 *
	 * @since 2.2.0
	 * @uses wp_enqueue_style() to add the stylesheet to the queue
	 * @uses get_user_option() to check if MP6 mode is active
	 * @uses plugins_url() to retrieve a URL to assets
	 *
	 * @param string $hook the current page hook
	 */
	function enqueue_admin_stylesheet( $hook ) {
		$pages = array( 'manage', 'add', 'edit', 'settings' );
		$hooks = array_map( 'code_snippets_get_menu_hook', $pages );

		/* First, load the menu icon stylesheet */
		wp_enqueue_style(
			'menu-icon-snippets',
			plugins_url( 'css/min/menu-icon.css', CODE_SNIPPETS_FILE ),
			false,
			CODE_SNIPPETS_VERSION
		);

		/* Only load the stylesheet on the right snippets page */
		if ( ! in_array( $hook, $hooks ) ) {
			return;
		}

		$hooks = array_combine( $hooks, $pages );
		$page  = $hooks[ $hook ];

		// add snippet page uses edit stylesheet
		'add' === $page && $page = 'edit';

		wp_enqueue_style(
			"code-snippets-$page",
			plugins_url( "css/min/$page.css", CODE_SNIPPETS_FILE ),
			false,
			CODE_SNIPPETS_VERSION
		);
	}

	/**
	 * Adds a link pointing to the Manage Snippets page
	 *
	 * @since 2.0
	 *
	 * @param  array $links The existing plugin action links
	 *
	 * @return array        The modified plugin action links
	 */
	function plugin_settings_link( $links ) {
		array_unshift( $links, sprintf(
			'<a href="%1$s" title="%2$s">%3$s</a>',
			code_snippets()->get_menu_url(),
			__( 'Manage your existing snippets', 'code-snippets' ),
			__( 'Manage', 'code-snippets' )
		) );

		return $links;
	}

	/**
	 * Adds extra links related to the plugin
	 *
	 * @since 2.0
	 *
	 * @param  array $links The existing plugin info links
	 * @param  string $file The plugin the links are for
	 *
	 * @return array         The modified plugin info links
	 */
	function plugin_meta_links( $links, $file ) {

		/* We only want to affect the Code Snippets plugin listing */
		if ( plugin_basename( CODE_SNIPPETS_FILE ) !== $file ) {
			return $links;
		}

		$format = '<a href="%1$s" title="%2$s">%3$s</a>';

		/* array_merge appends the links to the end */

		return array_merge( $links, array(
			sprintf( $format,
				'http://wordpress.org/plugins/code-snippets/',
				__( 'Visit the WordPress.org plugin page', 'code-snippets' ),
				__( 'About', 'code-snippets' )
			),
			sprintf( $format,
				'http://wordpress.org/support/plugin/code-snippets/',
				__( 'Visit the support forums', 'code-snippets' ),
				__( 'Support', 'code-snippets' )
			),
			sprintf( $format,
				'http://bungeshea.com/donate/',
				__( "Support this plugin's development", 'code-snippets' ),
				__( 'Donate', 'code-snippets' )
			),
		) );
	}

	/**
	 * Print a notice inviting people to participate in the Code Snippets Survey
	 *
	 * @since  1.9
	 * @return void
	 */
	function survey_message() {
		global $current_user;

		$key = 'ignore_code_snippets_survey_message';

		/* Bail now if the user has dismissed the message */
		if ( get_user_meta( $current_user->ID, $key ) ) {
			return;
		} elseif ( isset( $_GET[ $key ], $_REQUEST['_wpnonce'] ) && wp_verify_nonce( $_REQUEST['_wpnonce'], $key ) ) {
			add_user_meta( $current_user->ID, $key, true, true );

			return;
		}

		?>

		<br/>

		<div class="updated"><p>

				<?php _e( "<strong>Have feedback on Code Snippets?</strong> Please take the time to answer a short survey on how you use this plugin and what you'd like to see changed or added in the future.", 'code-snippets' ); ?>

				<a href="http://sheabunge.polldaddy.com/s/code-snippets-feedback" class="button secondary"
				   target="_blank" style="margin: auto .5em;">
					<?php _e( 'Take the survey now', 'code-snippets' ); ?>
				</a>

				<a href="<?php echo esc_url( wp_nonce_url( add_query_arg( $key, true ), $key ) ); ?>"><?php _e( 'Dismiss', 'code-snippets' ); ?></a>

			</p></div>

		<?php
	}
}
