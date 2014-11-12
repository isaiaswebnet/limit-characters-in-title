<?php
/*
Plugin Name: Limit Characters in Title
Description: Limit the number of characters in Title (Post/Page).
Author: Isaías Oliveira
Author URI: https://www.facebook.com/isaiaswebnet
Version: 1.0
Text Domain: Limit-Characters-in-Title
License: GPLv2 or later
*/

if ( ! class_exists( 'Limit_Characters_Title' ) ) :

class Limit_Characters_Title {
	
	/* Construct Class */
    public function __construct() {

        /* Hooks */
		add_action( 'admin_init', array( $this, 'the_title_limit_meta_box_admin' ) );
		add_action( 'save_post', array( $this, 'save_the_title_limit' ) );
		add_filter( 'the_title', array( $this, 'the_title_limit' ) );
    }
	
	/* Add Meta Box Post/Page */
    public function the_title_limit_meta_box_admin() {
        $types = array( 'post', 'page' );
		foreach ( $types as $type ) {
		add_meta_box( 'limit-characters-in-title',  'Limite de Caracteres no Título', array( $this, 'the_title_limit_meta' ), $type, 'side', 'low');
		}
    }
	
	/* Input Limit Characters */
	public function the_title_limit_meta (){
		global $post;
 		$charlimit = get_post_custom( $post->ID );
		echo '<input type="number" name="charlimit" value="'.$charlimit["charlimit"][0].'" min="0" max="500" size="3" />';
	}
	
	/* Saves Meta Box Post/Page */
    public function save_the_title_limit() {
       global $post;
		update_post_meta( $post->ID, "charlimit", $_POST["charlimit"] );
    }
	
	/* Insert substr() in Title */
    public function the_title_limit ( $title_limit ) {
  		global $post;
  		if ( in_the_loop() && is_home ) {
 			$charlimit = get_post_meta( $post->ID, "charlimit", true );
    		$title_limit = $charlimit==''?$title_limit:substr( $title_limit, 0, $charlimit );
  		}
  		return $title_limit;
	}

}  // End Limit_Characters_Title class

$lctitle = new Limit_Characters_Title;

endif; // End Limit_Characters_Title class_exists

