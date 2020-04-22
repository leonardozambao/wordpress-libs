<?php
class Menus{
	private $list_nav;
	
	public function __construct(){
		$this->list_meta_box = array();
	}
	
	public function add_nav(){
		foreach($this->list_nav as $nav){
			register_nav_menu($nav['slug'],$nav['nome']);
		}
	}
	
	public function set_nav($nome, $slug){
		$this->list_nav[] = array('nome' => $nome,'slug' => $slug);
	}
}
?>