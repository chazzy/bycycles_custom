<?php

class Bycycle {

	
	protected $loader;
	protected $plugin_name;
	protected $version;
	protected $taxonomy_name;

	public function __construct($config) {
		
		if ( defined( 'BYCYCLE_VERSION' ) ) {
			$this->version = BYCYCLE_VERSION;
		} else {
			$this->version = $config['version'];
		}
		$this->plugin_name = $config['plugin_name'];
		$this->taxonomy_name = $config['taxonomy_name'];
		
		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	private function load_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-bycycle-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-bycycle-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-bycycle-public.php';
		$this->loader = new Bycycle_Loader();
	}

	private function define_admin_hooks() {

		$plugin_admin = new Bycycle_Admin($this->get_plugin_name(),$this->taxonomy_name);

		$this->loader->add_filter( 'admin_notices', $plugin_admin, 'check_acf_plugin' );
		$this->loader->add_action( 'init', $plugin_admin, 'create_bycycles_post_type' );
		$this->loader->add_action( 'init', $plugin_admin, 'register_bycycle_taxonomy' );
		$this->loader->add_action( 'restrict_manage_posts', $plugin_admin, 'filter_by_bycycle_types' );
		$this->loader->add_action( 'manage_posts_custom_column', $plugin_admin, 'filter_search_bycycle_types_column' );
		$this->loader->add_filter( 'parse_query', $plugin_admin, 'convert_id_to_taxonomy_term_in_query' );
	}

	private function define_public_hooks() {
		$plugin_public = new Bycycle_Public( $this->get_plugin_name(),$this->taxonomy_name);
		$this->loader->add_filter( 'single_template', $plugin_public, 'load_bycycle_template' );
		$this->loader->add_filter( 'archive_template', $plugin_public, 'load_bycycles_post_type_template' );
		$this->loader->add_action( 'pre_get_posts', $plugin_public, 'filter_archive' );


	}
	public function run() {
		$this->loader->run();
	}

	public function get_plugin_name() {
		return $this->plugin_name;
	}
}
