<?php
class Editor{
	
	public function __construct(){
		add_shortcode('youtube', array($this, 'youtube_func'));
		add_action('init', array($this, 'add_youtube_button'));
	}
		
	/** Youtube Video Shortcode
		[youtube width="640" height="385" video_id="EhkHFenJ3rM"]
	**/
	public function youtube_func($atts) {
		//extract short code attr
		extract(shortcode_atts(array(
			'width' => 600,
			'height' => 365,
			'video_id' => '',
		), $atts));
		$custom_id = time().rand();
		$return_html = '<object type="application/x-shockwave-flash" data="http://www.youtube.com/v/'.$video_id.'&hd=1" style="width:'.$width.'px;height:'.$height.'px"><param name="wmode" value="opaque"><param name="movie" value="http://www.youtube.com/v/'.$video_id.'&hd=1" /></object>';
		return $return_html;
	}
	
	/*youtube Button*/
	public function add_youtube_button() {  
		if (current_user_can('edit_posts') &&  current_user_can('edit_pages')){  
		   add_filter('mce_buttons_3', array($this, 'register_youtube_button'));  
		   add_filter('mce_external_plugins', array($this, 'add_youtube_plugin'));  
		}  
	}  
	public function register_youtube_button($buttons) {  
		array_push($buttons, "youtube");  
		return $buttons;  
	}  
	public function add_youtube_plugin($plugin_array) {  
		$plugin_array['youtube'] = get_template_directory_uri().'/lib/editor/iframe.js';  
		return $plugin_array;  
	}
	
}
$Editor = new Editor();
?>