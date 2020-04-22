<?php
class Filtros{
	
	public function __construct(){
		add_filter('tiny_mce_before_init', array($this, 'fb_change_mce_options'));
		add_filter( 'wp_title', array($this, 'twentytwelve_wp_title'), 10, 2 );
	
		add_filter('query_vars', array($this, 'add_query_vars'));
		add_filter('pre_get_posts', array($this, 'search_filter'));
		
		add_action('admin_menu', array($this, 'remove_menus'));
		
		add_action('wp_head', array($this,'track_post_views'));
		
	}
	
	public function set_post_views($postID) {
		$cookie = strtotime(date('Y-m-d'));
		$pv_url = 'pvc_'.md5($_SERVER['REQUEST_URI']);
		if(is_single() && !isset($_COOKIE[$pv_url]) ){
			$count_key = 'post_views_count';
			$count = get_post_meta($postID, $count_key, true);
			//salvo num cookie que dura 5 minutos.
			setcookie($pv_url, $cookie, time()+(60 * 5), COOKIEPATH, COOKIE_DOMAIN); // 5 minutos
			if($count==''){
				$count = 1; //quando o usuário entra, já conta como 1 visita
				delete_post_meta($postID, $count_key);
				add_post_meta($postID, $count_key, $count);
			}else{
				$count++;
				update_post_meta($postID, $count_key, $count);
			}
		}
	}
	
	public function track_post_views($post_id) {
		if(!is_single()) return;
		if(empty($post_id)) {
			global $post;
			$post_id = $post->ID;    
		}
		$this->set_post_views($post_id);
	}
	
	public function add_query_vars($aVars){
		$aVars[] = "type";
		return $aVars;
	}
	public function search_filter($query) {
		if ($query->is_search && !is_admin() ) {
			$query->set('post_type',array('post','page','faq'));
		}
		return $query;
	}
	
	public function remove_menus(){
	  //remove_menu_page( 'index.php' );                  //Dashboard
	  //remove_menu_page( 'edit.php' );                   //Posts
	  //remove_menu_page( 'upload.php' );                 //Media
	  //remove_menu_page( 'edit.php?post_type=page' );    //Pages
	  remove_menu_page( 'edit-comments.php' );          //Comments
	  //remove_menu_page( 'themes.php' );                 //Appearance
	  //remove_menu_page( 'plugins.php' );                //Plugins
	  //remove_menu_page( 'users.php' );                  //Users
	  //remove_menu_page( 'tools.php' );                  //Tools
	  //remove_menu_page( 'options-general.php' );        //Settings
	}
	
	public function fb_change_mce_options($initArray) {
		$ext = 'pre[id|name|class|style],';
		$ext .= 'iframe[align|longdesc|name|width|height|class|style|frameborder|scrolling|marginheight|marginwidth|src],';
		$ext .= 'a[href|onclick|javascript|itemtype|itemprop|itemscope|target|class|style],';
		$ext .= 'div[itemtype|itemprop|itemscope|class|style],';
		$ext .= 'span[itemtype|itemprop|itemscope|class|style],';
		$ext .= 'p[itemtype|itemprop|itemscope|class|style],';
		$ext .= 'h2[itemtype|itemprop|itemscope|class|style],';
		$ext .= 'h3[itemtype|itemprop|itemscope|class|style],';
		$ext .= 'ul[itemtype|itemprop|itemscope|class|style],';
		$ext .= 'li[itemtype|itemprop|itemscope|class|style],';
		$ext .= 'strong[itemtype|itemprop|itemscope|class|style]';
		
		if ( isset( $initArray['extended_valid_elements'] ) ) {
			$initArray['extended_valid_elements'] .= ',' . $ext;
		} else {
			$initArray['extended_valid_elements'] = $ext;
		}
	 
		return $initArray;
	}
	
	
	public function twentytwelve_wp_title( $title, $sep ) {
		global $paged, $page;
	
		if ( is_feed() )
			return $title;
	
		$title .= get_bloginfo( 'name' );
	
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			$title = "$title $sep $site_description";
	
		if ( $paged >= 2 || $page >= 2 )
			$title = "$title $sep " . sprintf( __( 'Page %s', 'twentytwelve' ), max( $paged, $page ) );
	
		return $title;
	}
}
?>