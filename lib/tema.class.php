<?php
class Tema{
	public $post_type, $filtros, $thumbs, $menus, $sidebar, $admin, $metabox, $category,$excerpt, $util;

	public function __construct(){
		$this->post_type = new PostType();
		$this->filtros = new Filtros();
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
        $this->metabox->set_meta_box(
            'Banner principal Desktop','dados_post_banner',array('post')
        );
        $this->metabox->set_meta_box(
            'Banner principal mobile','dados_post_banner_mobile',array('post')
        );
        $this->metabox->set_meta_box(
            'Dados do post','dados_post',array('post')
        );
        $this->metabox->set_custom_field(
            'Destaque na Home','destaque_meta','checkbox',
            array(
                array('text' => 'Destaque','valor' => 'destaque'),
            ),
            'dados_post'
        );
        $this->metabox->set_custom_field(
            'Imagem','imagem_banner','imagem',null, 'dados_post_banner'
        );
        $this->metabox->set_custom_field(
            'Imagem','imagem_banner_mobile','imagem',null, 'dados_post_banner_mobile'
        );
        $this->metabox->set_custom_field(
            'Galeria','galeria_imagens','galeria',null,'dados_post'
        );


        $this->metabox->add_metas_box();
        /* ------------- Posts ------------- */



         /* ------------- Produtos ------------- */
         $this->post_type->add_type('Produtos', 'Produtos', 'produto', false, 'dashicons-cart', array('title', 'editor', 'thumbnail'), false);
         $this->metabox->set_meta_box(
             'Dados de Produtos','dados_modelo',array('produto')
         );
         $this->post_type->add_taxonomy('Categoria de Produtos', 'Categorias', 'categoria', 'categoria', array('produto'));

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

        // /* ------------- Modelos ------------- */
        // $this->post_type->add_type('Modelos', 'Modelos', 'modelo', false, 'dashicons-building', array('title', 'editor', 'thumbnail'), false);
        // $this->metabox->set_meta_box(
        //     'Dados da Modelos','dados_modelo',array('modelo')
        // );
        // $this->metabox->set_custom_field(
        //     'Subtítulo','modelo_subtitulo','text',null,'dados_modelo'
        // );
        // $this->metabox->set_custom_field(
        //     'Vantagens','vantagens_subtitulo','editor',null,'dados_modelo'
        // );
        // $this->metabox->set_custom_field(
        //     'Investimento mínimo','investimento_subtitulo','text',null,'dados_modelo'
        // );
        // $this->metabox->set_custom_field(
        //     'Taxa de franquia','taxa_subtitulo','text',null,'dados_modelo'
        // );
        // $this->metabox->set_custom_field(
        //     'Faturamento médio','faturamento_subtitulo','text',null,'dados_modelo'
        // );
        // $this->metabox->set_custom_field(
        //     'Retorno','retorno_subtitulo','text',null,'dados_modelo'
        // );

        /* ------------- Escritorios ------------- */
       /* $this->post_type->add_type('Escritorios', 'Escritorio', 'escritorios', false, 'dashicons-building', array('title'), false);
        $this->admin->set_subpage_post_type('Textos','textos','escritorios');
        $this->admin->add_subpage_post_type();

        $this->admin->set_option(
            'Título','titulo_escritorios', 'text',null,'textos','',0,'escritorios'
        );
        $this->admin->set_option(
            'Descrição','descricao_escritorios', 'editor',null,'textos','',0,'escritorios'
        );
        $this->admin->set_option(
            'Banner','banner_escritorios', 'imagem',null,'textos','',250,'escritorios'
        );*/
        $this->metabox->save_options();

       /* $this->metabox->set_meta_box(
            'Dados do Escritório','dados_escritorio',array('escritorios')
        );
        $this->metabox->set_custom_field(
            'Endereço','endereco_escritorio','text',null,'dados_escritorio'
        );
        $this->metabox->set_custom_field(
            'CEP','cep_escritorio','text',null,'dados_escritorio'
        );
        $this->metabox->set_custom_field(
            'Bairro','bairro_escritorio','text',null,'dados_escritorio'
        );
        $listaEstados = $wpdb->get_results("select * from ".$wpdb->prefix."estado ");
        $arrayEstados = array();
        $arrayEstados[] = array('text' => 'Selecione','valor' => '');
        foreach($listaEstados as $estado){
            $arrayEstados[] = array('text' => $estado->nome,'valor' => $estado->id);
        }
        $this->metabox->set_custom_field(
            'Estado','estado_escritorio','select',$arrayEstados,'dados_escritorio'
        );
        $this->metabox->add_metas_box();

        $this->metabox->set_custom_field(
            'Cidade','cidade_escritorio','select',array(
            array('text' => 'Selecione','valor' => '')
        ),'dados_escritorio'
        );
        $this->metabox->set_custom_field(
            'Complemento','complemento_escritorio','text',null,'dados_escritorio'
        );
        $this->metabox->set_custom_field(
            'Nome do Escritório (Nome que aparece no mapa)','nome_escritorio','text',null,'dados_escritorio'
        );
        $this->metabox->set_custom_field(
            'Telefone 1','telefone1_escritorio','text',null,'dados_escritorio'
        );
        $this->metabox->set_custom_field(
            'Telefone 2','telefone2_escritorio','text',null,'dados_escritorio'
        );
        $this->metabox->set_custom_field(
            'Telefone 3','telefone3_escritorio','text',null,'dados_escritorio'
        );
        $this->metabox->add_metas_box();*/

        /* ------------- Escritorios ------------- */


        /* ------------- Escritorios ------------- */
        /*$this->post_type->add_type('Escritorios Parceiros', 'Escritorio Parceiro', 'escritorios_parc', false, 'dashicons-building', array('title','editor'),false,'',false, false, true, true, false);

        $this->admin->set_subpage_post_type('Textos','textos','escritorios_parc');
        $this->admin->add_subpage_post_type();

        $this->admin->set_option(
            'Título','titulo_escritorios_parceiro', 'text',null,'textos','',0,'escritorios_parc'
        );
        $this->admin->set_option(
            'Descrição','descricao_escritorios_parceiro', 'editor',null,'textos','',0,'escritorios_parc'
        );
        $this->admin->set_option(
            'Banner','banner_escritorios_parceiro', 'imagem',null,'textos','',250,'escritorios_parc'
        );
        $this->metabox->save_options();

        $this->metabox->set_meta_box(
            'Dados do Escritório','dados_escritorios_parceiros',array('escritorios_parc')
        );
        $this->metabox->set_custom_field(
            'Telefone 1','telefone1_escritorio','text',null,'dados_escritorios_parceiros'
        );
        $this->metabox->set_custom_field(
            'Telefone 2','telefone2_escritorio','text',null,'dados_escritorios_parceiros'
        );
        $this->metabox->set_custom_field(
            'Endereço','endereco_escritorio','text',null,'dados_escritorios_parceiros'
        );
        $this->metabox->set_custom_field(
            'E-mail','email_escritorio','text',null,'dados_escritorios_parceiros'
        );
        $this->metabox->set_custom_field(
            'CNPJ','cnpj_escritorio','text',null,'dados_escritorios_parceiros'
        );
        $this->metabox->set_custom_field(
            'Contratação','contratacao_escritorio','text',null,'dados_escritorios_parceiros'
        );
        $this->metabox->set_custom_field(
            'CEP','cep_escritorio','text',null,'dados_escritorios_parceiros'
        );
        $this->metabox->set_custom_field(
            'Bairro','bairro_escritorio','text',null,'dados_escritorios_parceiros'
        );
        $listaEstados = $wpdb->get_results("select * from ".$wpdb->prefix."estado ");
        $arrayEstados = array();
        $arrayEstados[] = array('text' => 'Selecione','valor' => '');
        foreach($listaEstados as $estado){
            $arrayEstados[] = array('text' => $estado->nome,'valor' => $estado->id);
        }
        $this->metabox->set_custom_field(
            'Estado','estado_escritorio','select',$arrayEstados,'dados_escritorios_parceiros'
        );

        $this->metabox->set_custom_field(
            'Cidade','cidade_escritorio','select',array(
            array('text' => 'Selecione','valor' => '')
        ),'dados_escritorios_parceiros'
        );
        $this->metabox->set_custom_field(
            'Texto do Link (site)','texto_link_escritorio','text',null,'dados_escritorios_parceiros'
        );
        $this->metabox->set_custom_field(
            'URL (site)','url_link_escritorio','text',null,'dados_escritorios_parceiros'
        );

        $this->metabox->set_custom_field(
            'Abrir site em nova aba?','target','radio',array(
            array('text' => 'Sim', 'valor' => 'sim'),
            array('text' => 'Não', 'valor' => 'nao'),
        ),'dados_escritorios_parceiros'
        );
        $this->metabox->add_metas_box();*/

        /* ------------- Escritorios ------------- */


        /* ------------- Perguntas Frequentes ------------- */
        /*$this->post_type->add_type('Perguntas Frequentes', 'Pergunta', 'faq', true, 'dashicons-editor-help', array('title', 'thumbnail', 'excerpt','editor'),true,'',false, false, true, true, false);
        $this->post_type->add_taxonomy('Categorias Faq', 'Categoria Faq', 'categoria_faq', 'categoria/faq', array('faq'));
        $this->category->set_custom_field(
            'Icone','icone_categoria_faq', 'imagem',null,'categoria_faq','','50'
        );
        $this->category->add_custom_fields('categoria_faq');
        $this->category->save_custom_fields('categoria_faq');

        $this->admin->set_subpage_post_type('Textos','textos','faq');
        $this->admin->add_subpage_post_type();

        $this->admin->set_option(
            'Título','titulo_faq', 'text',null,'textos','',0,'faq'
        );
        $this->admin->set_option(
            'Descrição','descricao_faq', 'editor',null,'textos','',0,'faq'
        );
        $this->admin->set_option(
            'Banner','banner_faq', 'imagem',null,'textos','',250,'faq'
        );

        $this->admin->set_option(
            'Título 2','titulo2_faq', 'text',null,'textos','',0,'faq'
        );
        $this->admin->set_option(
            'Descrição 2','descricao2_faq', 'editor',null,'textos','',0,'faq'
        );
        $this->metabox->save_options();*/

        /* ------------- Perguntas Frequentes ------------- */


        /* ------------- Compliance ------------- */

       /* $this->post_type->add_type('Regras e legislativos', 'Regras e legislativos', 'regulamentacao', true, 'dashicons-editor-help', array('title', 'thumbnail', 'excerpt','editor'), true,'',false, false, true, true, false);
        $this->post_type->add_taxonomy('Categorias Compliance', 'Categoria Compliance', 'categoria_compliance', 'categoria/regulamentacao', array('regulamentacao'));
        $this->category->set_custom_field(
            'Icone','icone_categoria_compliance', 'imagem',null,'categoria_compliance','','50'
        );
        $this->category->add_custom_fields('categoria_compliance');
        $this->category->save_custom_fields('categoria_compliance');

        $this->admin->set_subpage_post_type('Textos','textos','compliance');
        $this->admin->add_subpage_post_type();

        $this->admin->set_option(
            'Título','titulo_compliance', 'text',null,'textos','',0,'regulamentacao'
        );
        $this->admin->set_option(
            'Descrição','descricao_compliance', 'editor',null,'textos','',0,'regulamentacao'
        );
        $this->admin->set_option(
            'Banner','banner_compliance', 'imagem',null,'textos','',250,'regulamentacao'
        );*/

        /*
        $this->admin->set_option(
            'Título 2','titulo2_compliance', 'text',null,'textos','',0,'regulamentacao'
        );
        $this->admin->set_option(
            'Descrição 2','descricao2_compliance', 'editor',null,'textos','',0,'regulamentacao'
        );
        */
        /*
        $this->metabox->save_options();

        /* ------------- Compliance ------------- */



        /* ------------- Biblioteca ------------- */
        /*$this->post_type->add_type('Biblioteca', 'Biblioteca', 'biblioteca', true, 'dashicons-images-alt', array('title', 'thumbnail', 'excerpt','editor'), true);
        $this->post_type->add_taxonomy('Categorias Biblioteca', 'Categoria Biblioteca', 'categoria_biblioteca', 'categoria/biblioteca', array('biblioteca'));

        $this->admin->set_subpage_post_type('Textos','textos','biblioteca');
        $this->admin->add_subpage_post_type();

        $this->admin->set_option(
            'Título','titulo_biblioteca', 'text',null,'textos','',0,'biblioteca'
        );
        $this->admin->set_option(
            'Descrição','descricao_biblioteca', 'editor',null,'textos','',0,'biblioteca'
        );
        $this->admin->set_option(
            'Banner','banner_biblioteca', 'imagem',null,'textos','',250,'biblioteca'
        );
        $this->metabox->save_options();

        $this->metabox->set_meta_box(
            'Dados do arquivo','dados_arquivo',array('biblioteca')
        );

        $this->metabox->set_custom_field(
            'Tipo','tipo','radio',array(
            array('text' => 'Arquivo', 'valor' => 'arquivo'),
            array('text' => 'Vídeo', 'valor' => 'video'),
            array('text' => 'Link', 'valor' => 'link')
        ),'dados_arquivo'
        );

        $this->metabox->set_custom_field(
            'Arquivo Restrito','restrito','radio',array(
            array('text' => 'Sim', 'valor' => 'sim'),
            array('text' => 'Não', 'valor' => 'nao')
        ),'dados_arquivo'
        );
        $this->metabox->set_custom_field(
            'Arquivo','arquivo_download','arquivo',null,'dados_arquivo'
        );
        $this->metabox->set_custom_field(
            'Link do vídeo','link_video','text',null,'dados_arquivo'
        );
        $this->metabox->set_custom_field(
            'Link do tutorial','link_tutorial','text',null,'dados_arquivo'
        );

        $this->metabox->set_custom_field(
            'Texto do link','texto_link','radio',array(
            array('text' => 'Fazer Download', 'valor' => 'Fazer Download'),
            array('text' => 'Ver Detalhes', 'valor' => 'Ver Detalhes'),
            array('text' => 'Leia Mais', 'valor' => 'Leia Mais'),
            array('text' => 'Ver tutorial', 'valor' => 'Ver tutorial')

        ),'dados_arquivo'
        );

        $this->metabox->add_metas_box();*/

        /* ------------- Biblioteca ------------- */


        /* ------------- Ofertas Públicas ------------- */

        /*$this->post_type->add_type('Ofertas Públicas', 'Oferta Pública', 'ofertas-publicas', true, 'dashicons-chart-bar', array('title', 'thumbnail', 'excerpt','editor'), true,'',false, false, true, true, false);
        $this->post_type->add_taxonomy('Categorias Ofertas Públicas', 'Categoria Oferta Pública', 'categoria_ofertas_publicas', 'categoria/ofertas-publicas', array('ofertas-publicas'));


        $this->admin->set_subpage_post_type('Textos','textos','ofertas-publicas');
        $this->admin->add_subpage_post_type();

        $this->admin->set_option(
            'Título','titulo_ofertas_publicas', 'text',null,'textos','',0,'ofertas-publicas'
        );
        $this->admin->set_option(
            'Descrição','descricao_ofertas_publicas', 'editor',null,'textos','',0,'ofertas-publicas'
        );
        $this->admin->set_option(
            'Banner','banner_ofertas_publicas', 'imagem',null,'textos','',250,'ofertas-publicas'
        );

        $this->metabox->save_options();

        $this->metabox->set_meta_box(
            'Dados da Oferta Pública','dados_ofertas_publicas',array('ofertas-publicas')
        );
        $this->metabox->set_custom_field(
            'Status','status_oferta','radio',array(
            array('text' => 'Em andamento', 'valor' => 'em_andamento'),
            array('text' => 'Encerrada', 'valor' => 'encerrada')
        ),'dados_ofertas_publicas'
        );
        $this->metabox->add_metas_box();*/

        /* ------------- Ofertas Públicas ------------- */


        /* ------------- Plataformas ------------- */

        /*$this->post_type->add_type('Plataformas', 'Plataforma', 'plataformas', true, 'dashicons-screenoptions', array('title', 'thumbnail', 'excerpt','editor'), false,'plataformas/detalhe');
        $this->metabox->set_meta_box(
            'Dados da Plataforma','dados_plataforma',array('plataformas')
        );
        $this->metabox->set_custom_field(
            'Subtitulo','subtitulo','text',null,'dados_plataforma'
        );
        $this->metabox->set_custom_field(
            'Link Tutorial','link_tutorial','text',null,'dados_plataforma'
        );
        $this->metabox->set_custom_field(
            'AppStore','link_app_store','text',null,'dados_plataforma'
        );
        $this->metabox->set_custom_field(
            'GooglePlay','link_google_play','text',null,'dados_plataforma'
        );
        $this->metabox->add_metas_box();*/

        /* ------------- Plataformas ------------- */


        /* ------------- Relatórios ------------- */

        /*$this->post_type->add_type('Relatorios', 'Relatorio', 'relatorios', false, 'dashicons-editor-justify', array('title', 'thumbnail', 'excerpt','editor'), false,'',false, false, true, true, false);
        $this->admin->set_subpage_post_type('Imagem e titulo home','imagem-home','relatorios');
        $this->admin->set_option('Imagem','imagem_home_relatorios', 'imagem',null,'imagem-home','',150,'relatorios');
        $this->admin->set_option('Título','titulo_home_relatorios', 'text',null,'imagem-home','',150,'relatorios');
        $this->metabox->save_options();
        $this->metabox->set_meta_box(
            'Dados do Relatório','dados_relatorios',array('relatorios')
        );
        $this->metabox->set_custom_field(
            'Link','link','text',null,'dados_relatorios'
        );
        $this->metabox->add_metas_box();*/

        /* ------------- Relatórios ------------- */


        /* ------------- Nosso time ------------- */

        /*$this->post_type->add_type('Nosso time', 'Nosso time', 'nosso-time', false, 'dashicons-groups', array('title', 'thumbnail', 'excerpt','editor'), false);
        $this->admin->set_subpage_post_type('Textos','textos','nosso-time');
        $this->admin->add_subpage_post_type();

        $this->metabox->set_meta_box(
            'Dados do Nosso Time','dados_nosso_time',array('nosso-time')
        );
        $this->metabox->set_custom_field(
            'Ícone da Home','icone_home','imagem',null,'dados_nosso_time'
        );
        $this->metabox->set_custom_field(
            'Link Alternativo','link_alternativo','text',null,'dados_nosso_time'
        );
        $this->metabox->set_custom_field(
            'Habilitar botão Invista Já','bt_invista_ja','radio',array(
            array('text' => 'Sim', 'valor' => 'sim'),
            array('text' => 'Não', 'valor' => 'nao')
        ),'dados_nosso_time'
        );
        $this->metabox->add_metas_box();

        $this->admin->set_option(
            'Título','titulo_nosso_time', 'text',null,'textos','',0,'nosso-time'
        );
        $this->admin->set_option(
            'Descrição','descricao_nosso_time', 'editor',null,'textos','',0,'nosso-time'
        );
        $this->metabox->save_options();*/

        /* ------------- Nosso time ------------- */


        /* ------------- Invetimentos ------------- */
        /*
        $this->post_type->add_type('Investimentos', 'Investimento', 'investimento', false, 'dashicons-chart-area', array('title', 'thumbnail', 'excerpt','editor'), false);
        $this->post_type->add_taxonomy('Categoria Investimentos', 'Categoria Investimentos', 'tipo-investimentos', 'investimentos', array('investimento','inv_dif','inv_princ','inv_dest','inv_lat','inv_post_dest','inv_titulo','inv_banners','parceiros'));
        $this->admin->set_subpage_post_type('Textos','textos','investimento');
        $this->admin->add_subpage_post_type();

        $this->admin->set_option(
            'Título','titulo_investimentos', 'text',null,'textos','',0,'investimento'
        );
        $this->admin->set_option(
            'Descrição','descricao_investimentos', 'editor',null,'textos','',0,'investimento'
        );

        $this->admin->set_option('Cor do bloco "Invista com a Guide" na home','cor_bloco_invista_home', 'cor',null,'textos','',0,'investimento');
        $this->admin->set_option('Título bloco "Invista com a Guide" na home','titulo_invista_home', 'text',null,'textos','',0,'investimento');
        $this->admin->set_option('Descrição bloco "Invista com a Guide" na home','descricao_invista_home', 'text',null,'textos','',0,'investimento');
        $this->admin->set_option('Imagem bloco "Invista com a Guide" na home','imagem_invista_home', 'imagem',null,'textos','',150,'investimento');

        $this->admin->set_option('Banner Investimentos','banner_investimentos', 'imagem',null,'textos','',150,'investimento');
        $this->admin->set_option('Título Banner Investimentos','titulo2_investimentos', 'text',null,'textos','',0,'investimento');
        $this->admin->set_option('Descrição Banner Investimentos','descricao2_investimentos', 'editor',null,'textos','',0,'investimento');

        $this->metabox->set_meta_box('Galeria de imagens','galeria_imagens_investimentos',array('investimento'));
        $this->metabox->set_custom_field('Arquivos','imagens_galeria', 'galeria',null,'galeria_imagens_investimentos');

        $this->metabox->set_meta_box('Opções do produto','dados_produto',array('investimento'));
        $this->metabox->set_custom_field(
            'Habilitar botão saiba mais','bt_saiba_mais','radio',array(
            array('text' => 'Sim', 'valor' => 'sim'),
            array('text' => 'Não', 'valor' => 'nao')
        ),'dados_produto'
        );
        $this->metabox->set_custom_field(
            'Habilitar botão Invista Já','bt_invista_ja','radio',array(
            array('text' => 'Sim', 'valor' => 'sim'),
            array('text' => 'Não', 'valor' => 'nao')
        ),'dados_produto'
        );

        $this->metabox->add_metas_box();
        $this->metabox->save_options();*/

        /* ------------- Invetimentos ------------- */

        /* ------------- Invetimentos Diferenciais ------------- */

       /* $this->post_type->add_type('Investimentos Diferenciais', 'Investimentos Diferenciais', 'inv_dif', false, 'dashicons-yes', array('title', 'editor', 'thumbnail'), false,'',false, false, true, true, false);
        $this->metabox->save_options();*/

        /* ------------- Invetimentos Diferenciais ------------- */


        /* ------------- Invetimentos Principios ------------- */

        /*$this->post_type->add_type('Invetimentos Principios', 'Invetimentos Principio', 'inv_princ', false, 'dashicons-clipboard', array('title', 'thumbnail', 'excerpt','editor'), false,'',false, false, true, true, false);
        $this->admin->set_subpage_post_type('Textos','textos','inv_princ');
        $this->admin->add_subpage_post_type();

        $this->metabox->set_meta_box(
            'Dados do Investimentos Principio','dados_inv_princ',array('inv_princ')
        );
        $this->metabox->set_custom_field(
            'Ícone','icone_home','imagem',null,'dados_inv_princ'
        );
        $this->metabox->add_metas_box();

        $this->admin->set_option(
            'Título','titulo_inv_princ', 'text',null,'textos','',0,'inv_princ'
        );
        $this->admin->set_option(
            'Descrição','descricao_inv_princ', 'editor',null,'textos','',0,'inv_princ'
        );
        $this->metabox->save_options();*/

        /* ------------- Invetimentos Principios ------------- */


        /*------------ Investimentos Destaques ------------- */
        /*
        $this->post_type->add_type('Investimentos Destaques', 'Investimentos Destaque', 'inv_dest', false, 'dashicons-editor-justify', array('title', 'editor'), false,'',false, false, true, true, false);
        $this->metabox->save_options();

        /* ------------- Investimentos Destaques ------------- */


        /* ------------- Invetimentos Lateral ------------- */

       /* $this->post_type->add_type('Invetimentos Lateral', 'Invetimentos Lateral', 'inv_lat', false, 'dashicons-align-right', array('title', 'thumbnail', 'excerpt','editor'), false,'',false, false, true, true, false);
        $this->admin->set_subpage_post_type('Textos','textos','inv_lat');
        $this->admin->add_subpage_post_type();

        $this->metabox->set_meta_box(
            'Investimentos Conteudo Lateral','dados_inv_lat',array('inv_lat')
        );
        $this->metabox->set_custom_field(
            'Ícone','icone_home','imagem',null,'dados_inv_lat'
        );
        $this->metabox->add_metas_box();

        $this->admin->set_option(
            'Título','titulo_inv_lat', 'text',null,'textos','',0,'inv_lat'
        );
        $this->metabox->save_options();*/

        /* ------------- Invetimentos Lateral ------------- */

        /* ------------- Investimentos Posts de Destaque ------------- */

       /* $this->post_type->add_type('Investimentos Posts de Destaque', 'Investimentos Post de destaque', 'inv_post_dest', false, 'dashicons-align-left', array('title', 'editor', 'excerpt', 'thumbnail'), false,'',false, false, true, true, false);
        $this->metabox->save_options();*/

        /* ------------- Investimentos Posts de Destaque ------------- */

        /* ------------- Investimentos Títulos ------------- */

       /* $this->post_type->add_type('Investimentos Títulos', 'Investimentos Título', 'inv_titulo', false, 'dashicons-format-quote', array('title', 'editor'), false,'',false, false, true, true, false);
        $this->post_type->add_taxonomy('Áreas dos Títulos', 'Área do Título', 'area-titulo', 'area-titulos', array('inv_titulo'));
        $this->metabox->save_options();*/

        /* ------------- Investimentos Títulos ------------- */

        /* ------------- Investimentos Banners ------------- */

       /* $this->post_type->add_type('Investimentos Banners', 'Investimentos Banners', 'inv_banners', false, 'dashicons-images-alt', array('title', 'excerpt', 'thumbnail'), false,'',false, false, true, true, false);
        $this->metabox->set_meta_box(
            'Dados do Parceiro','dados_inv_banners',array('inv_banners')
        );
        $this->metabox->set_custom_field(
            'Nome Botão 1','nome_botao1','text',null,'dados_inv_banners'
        );
        $this->metabox->set_custom_field(
            'Link Botão 1','link_botao1','text',null,'dados_inv_banners'
        );
        $this->metabox->set_custom_field(
            'Nome Botão 2','nome_botao2','text',null,'dados_inv_banners'
        );
        $this->metabox->set_custom_field(
            'Link Botão 2','link_botao2','text',null,'dados_inv_banners'
        );
        $this->metabox->add_metas_box();*/

        /* ------------- Investimentos Banners ------------- */

        /* ------------- Linha do Tempo ------------- */

        /*$this->post_type->add_type('Linha do Tempo', 'Linha do Tempo', 'timeline', false, 'dashicons-clock', array('title', 'excerpt','editor'), false,'',false, false, true, true, false);
        $this->admin->set_subpage_post_type('Textos','textos','timeline');
        $this->admin->add_subpage_post_type();

        $this->admin->set_option(
            'Título','titulo_timeline', 'text',null,'textos','',0,'timeline'
        );
        $this->admin->set_option(
            'Descrição','descricao_timeline', 'editor',null,'textos','',0,'timeline'
        );
        $this->metabox->save_options();*/

        /* ------------- Linha do Tempo ------------- */


        /* ------------- Parceiros ------------- */

        /*$this->post_type->add_type('Parceiros', 'Parceiro', 'parceiros', false, 'dashicons-universal-access', array('title', 'thumbnail'), false,'',false, false, true, true, false);
        $this->admin->set_subpage_post_type('Textos','textos','parceiros');
        $this->admin->add_subpage_post_type();

        $this->admin->set_option(
            'Título','titulo_parceiros', 'text',null,'textos','',0,'parceiros'
        );
        $this->admin->set_option(
            'Descrição','descricao_parceiros', 'editor',null,'textos','',0,'parceiros'
        );

        $this->metabox->set_meta_box(
            'Dados do Parceiro','dados_parceiro',array('parceiros')
        );
        $this->metabox->set_custom_field(
            'Link','link_parceiro','text',null,'dados_parceiro'
        );
        $this->metabox->add_metas_box();*/

        /* ------------- Parceiros ------------- */



        /* ------------- Linha do Tempo ------------- */

        /*$this->post_type->add_type('Sala de Imprensa', 'Sala de Imprensa', 'imprensa', false, 'dashicons-book', array('title', 'excerpt','editor'), false,'',false, false, true, true, false);
        $this->admin->set_subpage_post_type('Textos Rodapé','textos','imprensa');
        $this->admin->add_subpage_post_type();

        $this->admin->set_option(
            'Título','titulo_imprensa_rodape', 'text',null,'textos','',0,'imprensa'
        );
        $this->admin->set_option(
            'Subtitulo','descricao_imprensa_rodape', 'text',null,'textos','',0,'imprensa'
        );
        $this->admin->set_option(
            'E-mail','email_imprensa_rodape', 'text',null,'textos','',0,'imprensa'
        );
        $this->admin->set_option(
            'Telefone 1','tel1_imprensa_rodape', 'text',null,'textos','',0,'imprensa'
        );
        $this->admin->set_option(
            'Telefone 2','tel2_imprensa_rodape', 'text',null,'textos','',0,'imprensa'
        );
        $this->metabox->save_options();*/

        /* ------------- Linha do Tempo ------------- */


        /* ------------- Contatos ------------- */

        /*$this->post_type->add_type('Contatos', 'Contato', 'contatos', false, 'dashicons-email', array('title'), false,'',false, false, true, true, false);

        $this->metabox->set_meta_box(
            'Dados do Contato','dados_contatos',array('contatos')
        );

        $this->metabox->set_custom_field(
            'Regiões Metropolitanas','contatos_telefone_metropolitanas','text',null,'dados_contatos'
        );
        $this->metabox->set_custom_field(
            'Demais localidades','contatos_telefone_demais_localidades','text',null,'dados_contatos'
        );
        $this->metabox->set_custom_field(
            'Email','contatos_email','text',null,'dados_contatos'
        );
        $this->metabox->add_metas_box();*/

        /* ------------- Contatos ------------- */

        /* ------------- Tabela de Preços ------------- */
        /*
        $this->post_type->add_type('Tabela de Preços', 'Tabela de Preços', 'tabela_de_precos', false, 'dashicons-editor-table', array('title', 'editor'), false,'',false, false, true, true, false);
        $this->metabox->save_options();*/

        /* ------------- Tabela de Preços ------------- */


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


        /* ------------- Menus do site ------------- */
       /* $this->menus->set_nav('Menu Cabeçalho','menu-header');
        $this->menus->set_nav('Menu Sobre (rodpé)','menu-sobre');
        $this->menus->set_nav('Menu Investimentos (rodpé)','menu-investimentos');
        $this->menus->set_nav('Menu Guide Educa (rodpé)','menu-acessor');
        $this->menus->set_nav('Menu Atendimento (rodpé)','menu-atendimento');
        $this->menus->set_nav('Menu Página Investimentos (página Investimentos)','menu-page-investimentos');
        $this->menus->add_nav();*/
        /* ------------- Menus do site ------------- */


        /* ------------- Configurações Rodapé ------------- */
        /*$this->admin->set_page('Config. Rodapé','configs-rodape','page.php', 'dashicons-admin-home', 999);
        $this->admin->set_option('Link Yotube','link_youtube', 'text',null,'configs-rodape');
        $this->admin->set_option('Link Facebook','link_facebook', 'text',null,'configs-rodape');
        $this->admin->set_option('Link LinkedIn','link_linkedin', 'text',null,'configs-rodape');
        $this->admin->set_option('Link Twitter','link_twitter', 'text',null,'configs-rodape');
        $this->admin->set_option('Link Google+','link_google', 'text',null,'configs-rodape');

        $this->admin->set_option('Descrição','descricao_rodape', 'editor',null,'configs-rodape');

        $this->admin->set_option('Selos','selos_rodape', 'galeria', null,'configs-rodape');

        $this->metabox->save_options();
        $this->admin->add_pages();/*
        /* ------------- Configurações Rodapé ------------- */


        /* Configurações de Formulários */
/*
        $this->admin->set_page('Formularios','formularios','page.php', 'dashicons-email-alt', 999,
            array(
                array('Fale Conosco','fale-conosco','subpage.php', '', 3),
                array('Ouvidoria','ouvidoria','subpage.php', '', 4),
                array('Newsletter','newsletter','subpage.php', '', 4),
                array('Assessores','assessor','subpage.php', '', 5)
            )
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


        // Página Fale Conosco
        $this->admin->set_option('E-mail receptor:','email_receptor_fale_conosco', 'text',null,'fale-conosco','',300);
        $this->admin->set_option('Assunto:','assunto_fale_conosco', 'text',null,'fale-conosco');
        $this->admin->set_option('Mensagem de envio:','msg_envio_fale_conosco', 'text',null,'fale-conosco');
        $this->admin->set_option('Mensagem de erro ao enviar:','msg_erro_fale_conosco', 'text',null,'fale-conosco');
        $this->admin->set_option('Mensagem de preenchimento de campos:','msg_preencimento_fale_conosco', 'text',null,'fale-conosco');

        $this->admin->set_list_table('Lista de contatos',"SELECT * FROM ".$wpdb->prefix."formularios where tipo_formulario = 'fale-conosco' ORDER BY id DESC", true,
            array('Nome' => 'nome', 'E-mail' => 'email', 'Assunto' => 'assunto', 'Como conheceu a Guide?' => 'como_conheceu', 'Telefone' => 'telefone', 'Mensagem' => 'mensagem')
            ,'fale-conosco');

        // Página Ouvidoria
        $this->admin->set_option('E-mail receptor:','email_receptor_ouvidoria', 'text',null,'ouvidoria','',300);
        $this->admin->set_option('Assunto:','assunto_ouvidoria', 'text',null,'ouvidoria');
        $this->admin->set_option('Mensagem de envio:','msg_envio_ouvidoria', 'text',null,'ouvidoria');
        $this->admin->set_option('Mensagem de erro ao enviar:','msg_erro_ouvidoria', 'text',null,'ouvidoria');
        $this->admin->set_option('Mensagem de preenchimento de campos:','msg_preencimento_ouvidoria', 'text',null,'ouvidoria');

        $this->admin->set_list_table('Lista de contatos',"SELECT * FROM ".$wpdb->prefix."formularios where tipo_formulario = 'ouvidoria' ORDER BY id DESC", true,
            array('Nome' => 'nome', 'E-mail' => 'email', 'Assunto' => 'assunto', 'Estado' => 'estado', 'Telefone' => 'telefone', 'Já é nosso cliente?' => 'ja_cliente', 'Mensagem' => 'mensagem')
            ,'ouvidoria');

        // Página Assessores
        $this->admin->set_option('E-mail receptor:','email_receptor_assessor', 'text',null,'assessor','',300);
        $this->admin->set_option('Assunto:','assunto_assessor', 'text',null,'assessor');
        $this->admin->set_option('Mensagem de envio:','msg_envio_assessor', 'text',null,'assessor');
        $this->admin->set_option('Mensagem de erro ao enviar:','msg_erro_assessor', 'text',null,'assessor');
        $this->admin->set_option('Mensagem de preenchimento de campos:','msg_preencimento_assessor', 'text',null,'assessor');

        $this->admin->set_list_table('Lista de contatos',"SELECT * FROM ".$wpdb->prefix."formularios where tipo_formulario = 'assessor' ORDER BY id DESC", true,
            array('Nome' => 'nome', 'E-mail' => 'email', 'Assunto' => 'assunto', 'Estado' => 'estado', 'Cidade' => 'cidade', 'Telefone' => 'telefone', 'ExperienciaMF' => 'experienciaMF', 'Vinculo_instituicao' => 'vinculo_instituicao', 'Qual_instituicao' => 'qual_vinculo', 'Indicacao' => 'indicacao', 'Quem_indicou' => 'quem_indicou', 'Outra_indicacao' => 'outra_indicacao', 'Interesse_atuacao' => 'interesse_atuacao', 'Agente_autonomo' => 'agenteAutonomo', 'Gestor_carteiras' => 'gestorCarteiras', 'CPA10' => 'cpa_10', 'CEA' => 'cea', 'CFP' => 'cfp', 'CFA' => 'cfa')
            ,'assessor');*/
        /* Configurações de Formulários */


        /* Campos página newsletter formulários */
        /*$this->admin->set_option('Mensagem de cadastro:','msg_cadastro_newsletter', 'text',null,'newsletter');
        $this->admin->set_option('Mensagem de erro ao cadastrar:','msg_erro_newsletter', 'text',null,'newsletter');
        $this->admin->set_option('Mensagem de preenchimento de campos:','msg_preencimento_newsletter', 'text',null,'newsletter');
        $this->admin->set_list_table('Lista de contatos cadastrados',"SELECT * FROM ".$wpdb->prefix."formularios where tipo_formulario = 'newsletter' ORDER BY id DESC", true,
            array('E-mail' => 'email')
            ,'newsletter');*/
        /* Campos página newsletter formulários */


        /* ------------- Págna Quem Somos ------------- */
/*
        $this->admin->set_page('Quem Somos Bloco 1','bloco1-quem-somos','page.php', 'dashicons-admin-page', 999,
            array(
                array('Quem Somos Bloco 2','bloco2-quem-somos','subpage.php', '', 4),
                array('Quem Somos Bloco 3','bloco3-quem-somos','subpage.php', '', 5),
                array('Quem Somos Bloco 4','bloco4-quem-somos','subpage.php', '', 6),
                array('Quem Somos Bloco 5','bloco5-quem-somos','subpage.php', '', 6),
                array('Quem Somos Bloco 6','bloco6-quem-somos','subpage.php', '', 6)
            )
        );
        $this->admin->set_option('Exibir Bloco','exibir_bloco1_quem_somos', 'radio',array(
            array('text' => 'Sim','valor' => 'sim'),
            array('text' => 'Não','valor' => 'nao'),
        ),'bloco1-quem-somos','',300);
        $this->admin->set_option('Título','titulo_bloco1_quem_somos', 'text',null,'bloco1-quem-somos','',500);
        $this->admin->set_option('Descrição','descricao_bloco1_quem_somos', 'editor',null,'bloco1-quem-somos');


        $this->admin->set_option('Exibir Bloco','exibir_bloco2_quem_somos', 'radio',array(
            array('text' => 'Sim','valor' => 'sim'),
            array('text' => 'Não','valor' => 'nao'),
        ),'bloco2-quem-somos','',300);
        $this->admin->set_option('Título área 1','titulo_bloco2_quem_somos_area1', 'text',null,'bloco2-quem-somos','',500);
        $this->admin->set_option('Subtitulo área 1','subtitulo_bloco2_quem_somos_area1', 'text',null,'bloco2-quem-somos','',500);
        $this->admin->set_option('Imagem área 1','imagem_bloco2_quem_somos_area1', 'imagem',null,'bloco2-quem-somos','Tamanho da imagem 625x250px',150);
        $this->admin->set_option('Descrição área 1','descricao_bloco2_quem_somos_area1', 'editor',null,'bloco2-quem-somos');

        $this->admin->set_option('Título coluna direita','titulo_quem_somos_col_dir_bloco2', 'text',null,'bloco2-quem-somos','',500);

        $this->admin->set_option('Título área 2','titulo_bloco2_quem_somos_area2', 'text',null,'bloco2-quem-somos','',500);
        $this->admin->set_option('Imagem área 2','imagem_bloco2_quem_somos_area2', 'imagem',null,'bloco2-quem-somos','Tamanho da imagem 60x60px',60);
        $this->admin->set_option('Descrição área 2','descricao_bloco2_quem_somos_area2', 'editor',null,'bloco2-quem-somos');

        $this->admin->set_option('Título área 3','titulo_bloco2_quem_somos_area3', 'text',null,'bloco2-quem-somos','',500);
        $this->admin->set_option('Imagem área 3','imagem_bloco2_quem_somos_area3', 'imagem',null,'bloco2-quem-somos','Tamanho da imagem 60x60px',60);
        $this->admin->set_option('Descrição área 3','descricao_bloco2_quem_somos_area3', 'editor',null,'bloco2-quem-somos');

        $this->admin->set_option('Título área 4','titulo_bloco2_quem_somos_area4', 'text',null,'bloco2-quem-somos','',500);
        $this->admin->set_option('Imagem área 4','imagem_bloco2_quem_somos_area4', 'imagem',null,'bloco2-quem-somos','Tamanho da imagem 60x60px',60);
        $this->admin->set_option('Descrição área 4','descricao_bloco2_quem_somos_area4', 'editor',null,'bloco2-quem-somos');

        $this->admin->set_option('Exibir Bloco','exibir_bloco3_quem_somos', 'radio',array(
            array('text' => 'Sim','valor' => 'sim'),
            array('text' => 'Não','valor' => 'nao'),
        ),'bloco3-quem-somos','',300);
        $this->admin->set_option('Título','titulo_bloco3_quem_somos', 'text',null,'bloco3-quem-somos','',500);
        $this->admin->set_option('Descrição','descricao_bloco3_quem_somos', 'editor',null,'bloco3-quem-somos');

        $this->admin->set_option('Exibir Bloco','exibir_bloco4_quem_somos', 'radio',array(
            array('text' => 'Sim','valor' => 'sim'),
            array('text' => 'Não','valor' => 'nao'),
        ),'bloco4-quem-somos','',300);

        $this->admin->set_option('Título área 1','titulo_bloco4_quem_somos_area1', 'text',null,'bloco4-quem-somos','',500);
        $this->admin->set_option('Descrição área 1','descricao_bloco4_quem_somos_area1', 'editor',null,'bloco4-quem-somos');

        $this->admin->set_option('Título área 2','titulo_bloco4_quem_somos_area2', 'text',null,'bloco4-quem-somos','',500);
        $this->admin->set_option('Descrição área 2','descricao_bloco4_quem_somos_area2', 'editor',null,'bloco4-quem-somos');

        $this->admin->set_option('Título área 3','titulo_bloco4_quem_somos_area3', 'text',null,'bloco4-quem-somos','',500);
        $this->admin->set_option('Descrição área 3','descricao_bloco4_quem_somos_area3', 'editor',null,'bloco4-quem-somos');



        $this->admin->set_option('Exibir Bloco','exibir_bloco5_quem_somos', 'radio',array(
            array('text' => 'Sim','valor' => 'sim'),
            array('text' => 'Não','valor' => 'nao'),
        ),'bloco5-quem-somos','',300);
        $this->admin->set_option('Título área 1','titulo_bloco5_quem_somos_area1', 'text',null,'bloco5-quem-somos','',500);
        $this->admin->set_option('Subtitulo área 1','subtitulo_bloco5_quem_somos_area1', 'text',null,'bloco5-quem-somos','',500);
        $this->admin->set_option('Imagem área 1','imagem_bloco5_quem_somos_area1', 'imagem',null,'bloco5-quem-somos','Tamanho da imagem 625x250px',150);
        $this->admin->set_option('Descrição área 1','descricao_bloco5_quem_somos_area1', 'editor',null,'bloco5-quem-somos');

        $this->admin->set_option('Título coluna direita','titulo_quem_somos_col_dir_bloco5', 'text',null,'bloco5-quem-somos','',500);

        $this->admin->set_option('Título área 2','titulo_bloco5_quem_somos_area2', 'text',null,'bloco5-quem-somos','',500);
        $this->admin->set_option('Imagem área 2','imagem_bloco5_quem_somos_area2', 'imagem',null,'bloco5-quem-somos','Tamanho da imagem 60x60px',60);
        $this->admin->set_option('Descrição área 2','descricao_bloco5_quem_somos_area2', 'editor',null,'bloco5-quem-somos');

        $this->admin->set_option('Título área 3','titulo_bloco5_quem_somos_area3', 'text',null,'bloco5-quem-somos','',500);
        $this->admin->set_option('Imagem área 3','imagem_bloco5_quem_somos_area3', 'imagem',null,'bloco5-quem-somos','Tamanho da imagem 60x60px',60);
        $this->admin->set_option('Descrição área 3','descricao_bloco5_quem_somos_area3', 'editor',null,'bloco5-quem-somos');

        $this->admin->set_option('Título área 4','titulo_bloco5_quem_somos_area4', 'text',null,'bloco5-quem-somos','',500);
        $this->admin->set_option('Imagem área 4','imagem_bloco5_quem_somos_area4', 'imagem',null,'bloco5-quem-somos','Tamanho da imagem 60x60px',60);
        $this->admin->set_option('Descrição área 4','descricao_bloco5_quem_somos_area4', 'editor',null,'bloco5-quem-somos');


        $this->admin->set_option('Exibir Bloco','exibir_bloco6_quem_somos', 'radio',array(
            array('text' => 'Sim','valor' => 'sim'),
            array('text' => 'Não','valor' => 'nao'),
        ),'bloco6-quem-somos','',300);

        $this->admin->set_option('Imagem área 1','imagem_bloco6_quem_somos_area1', 'imagem',null,'bloco6-quem-somos','Tamanho da imagem 630x300px',150);
        $this->admin->set_option('Título área 1','titulo_bloco6_quem_somos_area1', 'text',null,'bloco6-quem-somos','',500);
        $this->admin->set_option('Descrição área 1','descricao_bloco6_quem_somos_area1', 'editor',null,'bloco6-quem-somos');


        $this->admin->set_option('Imagem área 2','imagem_bloco6_quem_somos_area2', 'imagem',null,'bloco6-quem-somos','Tamanho da imagem 630x300px',150);
        $this->admin->set_option('Título área 2','titulo_bloco6_quem_somos_area2', 'text',null,'bloco6-quem-somos','',500);
        $this->admin->set_option('Descrição área 2','descricao_bloco6_quem_somos_area2', 'editor',null,'bloco6-quem-somos');
        */

        /* ------------- Págna Quem Somos ------------- */


        /* ------------- Págna Extras Home ------------- */

        /*$this->admin->set_page('Extras Home','blocoHome','page.php', 'dashicons-admin-page', 999,
            array(
                array('Card 1','areaHome1','subpage.php', '', 3),
                array('Card 2','areaHome2','subpage.php', '', 4)
            )
        );
        $this->admin->set_option('Imagem','imagem_home_area1', 'imagem',null,'areaHome1','',400,'blocoHome');
        $this->admin->set_option('Título','titulo_home_area1', 'text',null,'areaHome1','',400,'blocoHome');
        $this->admin->set_option('Subtulo','subtitulo_home_area1', 'text',null,'areaHome1','',400,'blocoHome');
        $this->admin->set_option('Resenha','resenha_home_area1', 'textarea',null,'areaHome1','',400,'blocoHome');
        $this->admin->set_option('Texto link','texto_link_home_area1', 'text',null,'areaHome1','',400,'blocoHome');
        $this->admin->set_option('Link','link_home_area1', 'text',null,'areaHome1','',400,'blocoHome');

        $this->admin->set_option('Imagem','imagem_home_area2', 'imagem',null,'areaHome2','',400,'blocoHome');
        $this->admin->set_option('Título','titulo_home_area2', 'text',null,'areaHome2','',400,'blocoHome');
        $this->admin->set_option('Subtulo','subtitulo_home_area2', 'text',null,'areaHome2','',400,'blocoHome');
        $this->admin->set_option('Resenha','resenha_home_area2', 'textarea',null,'areaHome2','',400,'blocoHome');
        $this->admin->set_option('Texto link','texto_link_home_area2', 'text',null,'areaHome2','',400,'blocoHome');
        $this->admin->set_option('Link','link_home_area2', 'text',null,'areaHome2','',400,'blocoHome');*/

        /* ------------- Págna Extras Home ------------- */

        /* ------------- Fale Conosco Assuntos ------------- */
       /* $this->post_type->add_type('Fale Conosco - Assuntos', 'Fale Conosco - Assunto', 'fale_conosco_assunto', false, 'dashicons-email', array('title'), false);

        $this->metabox->set_meta_box(
            'Dados do Assunto','dados_fale_conosco_assunto',array('fale_conosco_assunto')
        );
        $this->metabox->set_custom_field(
            'Email para envio do assunto','email_dest','text',null,'dados_fale_conosco_assunto'
        );
        $this->metabox->add_metas_box();
        $this->metabox->save_options();*/
        /* ------------- Fale Conosco Assuntos ------------- */

        /* ------------- Fale Conosco Como Conheceu ------------- */
       /* $this->post_type->add_type('Fale Conosco - Como Conheceu', 'Fale Conosco - Como Conheceu', 'fale_conosco_cc', false, 'dashicons-email', array('title'), false);

        $this->metabox->save_options();*/
        /* ------------- Fale Conosco Como Conheceu ------------- */

        /* ------------- Ouvidoria Assuntos ------------- */
        /*$this->post_type->add_type('Ouvidoria - Assuntos', 'Ouvidoria - Assunto', 'ouvidoria_assunto', false, 'dashicons-email', array('title'), false);

        $this->metabox->save_options();*/
        /* ------------- Ouvidoria Assuntos ------------- */





       /* $this->admin->set_page('Ouvidoria','ouvidoria-page','page.php', 'dashicons-email-alt', 999);
        $this->admin->set_option('Link Procedimentos Atendimento:','link_procedimentos', 'text',null,'ouvidoria-page');
        $this->admin->set_option('Telefone:','telefone_ouvidoria', 'text',null,'ouvidoria-page');
        $this->admin->set_option('Horário Atedimento:','horario_ouvidoria', 'text',null,'ouvidoria-page');
        $this->admin->set_option('E-mails:','email_ouvidoria', 'text',null,'ouvidoria-page');
        $this->admin->set_option('Endereço:','endereco_ouvidoria', 'text',null,'ouvidoria-page');
        $this->admin->set_option('CEP:','cep_ouvidoria', 'text',null,'ouvidoria-page');
        $this->admin->set_option('Bairro:','bairro_ouvidoria', 'text',null,'ouvidoria-page');
        $this->admin->set_option('Cidade:','cidade_ouvidoria', 'text',null,'ouvidoria-page');
        $this->admin->set_option('Estado:','estado_ouvidoria', 'text',null,'ouvidoria-page');*/



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

        $this->metabox->set_meta_box(
            'Galeria','galeria_modalidades',array('aula')
        );

        $this->metabox->set_custom_field(
            'Galeria','galeria_modalidades_','galeria',null,'galeria_modalidades'
        );


        /*$this->metabox->set_meta_box(
            'Banner Rodapé da página','banner_bottom',array('page')
        );
        $this->metabox->set_custom_field(
            'Título','titulo_banner_rodape', 'text',null,'banner_bottom'
        );
        $this->metabox->set_custom_field(
            'Descrição','descricao_banner_rodape', 'editor',null,'banner_bottom'
        );
        $this->metabox->set_custom_field(
            'Imagem','imagem_banner_rodape', 'imagem',null,'banner_bottom'
        );
        $this->metabox->set_custom_field(
            'Texto do Botão','link_text_banner_rodape', 'text',null,'banner_bottom'
        );
        $this->metabox->set_custom_field(
            'Link do Botão','link_banner_rodape', 'text',null,'banner_bottom'
        );*/
        /*$this->metabox->set_meta_box('Opções do Template Detalhe','botao_page_detalhe',array('page'));*/
        /*$this->metabox->set_custom_field(
            'Habilitar botão Invista Já','bt_invista_ja_page','radio',array(
            array('text' => 'Sim', 'valor' => 'sim'),
            array('text' => 'Não', 'valor' => 'nao')
        ),'botao_page_detalhe'
        );*/

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

        $this->metabox->add_metas_box();
    }
}
$Tema = new Tema();


?>