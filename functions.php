<?php
require_once get_template_directory().'/lib/custom-post-type/post-type.class.php';
require_once get_template_directory().'/lib/editor/editor.class.php';
require_once get_template_directory().'/lib/phpmailer/class.phpmailer.php';
require_once get_template_directory().'/lib/tag.class.php';
require_once get_template_directory().'/lib/thumbs.class.php';
require_once get_template_directory().'/lib/menus.class.php';
require_once get_template_directory().'/lib/sidebar.class.php';
require_once get_template_directory().'/lib/util.class.php';
require_once get_template_directory().'/lib/filtro.class.php';
require_once get_template_directory().'/lib/taxonomy.class.php';
require_once get_template_directory().'/lib/custom-fields.class.php';
require_once get_template_directory().'/lib/custom-fields-category.class.php';
require_once get_template_directory().'/lib/admin.class.php';
require_once get_template_directory().'/lib/excerpt.class.php';
require_once get_template_directory().'/lib/tema.class.php';
require_once get_template_directory().'/lib/VueJS.php';

// criando o menu 

//register_nav_menus(
//    array(
//        'footer_menu_institucional' => 'Menu Rodapé Institucional',
//        'footer_menu_atendimento' => 'Menu Rodapé Atendimento',
//        'footer_menu_imoveis' => 'Menu Rodapé Imóveis',
//    )
//);

//adicionando suporte à imagem destacada nos posts

add_theme_support( 'post-thumbnails' ); 

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/GetBanners', array(
        'methods' => 'GET',
        'callback' => 'GetBanners',
    ) );
} );

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/GetOQueProcura', array(
        'methods' => 'GET',
        'callback' => 'GetOQueProcura',
    ) );
} );

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/GetFazerPorVoce', array(
        'methods' => 'GET',
        'callback' => 'GetFazerPorVoce',
    ) );
} );

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/GetLinhaCompleta', array(
        'methods' => 'GET',
        'callback' => 'GetLinhaCompleta',
    ) );
} );

function GetBanners() {
    $args = array(
        'post_type' => "banners-destaque",
        'showposts' => -1,
    );
    $array = get_posts($args);
    foreach ($array as $key_ => $item) {
        $array[$key_]->permalink = get_the_permalink($item->ID);
        $array[$key_]->linkBtn = get_post_meta($item->ID, 'link_botao');
        $array[$key_]->textBtn = get_post_meta($item->ID, 'texto_botao');
        $array[$key_]->textBanner = get_post_meta($item->ID, 'texto_banner');
        $array[$key_]->bannerDesk = wp_get_attachment_image_url(get_post_meta($item->ID, 'banner_desktop', true), 'thumb_1920x555');
        $array[$key_]->bannerMobile = wp_get_attachment_image_url(get_post_meta($item->ID, 'banner_mobile', true), 'thumb_768x795');
    }
return $array;
}

function GetOQueProcura() {
    $args = array(
        'post_type' => "conteudo",
        'showposts' => 3,
        'tax_query' => array(
            array(
                'taxonomy' => 'type_conteudo',
                'terms' => 'o-que-procura', 
                'field' => 'slug',  
            )
        ),
    );
    $array = get_posts($args);
    foreach ($array as $key_ => $item) {
        $array[$key_]->link = get_post_meta($item->ID, 'link');
        $array[$key_]->thumbnail = get_the_post_thumbnail_url($item->ID,'thumb_267x150');
        $array[$key_]->nome = get_the_title($item->ID);
    }
return $array;
}

function GetFazerPorVoce() {
    $args = array(
        'post_type' => "conteudo",
        'showposts' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'type_conteudo',
                'terms' => 'fazer-por-voce', 
                'field' => 'slug',  
            )
        ),
    );
    $array = get_posts($args);
    foreach ($array as $key_ => $item) {
        $array[$key_]->thumbnail = get_the_post_thumbnail_url($item->ID,'thumb_267x150');
        $array[$key_]->nome = get_the_title($item->ID);
    }
return $array;
}

function GetLinhaCompleta() {
    $array = get_terms(array(
        'taxonomy' => 'categoria',
        'hide_empty' => false,
    ));
    foreach ($array as $key_ => $item) {
        $array[$key_]->thumbnail = wp_get_attachment_image_url(get_term_meta($item->term_id, 'thumbnail', true), 'full');
        $array[$key_]->link = get_term_link($item->term_id, 'categoria');
    }
return $array;
}

 define( 'WP_DEBUG', true );
 define( 'WP_DEBUG_DISPLAY', true );

