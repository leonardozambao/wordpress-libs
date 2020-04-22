<?php
class PostType{
	
	public function add_type($nome_plural, $nome_singular, $slug, $feminino = false, $icone = 'dashicons-admin-generic', $supports = array('title', 'thumbnail', 'excerpt', 'page_attributes','editor','author'),$search = false,$rewrite = ''){
			
			if($feminino){
				$labels = array(
					'name' => _x($nome_plural, 'post type general name', 'theme_padrao'),
					'singular_name' => _x($nome_singular, 'post type singular name', 'theme_padrao'),
					'add_new' => _x('Adicionar nova', strtolower($nome_singular), 'theme_padrao'),
					'add_new_item' => __('Adicionar nova', 'theme_padrao'),
					'edit_item' => __('Editar '.strtolower($nome_singular), 'theme_padrao'),
					'new_item' => __('Nova '.strtolower($nome_singular), 'theme_padrao'),
					'all_items' => __('Todas as '.strtolower($nome_plural), 'theme_padrao'),
					'view_item' => __('Todas as '.strtolower($nome_plural), 'theme_padrao'),
					'search_items' => __('Procurar '.strtolower($nome_singular), 'theme_padrao'),
					'not_found' =>  __('Nenhuma '.strtolower($nome_singular).' encontrada', 'theme_padrao'),
					'not_found_in_trash' => __('Nenhuma '.strtolower($nome_singular).' encontrada na lixeira', 'theme_padrao'), 
					'parent_item_colon' => '',
					'menu_name' => __($nome_plural, 'theme_padrao')
				);
			}else{
				$labels = array(
					'name' => _x($nome_plural, 'post type general name', 'theme_padrao'),
					'singular_name' => _x($nome_singular, 'post type singular name', 'theme_padrao'),
					'add_new' => _x('Adicionar novo', strtolower($nome_singular), 'theme_padrao'),
					'add_new_item' => __('Adicionar novo', 'theme_padrao'),
					'edit_item' => __('Editar '.strtolower($nome_singular), 'theme_padrao'),
					'new_item' => __('Novo '.strtolower($nome_singular), 'theme_padrao'),
					'all_items' => __('Todos os '.strtolower($nome_plural), 'theme_padrao'),
					'view_item' => __('Todos os '.strtolower($nome_plural), 'theme_padrao'),
					'search_items' => __('Procurar '.strtolower($nome_singular), 'theme_padrao'),
					'not_found' =>  __('Nenhum '.strtolower($nome_singular).' encontrado', 'theme_padrao'),
					'not_found_in_trash' => __('Nenhum '.strtolower($nome_singular).' encontrado na lixeira', 'theme_padrao'), 
					'parent_item_colon' => '',
					'menu_name' => __($nome_plural, 'theme_padrao')
				);
			}
		  
			$config = array(
				'labels' => $labels,
				'public' => true,
				'publicly_queryable' => true,
				'show_ui' => true, 
				'show_in_menu' => true, 
				'query_var' => true,
				'rewrite' => array('slug' => (($rewrite != '')? $rewrite : $slug)),
				'capability_type' => 'post',
				'has_archive' => true, 
				'hierarchical' => false,
				'menu_position' => 22,
				'menu_icon'   => $icone,
				'exclude_from_search' => $search,
				'supports' => $supports
			); 
		  
		  register_post_type($slug, $config);
	}

	public function add_taxonomy($nome_plural, $nome_singular, $slug, $rewrite, $post_type, $feminino = false , $hierarchical = true){
		
		if($feminino){
			$labels = array(
				'name' => _x( $nome_plural, 'taxonomy general name' ), 
				'singular_name' => _x( $nome_singular, 'taxonomy singular name' ),
				'search_items' =>  __( 'Buscar '.strtolower($nome_singular) ),
				'all_items' => __( 'Todas as '.strtolower($nome_singular) ),
				'parent_item' => __( $nome_singular.' Pai' ),
				'parent_item_colon' => __( $nome_singular.' Pai:' ),
				'edit_item' => __( 'Editar '.strtolower($nome_singular) ), 
				'update_item' => __( 'Atualizar' ),
				'add_new_item' => __( 'Adicionar' ),
				'new_item_name' => __( 'Nome da'.strtolower($nome_singular) ),
				'menu_name' => __( $nome_plural ),
			); 	
		}else{
			$labels = array(
				'name' => _x( $nome_plural, 'taxonomy general name' ), 
				'singular_name' => _x( $nome_singular, 'taxonomy singular name' ),
				'search_items' =>  __( 'Buscar '.strtolower($nome_singular) ),
				'all_items' => __( 'Todos os '.strtolower($nome_singular) ),
				'parent_item' => __( $nome_singular.' Pai' ),
				'parent_item_colon' => __( $nome_singular.' Pai:' ),
				'edit_item' => __( 'Editar '.strtolower($nome_singular) ), 
				'update_item' => __( 'Atualizar' ),
				'add_new_item' => __( 'Adicionar' ),
				'new_item_name' => __( 'Nome do'.strtolower($nome_singular) ),
				'menu_name' => __( $nome_plural ),
			); 
		}
		$config = array(
			'hierarchical' => $hierarchical, //Use "true" para criar taxonomu no estilo categorias. "False", cria uma taxonomy no estilo de tags
			'labels' => $labels,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => $rewrite )
		);
	    
		register_taxonomy($slug,$post_type, $config);
	}
}
?>