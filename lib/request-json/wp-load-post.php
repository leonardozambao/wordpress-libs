<?php
require( '../../../../../wp-load.php' );

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(isset($_POST['page']))
		$pagina = $_POST['page'];
	else
		$pagina = 1;
		
	$argsQuery = array('paged' => $pagina);
	
	function search_filter($query) {
		if ($query->is_search && !is_admin() ) {
			if($_POST['post_type'] == 'biblioteca'){
				$query->set('post_type',array('biblioteca'));
			}else{
				$query->set('post_type',array('post','page'));
			}
		}
		return $query;
	}
	add_filter('pre_get_posts', 'search_filter');
	
	function filter_where( $where ) {
		$where .= '';
		if(!empty($_POST['data_inicio'])){
			if(!empty($_POST['data_inicio']) && !empty($_POST['data_fim'])){
				$where .= " AND post_date >= '".$_POST['data_inicio']."'";
			}
			if(!empty($_POST['data_fim'])){
				$where .= " AND post_date <= '".$_POST['data_fim']."'";
			}
		}
		return $where;
	}
	
	if(!empty($_POST['data_inicio']) || !empty($_POST['data_fim'])){
		add_filter( 'posts_where', 'filter_where' );
	}
	
	
	if(isset($_POST['post_type'])){ $argsQuery['post_type'] = $_POST['post_type']; }
	if(isset($_POST['cat'])){ $argsQuery['cat'] = $_POST['cat']; }
	if(isset($_POST['posts_per_page'])){ $argsQuery['posts_per_page'] = $_POST['posts_per_page']; }else{ $argsQuery['posts_per_page'] = get_option('posts_per_page');}
	if(isset($_POST['post__not_in'])){ $argsQuery['post__not_in'] = $_POST['post__not_in']; }
	if(isset($_POST['s'])){ $argsQuery['s'] = $_POST['s']; }
	
	
	if(isset($_POST['taxonomy_load'])){
		$argsQuery['tax_query'] = array(
			array(
				'taxonomy' => $_POST['taxonomy_load'],
				'terms' => $_POST['terms_load'],
				'field' => $_POST['field_load'],
			)
		);
	}
	
	//print_r($argsQuery);
	
	$QueryCategory = new Wp_query($argsQuery);
	
	$value = array('sucesso' => true);
	
	
	if($QueryCategory->have_posts()):
		while($QueryCategory->have_posts()): $QueryCategory->the_post();
			$catPost = get_the_category();
			if($catPost[1] != null){
				if($catPost[1]->parent > 0)
					$catPost[0] = $catPost[1];
				else
					$catPost[0] = $catPost[0];
			}else{
				$catPost[0] = $catPost[0];
			}
			if(isset($_POST['excerpt'])){
				Tema::set_excerpt($_POST['excerpt']['tamanho'],$_POST['excerpt']['texto'],$_POST['excerpt']['class'],$_POST['excerpt']['link']);
			}
			
			$array = array();
			$array['permalink'] = get_the_permalink();
			$array['title'] = get_the_title();
			$array['content'] = get_the_content();
			$array['excerpt'] = get_the_excerpt();
			$array['category'] = get_the_category();
			$array['datetime']['date'] = get_the_time('d-m-y');
			$array['datetime']['time'] = get_the_time('h:m:s');
			if(isset($_POST['date_format'])){
				$array['datetime']['date_format'] = get_the_time($_POST['date_format']);
			}
			$array['category'] = $catPost[0];
			$array['author'] = get_the_author();
			$array['post_type'] = get_post_type();
			
			if(isset($_POST['post_meta'])){
				for($i = 0; $i < count($_POST['post_meta']); $i++){
					$array['post_meta'][$_POST['post_meta'][$i]] = get_post_meta(get_the_ID(),$_POST['post_meta'][$i],true);
				}
			}
			
			if(isset($_POST['thumbnail'])){
				for($i = 0; $i < count($_POST['thumbnail']); $i++){
					$thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $_POST['thumbnail'][$i]);
					$array['thumbnail'][$_POST['thumbnail'][$i]] = $thumb['0'];
				}
			}
			
			$value['posts'][] = $array;
		endwhile;
	else:
		$value = array('sucesso' => false, 'argsQuery' => $argsQuery);
	endif;
	
	if(($pagina * $argsQuery['posts_per_page']) >= $QueryCategory->found_posts){
		$value['hide_button'] = true;
	}
}else{
	$value['code'] = '400';
	$value['erro'] = 'Request denied';
}

$output = json_encode($value);
echo $output;
?>