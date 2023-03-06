<?php 

/**
 * Class to register profile custom post type
 */
class WPProfileCPT
{	
	function __construct()
    {
        add_action( 'init', array( $this, 'init_action' ) );

    	require_once __DIR__ . '/wp-profile-meta.php';
        new WPProfileMeta();
    }

    /**
	 * Init action fucntion.
	 */
	public function init_action()
    {
        $this->registere_profile_cpt();
        $this->registere_profile_taxonomies();
    }

    /**
	 * Regsiter profile custom post type 
	 */
    public function registere_profile_cpt()
    {
        $labels = array(
            'name'                  => _x( 'Profiles', 'Post type general name', 'wp-profile' ),
            'singular_name'         => _x( 'profile', 'Post type singular name', 'wp-profile' ),
            'menu_name'             => _x( 'Profiles', 'Admin Menu text', 'wp-profile' ),
            'name_admin_bar'        => _x( 'profile', 'Add New on Toolbar', 'wp-profile' ),
            'add_new'               => __( 'Add New', 'wp-profile' ),
            'add_new_item'          => __( 'Add New profile', 'wp-profile' ),
            'new_item'              => __( 'New profile', 'wp-profile' ),
            'edit_item'             => __( 'Edit profile', 'wp-profile' ),
            'view_item'             => __( 'View profile', 'wp-profile' ),
            'all_items'             => __( 'All Profiles', 'wp-profile' ),
            'search_items'          => __( 'Search Profiles', 'wp-profile' ),
            'parent_item_colon'     => __( 'Parent Profiles:', 'wp-profile' ),
            'not_found'             => __( 'No profiles found.', 'wp-profile' ),
            'not_found_in_trash'    => __( 'No profiles found in Trash.', 'wp-profile' ),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'menu_icon'          => 'dashicons-businessman',
            'supports'           => array( 'title' ),
        );

        register_post_type( 'wp-profiles', $args );
    }

    /**
	 * Register skills and eductioan taxonomies to profile custom post type
	 */
    public function registere_profile_taxonomies()
    {
        // Add new skills taxonomy
        $labels = array(
            'name'              => _x( 'Skills', 'taxonomy general name', 'wp-profile' ),
            'singular_name'     => _x( 'Skill', 'taxonomy singular name', 'wp-profile' ),
            'search_items'      => __( 'Search Skills', 'wp-profile' ),
            'all_items'         => __( 'All Skills', 'wp-profile' ),
            'parent_item'       => __( 'Parent Skill', 'wp-profile' ),
            'parent_item_colon' => __( 'Parent Skill:', 'wp-profile' ),
            'edit_item'         => __( 'Edit Skill', 'wp-profile' ),
            'update_item'       => __( 'Update Skill', 'wp-profile' ),
            'add_new_item'      => __( 'Add New Skill', 'wp-profile' ),
            'new_item_name'     => __( 'New Skill Name', 'wp-profile' ),
            'menu_name'         => __( 'Skills', 'wp-profile' ),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            
        );

        register_taxonomy( 'skills', array( 'wp-profiles' ), $args );

        unset( $args );
        unset( $labels );

        // Add new education taxonomy
        $labels = array(
            'name'              => _x( 'Education', 'taxonomy general name', 'wp-profile' ),
            'singular_name'     => _x( 'Education', 'taxonomy singular name', 'wp-profile' ),
            'search_items'      => __( 'Search Education', 'wp-profile' ),
            'all_items'         => __( 'All Education', 'wp-profile' ),
            'parent_item'       => __( 'Parent Education', 'wp-profile' ),
            'parent_item_colon' => __( 'Parent Education:', 'wp-profile' ),
            'edit_item'         => __( 'Edit Education', 'wp-profile' ),
            'update_item'       => __( 'Update Education', 'wp-profile' ),
            'add_new_item'      => __( 'Add New Education', 'wp-profile' ),
            'new_item_name'     => __( 'New Education Name', 'wp-profile' ),
            'menu_name'         => __( 'Education', 'wp-profile' ),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
        );

        register_taxonomy( 'education', array( 'wp-profiles' ), $args );
    }
}