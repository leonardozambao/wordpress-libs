<?php
class Sidebar{
	private $list_sidebars;
	
	public function __construct(){
		//register_sidebars(1);
		$this->list_sidebars = array();
	}
	
	public function add_sidebars(){
		$sidebars = array();
		foreach($this->list_sidebars as $sidebar){
			register_sidebar(array(
				'name'          => $sidebar['nome'],
				'id'            => $sidebar['slug'],
				'before_widget' => '<div class="'.$sidebar['class_widget'].'">',
				'after_widget'  => '</div>',
				'before_title'  => '<h2 class="'.$sidebar['class_titulo'].'">',
				'after_title'   => '</h2>',
			));
		}
	}
	
	public function set_sidebar($nome, $slug, $class_titulo, $class_widget){
		$this->list_sidebars[] = array('nome' => $nome,'slug' => $slug, 'class_titulo' => $class_titulo, 'class_widget' => $class_widget);
	}
}
?>