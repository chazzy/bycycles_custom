<?php
class Bycycle_Admin {

	private $plugin_name;
	private $taxonomy_name;

	public function __construct($plugin_name,$taxonomy_name) {

		$this->plugin_name = $plugin_name;
		$this->taxonomy_name = $taxonomy_name;
	}
	public function check_acf_plugin($message){
		if( ! class_exists('ACF') ):
	         echo '<div class="notice notice-error ">
	             <p>Please install Advanced Custom Fields, it is required for the Bycycle Listing plugin to work properly!</p>
	         </div>';
         endif;
	}

	public function filter_by_bycycle_types(){
		global $typenow;
		global $wp_query;
	    if ($typenow==$this->plugin_name) {
	        $taxonomy = $this->taxonomy_name;
	        $bycycle_types_taxonomy = get_taxonomy($taxonomy);
	        wp_dropdown_categories(array(
	            'show_option_all' =>  __("Show All {$bycycle_types_taxonomy->label}"),
	            'taxonomy'        =>  $taxonomy,
	            'name'            =>   $this->taxonomy_name,
	            'orderby'         =>  'name',
	            'selected'        =>  $wp_query->query['term'],
	            'hierarchical'    =>  true,
	            'depth'           =>  3,
	            'show_count'      =>  true, 
	            'hide_empty'      =>  true, 
	        ));
	    }
	}

	public function register_bycycle_taxonomy() {

		register_taxonomy($this->taxonomy_name,$this->plugin_name,array(
		    'hierarchical' => false,
		    'label' => 'Bycycle Types',
		    'show_ui' => true,
		    'show_in_rest' => false,
		    'show_admin_column' => true,
		    'update_count_callback' => '_update_post_term_count',
		    'query_var' => true,
		    'rewrite' => array( 'slug' => $this->taxonomy_name ),
		  ));

	}
	public function create_bycycles_post_type() {
		$labels = array(
	        'name'               => ucfirst($this->plugin_name),
	        'menu_name'          => ucfirst($this->plugin_name),
	        'singular_name'      => 'Bycycle',
	        'all_items'          => ucfirst($this->plugin_name),
	        'search_items'       => 'Search '.ucfirst($this->plugin_name),
	        'add_new'            => 'Add New',
	        'add_new_item'       => 'Add New Bycycle',
	        'new_item'           => 'New Bycycle',
	        'view_item'          => 'View Bycycle',
	        'view_items'          => 'View '.ucfirst($this->plugin_name),
	        'edit_item'          => 'Edit Bycycle',
	        'not_found'          => 'No Bycycle Found.',
	        'not_found_in_trash' => 'Bycycle not found in Trash.',
	        'parent_item_colon'  => 'Parent Bycycle',
	    );

	    $args = array(
	        'supports'           => array( 'title', 'editor', 'custom-fields', 'page-attributes', 'post-formats' ),
	        'labels'             => $labels,
	        'taxonomies'            => array( $this->taxonomy_name,'custom-fields'),
	        'description'        => 'Bycycle',
	        'menu_position'      => 10,
	        'menu_icon'          => 'dashicons-list-view',
	        'public'             => true,
	        'publicly_queryable' => true,
	        'show_ui'            => true,
	        'show_in_menu'       => true,
	        'show_in_admin_bar'  => true,
	        'query_var'          => true,
	        'capability_type'    => 'post',
	        'has_archive'        => true,
	        'hierarchical'       => false,
	        'supports'           => array( 'title', 'thumbnail', 'editor' ),
	    );

	    register_post_type( $this->plugin_name, $args );
	}

	public function filter_search_bycycle_types_column( $column_id,$post_id ) {
		global $typenow;
	    if ($typenow==$this->plugin_name) {
	        $taxonomy =  $this->taxonomy_name;
	        switch ($column_name) {
	        case $this->taxonomy_name:
	            $bycycle_types = get_the_terms($post_id,$taxonomy);
	            if (is_array($bycycle_types)) {
	                foreach($bycycle_types as $key => $bycycle_type) {
	                    $edit_link = get_term_link($bycycle_type,$taxonomy);
	                    $bycycle_type[$key] = '<a href="'.$edit_link.'">' . $bycycle_type->name . '</a>';
	                }
	                echo implode(' | ',$bycycle_types);
	            }
	            break;
	        }
	    }
	}
	public function convert_id_to_taxonomy_term_in_query($query) {
		global $pagenow;
	    $qv = &$query->query_vars;
	    if ($pagenow=='edit.php' &&
	            isset($qv[$this->taxonomy_name]) && $qv['post_type']==$this->plugin_name && is_numeric($qv[$this->taxonomy_name])) {
	        $term = get_term_by('id',$qv[$this->taxonomy_name], $this->taxonomy_name);
	        $qv[$this->taxonomy_name] = $term->slug;
	    }
	}

}
