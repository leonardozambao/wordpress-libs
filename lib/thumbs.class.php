<?php
class Thumbs{
	private $list_thumbnail_size;
	
	public function __construct(){
		add_theme_support('post-thumbnails');
		set_post_thumbnail_size( 50, 50, true );
	}
	
	public function load_thumbnails(){
		foreach($this->list_thumbnail_size as $thumbnail){
			add_image_size($thumbnail['nome'], $thumbnail['width'], $thumbnail['height'], $thumbnail['crop']);
		}
	}
	
	public function set_thumbnail_size($nome, $width, $height, $crop = true){
		$this->list_thumbnail_size[] = array('nome' => $nome,'width' => $width, 'height' => $height, 'crop' => $crop);
	}
	
	public function get_image_post_content() {
		global $post, $posts;
		$first_img = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		$first_img = $matches [1] [0];
		return $first_img;
	}
}
?>