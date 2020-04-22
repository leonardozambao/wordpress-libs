<?php
class Tags{
	private $tagPadrao = true;
	
	public function __construct(){
		add_action( 'init', array($this, 'resitrar_novas_tags'));
		
		if($this->tagPadrao)
			add_action( 'init', array($this, 'remove_tags_padrao'));
	}
	
	public function resitrar_novas_tags() {
		register_taxonomy(
			'pessoas',
			'post',
			array(
				'label' => __( 'Pessoas' ),
				'rewrite' => array( 'slug' => 'pessoas' ),
				'hierarchical' => false,
			)
		);
		register_taxonomy(
			'empresas',
			'post',
			array(
				'label' => __( 'Empresas' ),
				'rewrite' => array( 'slug' => 'empresas' ),
				'hierarchical' => false,
			)
		);
		register_taxonomy(
			'produtos',
			'post',
			array(
				'label' => __( 'Produtos' ),
				'rewrite' => array( 'slug' => 'produtos' ),
				'hierarchical' => false,
			)
		);
		register_taxonomy(
			'assuntos',
			'post',
			array(
				'label' => __( 'Assuntos' ),
				'rewrite' => array( 'slug' => 'assuntos' ),
				'hierarchical' => false,
			)
		);
	}
	
	public function remove_tags_padrao() {
		global $wp_taxonomies;
		$tax = 'post_tag'; // this may be wrong, I never remember the names on the defaults
		if( taxonomy_exists( $tax ) )
			unset( $wp_taxonomies[$tax] );
	}
}
?>