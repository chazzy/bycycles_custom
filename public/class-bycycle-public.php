<?php
class Bycycle_Public {

	private $plugin_name;
	private $plugin_root_dir;
	private $taxonomy_name;
	public function __construct( $plugin_name,$taxonomy_name) {

		$this->plugin_name = $plugin_name;
		$this->taxonomy_name = $taxonomy_name;
	 	$this->plugin_root_dir = plugin_dir_path( __FILE__ ).'/template/';
	}

	public function load_bycycle_template(string $template): string{
		global $post;
	    if ( $this->plugin_name === $post->post_type && $this->plugin_root_dir . '/single-bycycles.php' ) {
	        return $this->plugin_root_dir . '/single-bycycles.php';
	    }
	    return $template;
	} 

	public function load_bycycles_post_type_template( $archive_template ) {
		global $post;
		global $wp;

	 	if (is_archive() && (get_post_type($post) == $this->plugin_name || $wp->request == $this->plugin_name)) {
			$archive_template = $this->plugin_root_dir.'/archive-bycyles.php';
		}
 		return $archive_template;
	}
	public function filter_archive( $query ) {
        if ( is_archive())  {
            if ($_POST['taxonomy'] ) {
                $taxquery = array(
                    array(
                        'taxonomy' => $this->taxonomy_name,
                        'field' => 'slug',
                        'terms' => $_POST['taxonomy'],
                    ),
                );
                $query->set( 'tax_query', $taxquery );
            }
        }
        return $query;
	}
}
