<?php
class Tema{
	public $post_type, $filtros, $thumbs, $menus, $sidebar, $admin, $metabox, $category,$excerpt, $util;

	public function __construct(){
		$this->post_type = new PostType();
        $this->filtros = new Filtros();
		$this->taxonomy = new Taxonomy();
		$this->thumbs = new Thumbs();
		$this->menus = new Menus();
		$this->sidebar = new Sidebar();
		$this->metabox = new Meta_Box();
		$this->category = new Custom_Category();
		$this->admin = new Admin();
		$this->util = new Util();
		add_action('init', array($this, 'Inicializa'));
	}

    public function Inicializa(){
        global $wpdb;

        /* ------------- Pages ------------- */
        $this->metabox->set_meta_box(
            'Dados da página','dados_pagina',array('page')
        );
        $this->metabox->set_custom_field(
            'Blocos','lista_blocos','blocos',null,'dados_pagina'
        );
        /* ------------- Pages ------------- */


        /* ------------- Conteudos ------------- */
        $this->post_type->add_type('Conte&uacute;dos', 'Conte&uacute;do', 'conteudo', false, 'dashicons-yes', array('title', 'thumbnail', 'editor'), false,'');

        // Adiciona taxonomy ao post type
        $this->post_type->add_taxonomy('Tipos de Conte&uacute;do', 'Tipo de Conte&uacute;do', 'type_conteudo', '', array('conteudo'));
        $this->category->add_custom_fields('type_conteudo');
        $this->category->save_custom_fields('type_conteudo');
        // $this->metabox->set_meta_box(
        //     'Galeria da imagens','galeria_imagens',array('page')
        // );
        // $this->metabox->set_custom_field(
        //     'Galeria','galeria_imagens','galeria',null,'galeria_imagens'
        // );
        // $this->metabox->set_custom_field(
        //     'Galeria Mobile','galeria_imagens_mobile','galeria',null,'galeria_imagens'
        // );
        $this->metabox->set_meta_box(
            'Campos adicionais','campos_adicionais',array('conteudo')
        );
        $this->metabox->set_custom_field(
            'Link','link','text',null,'campos_adicionais'
        );
        /* ------------- Conteudos ------------- */

        /* ------------- Posts ------------- */
        // $this->metabox->set_meta_box(
        //     'Banner principal Desktop','dados_post_banner',array('post')
        // );
        // $this->metabox->set_meta_box(
        //     'Banner principal mobile','dados_post_banner_mobile',array('post')
        // );
        // $this->metabox->set_meta_box(
        //     'Dados do post','dados_post',array('post')
        // );
        // $this->metabox->set_custom_field(
        //     'Destaque na Home','destaque_meta','checkbox',
        //     array(
        //         array('text' => 'Destaque','valor' => 'destaque'),
        //     ),
        //     'dados_post'
        // );
        // $this->metabox->set_custom_field(
        //     'Imagem','imagem_banner','imagem',null, 'dados_post_banner'
        // );
        // $this->metabox->set_custom_field(
        //     'Imagem','imagem_banner_mobile','imagem',null, 'dados_post_banner_mobile'
        // );
        // $this->metabox->set_custom_field(
        //     'Galeria','galeria_imagens','galeria',null,'dados_post'
        // );


        $this->metabox->add_metas_box();
        /* ------------- Posts ------------- */



         /* ------------- Produtos ------------- */
         $this->post_type->add_type('Produtos', 'Produtos', 'produtos', false, 'dashicons-cart', array('title', 'editor', 'thumbnail'), false);
         $this->metabox->set_meta_box(
             'Dados','dados_produto',array('produtos')
         );
         $this->post_type->add_taxonomy('Categoria de Produtos', 'Categorias', 'categoria', 'categoria', array('produtos'));
        $this->taxonomy->addField('Imagem destaque', 'thumbnail', 'imagem', '', 'categoria');

         /* ------------- BANNERS DESTAQUE ------------- */
         $this->post_type->add_type('Banners destaque', 'Banners destaque', 'banners-destaque', false, 'dashicons-format-gallery', array('title'), false);
        // $this->post_type->add_taxonomy('Redação', 'Redação', 'redacao', 'redacao', array('midia'));
         $this->metabox->set_meta_box(
             'Dados do Banner','dados_banner',array('banners-destaque')
         );
         $this->metabox->set_custom_field(
            'Texto Banner','texto_banner','text',null,'dados_banner'
        );
         $this->metabox->set_custom_field(
             'Texto Botão','texto_botao','text',null,'dados_banner'
         );
         $this->metabox->set_custom_field(
             'Link Botão','link_botao','text',null,'dados_banner'
         );
         $this->metabox->set_custom_field(
            'Banner desktop','banner_desktop','imagem',null,'dados_banner'
        );
         
        $this->metabox->set_meta_box(
             'Dados do Banner mobile','dados_banner_mobile',array('banners-destaque')
         );
        $this->metabox->set_custom_field(
            'Banner mobile','banner_mobile','imagem',null,'dados_banner_mobile'
        );


        /* ------------- Tamanho Imagens ------------- */
        $this->thumbs->set_thumbnail_size('thumb_1280x585',1280,585);
        $this->thumbs->set_thumbnail_size('thumb_1280x485',1280,485);
        $this->thumbs->set_thumbnail_size('thumb_1280x380',1280,380);
        $this->thumbs->set_thumbnail_size('thumb_1280x355',1280,355);
        $this->thumbs->set_thumbnail_size('thumb_1280x305',1280,305);
        $this->thumbs->set_thumbnail_size('thumb_1024x520',1024,520);
        $this->thumbs->set_thumbnail_size('thumb_768x795',768,795);
        $this->thumbs->set_thumbnail_size('thumb_635x300',635,300);
        $this->thumbs->set_thumbnail_size('thumb_378x378',378,378);
        $this->thumbs->set_thumbnail_size('thumb_380x225',380,225);
        $this->thumbs->set_thumbnail_size('thumb_galeria',150,230, true);
        $this->thumbs->set_thumbnail_size('thumb_185x95',185,95);
        $this->thumbs->set_thumbnail_size('thumb_160x75',160,75);
        $this->thumbs->set_thumbnail_size('thumb_95x75',95,75);
        $this->thumbs->set_thumbnail_size('thumb_95x95',95,95);
        $this->thumbs->set_thumbnail_size('thumb_35x35',35,35);

        $this->thumbs->load_thumbnails();
        /* ------------- Tamanho Imagens ------------- */


        $this->admin->add_pages();


        $this->metabox->set_meta_box(
            'Dados da Página','dados_pagina',array('page')
        );
        // $this->metabox->set_custom_field(
        //     'Descrição','descricao', 'editor',null,'dados_pagina'
        // );
        // $this->metabox->set_custom_field(
        //     'Subtitulo','subtitulo', 'text',null,'dados_pagina'
        // );


        // $this->metabox->set_custom_field(
        //     'Link Youtube','link_video', 'text',null,'dados_pagina'
        // );


        /* ----- GALERIA MODALIDADES ------- */

        /* FORMULÁRIOS */
        $this->admin->set_page('Formularios','formularios','page.php', 'dashicons-email-alt', 999,
            array(array('Fale Conosco','fale-conosco','subpage.php', '', 3))
        );
        $this->admin->set_option(
            'Envio Autenticado?','envio_email_atutenticado', 'radio',
            array(
                array('text' => 'Sim','valor' => 'sim'),
                array('text' => 'Não','valor' => 'nao'),
            ),
            'formularios'
        );
        $this->admin->set_option('Servidor:','servidor_smtp', 'text',null,'formularios','Ex: smtp.localhost.com.br',250);
        $this->admin->set_option('Porta:','porta_smtp', 'text',null,'formularios','Caso não use, deixar em branco',100);


        $this->admin->set_option(
            'SMTPSecure','secure_smtp', 'radio',
            array(
                array('text' => 'TLS','valor' => 'tls'),
                array('text' => 'SSL','valor' => 'ssl'),
                array('text' => 'Não usar','valor' => ''),
            ),
            'formularios'
        );


        $this->admin->set_option('Usuário:','usuario_smtp', 'text',null,'formularios','',250);
        $this->admin->set_option('Senha:','senha_smtp', 'password',null,'formularios','',250);
        $this->admin->set_option('E-mail que envia:','email_envio_smtp', 'text',null,'formularios','',250);
        $this->admin->set_option('Enviar email teste (pressione enter)','email_teste', 'text',null,'formularios','',250);

        // Página Fale Conosco
        $this->admin->set_option('E-mail receptor:','email_receptor_fale_conosco', 'text',null,'fale-conosco','',300);
        $this->admin->set_option('Assunto:','assunto_fale_conosco', 'text',null,'fale-conosco');
        $this->admin->set_option('Mensagem de envio:','msg_envio_fale_conosco', 'text',null,'fale-conosco');
        $this->admin->set_option('Mensagem de erro ao enviar:','msg_erro_fale_conosco', 'text',null,'fale-conosco');
        $this->admin->set_option('Mensagem de preenchimento de campos:','msg_preencimento_fale_conosco', 'text',null,'fale-conosco');

        $this->admin->set_list_table('Lista de contatos',"SELECT * FROM ".$wpdb->prefix."formularios where tipo_formulario = 'fale-conosco' ORDER BY id DESC", true,
            array('Nome' => 'nome', 'E-mail' => 'email', 'Assunto' => 'assunto', 'Telefone' => 'telefone', 'Mensagem' => 'mensagem')
            ,'fale-conosco');

        /* ------------- Links redes sociais ------------- */
        $this->admin->set_page('Links Rodapé','configs-rodape','page.php', 'dashicons-share', 999);

        $this->admin->set_option('Aplicativo Google Play','googlePlay_rodape', 'text',null,'configs-rodape');
        $this->admin->set_option('Aplicativo App Store','appStore_rodape', 'text',null,'configs-rodape');

        $this->admin->set_option('Fale Conosco','faleConosco_rodape', 'text',null,'configs-rodape');
        $this->admin->set_option('Centrais de Vendas','centrais_rodape', 'text',null,'configs-rodape');
        $this->admin->set_option('Indicação Premiada','indicacao_rodape', 'text',null,'configs-rodape');

        $this->admin->set_option('Facebook (link)','face_rodape', 'text',null,'configs-rodape');
        $this->admin->set_option('Instagram (link)','instagram_rodape', 'text',null,'configs-rodape');
        $this->admin->set_option('Pinterest (link)','pinterest_rodape', 'text',null,'configs-rodape');
        $this->admin->set_option('Linkedin (link)','linkedin_rodape', 'text',null,'configs-rodape');
        $this->admin->set_option('Youtube (link)','youtube_rodape', 'text',null,'configs-rodape');
        // $this->admin->set_option('Twitter (link)','twitter_rodape', 'text',null,'configs-rodape');
        $this->taxonomy->RegisterFields(); 
        $this->metabox->add_metas_box();
    }
}
$Tema = new Tema();


?>