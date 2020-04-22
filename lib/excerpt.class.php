<?php
class Excerpt{
	public $excerpt;
	public $texto;
	public $CssClass;
	public $link;
	
	public function __construct(){
		
	}
	
	public function set_excerpt($tamanho){
		$this->excerpt = $tamanho;
		add_filter('excerpt_length', array($this,'add_excerpt'));
	}
	
	public function add_excerpt($length){
		return $this->excerpt;
	}
	
	public function set_excerpt_more_link($texto, $class, $link){
		$this->texto = $texto;
		$this->CssClass = $class;
		$this->link = $link;
		add_filter('excerpt_more', array($this, 'add_excerpt_more_link'));
	}
	
	public function add_excerpt_more_link($length){
		global $post;
		if($this->link){
			return '. <a href="'.get_permalink($post->ID).'" class="'.$this->CssClass.'">'.$this->texto.'</a>';
		}else{
			return $this->texto;
		}
	}
}
?>