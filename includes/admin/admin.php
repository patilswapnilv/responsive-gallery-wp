<?php

class wpdevar_gallery_admin_panel{
// previus defined admin constants
// wpdevart_gallery_plugin_url
// wpdevart_gallery_plugin_path
	private $text_fileds;
	function __construct(){
		$this->include_requared_files();
		$this->admin_filters();
	}
	
	/*###################### Admin filters function ##################*/			

	private function admin_filters(){
		//hook for admin menu
		add_action( 'admin_menu', array($this,'create_admin_menu') );
		/* for post page button*/
		add_filter( 'mce_external_plugins', array( $this ,'mce_external_plugins' ) );
		add_filter( 'mce_buttons', array($this, 'mce_buttons' ) );
		add_action('wp_ajax_wpdevart_gallery_post_page_content', array($this,"post_page_popup_content"));
	}
	//conect admin menu
	public function create_admin_menu(){
		/* conect admin pages to wordpress core*/
		$main_page=add_menu_page( "Wpdevart Gallery", "Wpdevart Gallery", 'manage_options', "Wpdevart_gallery_menu", array($this, 'create_gallery_page'),'dashicons-camera');
		add_submenu_page( "Wpdevart_gallery_menu", "Gallery", "Gallery", 'manage_options',"Wpdevart_gallery_menu",array($this, 'create_gallery_page'));
		$popup_page=$theme_subpage_popup=add_submenu_page( "Wpdevart_gallery_menu", "Popup", "Popup", 'manage_options',"wpdevart_gallery_popup",array($this, 'popup_settings_page'));
		$gallery_theme=add_submenu_page( "Wpdevart_gallery_menu", "Themes", "Themes", 'manage_options',"wpdevart_gallery_themes",array($this, 'gallery_themes_page'));
		$gallery_image_crop=add_submenu_page( "Wpdevart_gallery_menu", "Crope", "Crope", 'manage_options',"Wpdevart_gallery_crop",array($this, 'croping_page'));
		/*for including page styles and scripts*/
		add_action('admin_print_styles-' .$main_page, array($this,'create_gallery_page_style_js'));
		add_action('admin_print_styles-' .$popup_page, array($this,'create_popup_page_style_js'));
		add_action('admin_print_styles-' .$gallery_theme, array($this,'create_theme_page_style_js'));
		add_action('admin_print_styles-' .$gallery_image_crop, array($this,'create_crop_page_style_js'));
	}
	
	/* Gallery page style and js*/	
	public function create_gallery_page_style_js(){
		wp_enqueue_script('jquery');
		wp_enqueue_style('wpdevart_gallery_admin_gallery_page_css',wpdevart_gallery_plugin_url.'includes/admin/css/gallery_page.css');
		wp_enqueue_script('wpdevart_gallery_admin_gallery_page_css',wpdevart_gallery_plugin_url.'includes/admin/js/gallery_page.js');
	}
	
	/* Popup page style and js*/	
	public function create_popup_page_style_js(){
		wp_enqueue_style('FontAwesome');
		wp_enqueue_style('metrical_icons','https://fonts.googleapis.com/icon?family=Material+Icons');
		wp_enqueue_script('jquery');
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script('angularejs',wpdevart_gallery_plugin_url.'includes/admin/js/angular.min.js');
		wp_enqueue_style('wpdevart_gallery_admin_theme_page_css',wpdevart_gallery_plugin_url.'includes/admin/css/theme_page.css');
		wp_enqueue_style('wpdevart_gallery_admin_gallery_page_css',wpdevart_gallery_plugin_url.'includes/admin/css/popup_page.css');
		wp_enqueue_script('wpdevart_gallery_admin_gallery_page_css',wpdevart_gallery_plugin_url.'includes/admin/js/popup_page.js');
		wp_enqueue_script("admin_gallery_theme",wpdevart_gallery_plugin_url.'includes/admin/js/gallery_theme.js');                     //05-11-2017 added
	}
	
	/* Themes page style and js*/	
	public function create_theme_page_style_js(){
		wp_enqueue_script('jquery');
		wp_enqueue_script('angularejs',wpdevart_gallery_plugin_url.'includes/admin/js/angular.min.js');
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_style('wpdevart_gallery_admin_theme_page_css',wpdevart_gallery_plugin_url.'includes/admin/css/theme_page.css');
		wp_enqueue_script("admin_gallery_theme",wpdevart_gallery_plugin_url.'includes/admin/js/gallery_theme.js');
	}
	
	/* croping page style and js*/	
	public function create_crop_page_style_js(){
		wp_enqueue_script('jquery');
		wp_enqueue_style('wpdevart_gallery_admin_gallery_page_css',wpdevart_gallery_plugin_url.'includes/admin/css/croping_page.css');
		wp_enqueue_script('wpdevart_gallery_admin_gallery_page_css',wpdevart_gallery_plugin_url.'includes/admin/js/croping_page.js');
	}
	
	/* Gallery page main*/	
	public function create_gallery_page(){				
		$galler_page_objet=new wpda_gall_gallery_page();
		$galler_page_objet->controller();	
	}	
	
	/* Popup page function */
	public function popup_settings_page(){
		$popup_page_objet=new wpda_gall_popup_themes();
	}	
	/* Themes page function */		
	public function gallery_themes_page(){
		$popup_page_objet=new wpda_gall_themes();		
	}
	/* Croping page function */ 
	public function croping_page(){
		$croping_object=new wpda_gall_crop_page();	
		$croping_object->controller();		
	}
	/*post page button*/
	public function mce_external_plugins( $plugin_array ) {
		$plugin_array["wpdevart_gallery"] = wpdevart_gallery_plugin_url.'includes/admin/js/post_page_insert_button.js';
		return $plugin_array;
	}
	/**/
	public function mce_buttons( $buttons ) {
		array_push( $buttons, "wpdevart_gallery" );
		return $buttons;
	}
	public function post_page_popup_content(){
		$popup_page_objet=new wpda_gall_post_page_popup();
	}
	private function include_requared_files(){
		require_once(wpdevart_gallery_plugin_path.'includes/admin/gallery_page_class.php');	
		require_once(wpdevart_gallery_plugin_path.'includes/admin/popup_settings.php');	
		require_once(wpdevart_gallery_plugin_path.'includes/admin/gallery_theme.php');
		require_once(wpdevart_gallery_plugin_path.'includes/admin/croping_page.php');	
		require_once(wpdevart_gallery_plugin_path.'includes/admin/post_page_popup.php');			
	}
	
}
?>
