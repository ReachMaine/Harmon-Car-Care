<?php
/* 
require_once(get_stylesheet_directory().'/custom/woocommerce.php'); */
require_once(get_stylesheet_directory().'/custom/language.php'); 
require_once(get_stylesheet_directory().'/custom/cf7-ymmt.php');

	/***** change admin favicon *****/
	/* add favicons for admin */
	/*add_action('login_head', 'add_favicon');
	add_action('admin_head', 'add_favicon');
	
	function add_favicon() {
		$favicon_url = get_stylesheet_directory_uri() . '/images/admin-favicon.ico';
		echo '<link rel="shortcut icon" href="' . $favicon_url . '" />';
	} */
	
	/***** end admin favicon *****/
	/*****  change the login screen logo ****/
	function my_login_logo() { ?>
		<style type="text/css">
			body.login div#login h1 a {
				background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/admin-login.png);
				padding-bottom: 30px;
				background-size: contain;
				margin-left: 0px;
				margin-bottom: 0px;
				margin-right: 0px;
				width: 100%;
			}
		</style>
	<?php }
	add_action( 'login_enqueue_scripts', 'my_login_logo' );
	/**
 	* Functions of the child theme for Hairpress WP
 	*/
	add_action( "wp_enqueue_scripts", "add_additional_css", 20 );

	/**
	 * Add the style.css (from this folder) after the main.css file
	 *
	 * @link http://codex.wordpress.org/Function_Reference/wp_enqueue_style Codex for wp_enqueue_style()
	 */
	function add_additional_css() {
		wp_enqueue_style( 'child-css', get_stylesheet_uri() , array( 'main-css' ) );
	}

	/* add javascript for year-make-model selection on cf7 */
	add_action( "wp_enqueue_scripts", "ymmt_scripts", 20 );
	function ymmt_scripts() {
		wp_enqueue_script('ymmt-scripts', get_stylesheet_directory_uri() . '/custom/cf7-ymmt.js');
	}
	
	add_action('after_setup_theme', ea_setup);
	/**  ea_setup
	*  init stuff that we have to init after the main theme is setup.
	* 
	*/
	function ea_setup() {
	 /* do stuff ehre. */

	}
	// add categories ability to services custom post type.
	add_action('init', 'create_carpress_taxonomies');
	function create_carpress_taxonomies() {
		$labels = array(
			'name'              => _x( 'Service Categories', 'Categoies for Services' ),
			'singular_name'     => _x( 'Service Categoy', 'Category for Service' ),
			'search_items'      => __( 'Search Service Category' ),
			'all_items'         => __( 'All Service Category' ),
			'parent_item'       => __( 'Parent Service Category' ),
			'parent_item_colon' => __( 'Parent Service Category:' ),
			'edit_item'         => __( 'Edit Service Category' ),
			'update_item'       => __( 'Update Service Category' ),
			'add_new_item'      => __( 'Add New Service Category' ),
			'new_item_name'     => __( 'New Service Category Name' ),
			'menu_name'         => __( 'Category' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'service_type' ),
		);

		register_taxonomy( 'service_category', array( 'services' ), $args );

	}

	/* add widget in single servces */
	if ( function_exists('register_sidebar') ){
		 register_sidebar(array(
			'name' => 'Service Top - single',
			'id' => 'servicetop',
			'description' => 'Widget top of single service',
			'before_widget' => '<div class="row "><div class="span9">', // <div class="span3"><div class="%2$s">
			'after_widget'  => '</div></div>', // </div></div>
			'before_title'  => '',
			'after_title'   => '',
		)); 
	} // end function_exists('register_sidebar')	
	add_image_size( 'services-icon', 60, 60, true );
?>
