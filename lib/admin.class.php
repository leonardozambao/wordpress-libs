<?php
class Admin{
	private $list_pages;
	private $list_subpage_post_type;
	private $list_options;
	private $tabela_listagem;
	
	
	public function __construct(){
		add_action('admin_head', array($this, 'admin_head'));
		add_action('admin_enqueue_scripts', array($this, 'script_galeria'));
		$this->list_pages = array();
		$this->list_subpage_post_type = array();
		$this->list_options = array();
		$this->tabela_listagem = array();
	}
	
	public function admin_head() {
		echo '<link rel="stylesheet" type="text/css" href="' . get_template_directory_uri() . '/lib/css/wp-admin.css' . '">';
	}
	
	/* Estrutura para criação de páginas no admin */
	public function add_pages(){
		add_action('admin_menu', array($this, 'load_pages'));
	}
	
	public function script_galeria() {
		if (isset($_GET['page'])) {
			foreach($this->list_pages as $page){
				if($page['slug'] == $_GET['page']){
					wp_enqueue_media();
				}else
				if($page['sub_pagina'] != null){
					foreach($page['sub_pagina'] as $sub_pagina){
						if($sub_pagina['slug'] == $_GET['page']){
							wp_enqueue_media();
						}
					}
				}
			}
			foreach($this->list_subpage_post_type as $pagina){
				if($pagina['slug'].'-'.$pagina['parent'] == $_GET['page']){
					wp_enqueue_media();
				}
			}
		}
	}
	
	public function load_pages(){
		foreach($this->list_pages as $pagina){
			add_menu_page($pagina['nome'], $pagina['nome'], 'administrator', $pagina['slug'], array($this,'show_pages'),$pagina['icone'],$pagina['posicao']);
			if($pagina['sub_pagina']){
				foreach($pagina['sub_pagina'] as $sub_pagina){
					add_submenu_page($pagina['slug'], $sub_pagina['nome'], $sub_pagina['nome'], 'administrator', $sub_pagina['slug'], array($this,'show_pages'));
				}
			}
		}
	}
	
	public function show_pages() {
		foreach($this->list_pages as $page){
			
			if($page['sub_pagina'] != null){
				if($page['slug'] == $_GET['page']){
					require_once(get_template_directory() . '/lib/admin/'.$page['pagina']);
				}
				foreach($page['sub_pagina'] as $sub_pagina){
					if($sub_pagina['slug'] == $_GET['page']){
						require_once(get_template_directory() . '/lib/admin/'.$sub_pagina['pagina']);
					}
				}
			}else{
				if($page['slug'] == $_GET['page']){
					require_once(get_template_directory() . '/lib/admin/'.$page['pagina']);
				}
			}
		}
	}
	
	public function list_pages(){
		return $this->list_pages;
	}
	
	public function set_page($nome, $slug, $pagina, $icone, $posicao,$sub_page = null){
		$new_sub_page = array();
		if($sub_page){
			for($i = 0; $i < count($sub_page); $i++){
				$new_sub_page[$i] = array('nome' => $sub_page[$i][0], 'slug' => $sub_page[$i][1], 'pagina' => $sub_page[$i][2], 'icone' => $sub_page[$i][3], 'posicao' => $sub_page[$i][4]);
			}
		}
		$this->list_pages[] = array('nome' => $nome, 'slug' => $slug, 'pagina' => $pagina, 'icone' => $icone, 'posicao' => $posicao, 'sub_pagina' => $new_sub_page);
	}
	
	public function add_subpage_post_type(){
		add_action('admin_menu', array($this, 'load_subpage_post_type'));
	}
	
	public function load_subpage_post_type(){
		foreach($this->list_subpage_post_type as $pagina){
			add_submenu_page('edit.php?post_type='.$pagina['parent'], $pagina['nome'], $pagina['nome'], 'administrator', $pagina['slug'].'-'.$pagina['parent'], array($this, 'show_subpage_post_type') );
		}
	}
	
	public function show_subpage_post_type() {
		require_once(get_template_directory() . '/lib/admin/subpage_post_type.php');
	}
	
	public function list_subpage_post_type(){
		return $this->list_subpage_post_type;
	}
	
	public function set_subpage_post_type($nome, $slug, $parent){
		$this->list_subpage_post_type[] = array('nome' => $nome, 'slug' => $slug, 'parent' => $parent);
	}
	
	/* Estrutura para criação de páginas no admin */
	
	
	/* Estrutura para criação de options nas páginas do admim */
	public function add_options(){
		if($this->list_options){
			foreach($this->list_options as $option){
				if($option['pagina'] == $_GET['page'] || $option['pagina'].'-'.$option['post_type'] == $_GET['page']){
					if($option['tipo'] == 'text'){
					?>
					<tr id="bloco_<?php echo $option['nome']; ?>" valign="top">
						<th scope="row"><label for="<?php echo $option['nome']; ?>"><?php echo $option['label']; ?></label></th>
						<td><input name="<?php echo $option['nome']; ?>" type="text" id="<?php echo $option['nome']; ?>" style="width:<?php echo($option['tamanho'] > 0)? $option['tamanho'].'px': '70%'; ?>;" value="<?php echo @get_option($option['nome']); ?>" class="regular-text" /><?php if($option['descricao'] != ''){ ?><p class="description"><?php echo $option['descricao'];?></p><?php } ?></td>
					</tr>
					<?php
					}
					
					if($option['tipo'] == 'password'){
					?>
					<tr id="bloco_<?php echo $option['nome']; ?>" valign="top">
						<th scope="row"><label for="<?php echo $option['nome']; ?>"><?php echo $option['label']; ?></label></th>
						<td><input name="<?php echo $option['nome']; ?>" type="password" id="<?php echo $option['nome']; ?>" style="width:<?php echo($option['tamanho'] > 0)? $option['tamanho'].'px': '70%'; ?>;" value="<?php echo @get_option($option['nome']); ?>" class="regular-text" /><?php if($option['descricao'] != ''){ ?><p class="description"><?php echo $option['descricao'];?></p><?php } ?></td>
					</tr>
					<?php
					}
					
					if($option['tipo'] == 'textarea'){
					?>
					<tr id="bloco_<?php echo $option['nome']; ?>" valign="top">
						<th scope="row"><label for="<?php echo $option['nome']; ?>"><?php echo $option['label']; ?></label></th>
						<td><textarea name="<?php echo $option['nome']; ?>" type="text" id="<?php echo $option['nome']; ?>" style="width:<?php echo($option['tamanho'] > 0)? $option['tamanho'].'px': '70%'; ?>; height:150px;" class="regular-text"><?php echo @get_option($option['nome']); ?></textarea><?php if($option['descricao'] != ''){ ?><p class="description"><?php echo $option['descricao'];?></p><?php } ?></td>
					</tr>
					<?php
					}
					
					if($option['tipo'] == 'select'){
					?>
					<tr id="bloco_<?php echo $option['nome']; ?>" valign="top">
						<th scope="row"><label for="<?php echo $option['nome']; ?>"><?php echo $option['label']; ?></label></th>
						<td>
							<select name="<?php echo $option['nome']; ?>" id="<?php echo $option['nome']; ?>">
								<?php
								foreach($option['lista_itens'] as $item){
									?>
									<option value="<?php echo $item['valor']; ?>" <?php echo(get_option($option['nome']) == $item['valor'])? 'selected="selected"' : ''; ?>><?php echo $item['text']; ?></option>
									<?php
								}
								?>
							</select>
                            <?php if($option['descricao'] != ''){ ?><p class="description"><?php echo $option['descricao'];?></p><?php } ?>
						</td>
					</tr>
					<?php
					}
					
					if($option['tipo'] == 'radio'){
					?>
					<tr id="bloco_<?php echo $option['nome']; ?>" valign="top">
						<th scope="row"><label for="<?php echo $option['nome']; ?>"><?php echo $option['label']; ?></label></th>
						<td>
							<?php
							if($option['lista_itens']){
								$contador = 0;
								foreach($option['lista_itens'] as $item){
									?>
									<label style="margin-right:10px;"><input type="radio" name="<?php echo $option['nome']; ?>" id="<?php echo $option['nome'].'_'.$contador; ?>" value="<?php echo $item['valor']; ?>" <?php echo(get_option($option['nome']) == $item['valor'])? 'checked="checked"' : ''; ?>  /><?php echo $item['text']; ?></label>
									<?php
									$contador++;
								}
							}else{
								?>
								<input type="radio" name="<?php echo $option['nome']; ?>" id="<?php echo $option['nome']; ?>" />
								<?php
							}
							?>
                            <?php if($option['descricao'] != ''){ ?><p class="description"><?php echo $option['descricao'];?></p><?php } ?>
						</td>
					</tr>
					<?php
					}
					
					if($option['tipo'] == 'checkbox'){
					?>
					<tr id="bloco_<?php echo $option['nome']; ?>" valign="top">
						<th scope="row"><label for="<?php echo $option['nome']; ?>"><?php echo $option['label']; ?></label></th>
						<td>
							<?php
							if($option['lista_itens']){
								$contador = 0;
								foreach($option['lista_itens'] as $item){
									?>
									<label style="margin-right:10px;"><input type="checkbox" name="<?php echo $option['nome']; ?>[]" id="<?php echo $option['nome'].'_'.$contador; ?>" value="<?php echo $item['valor']; ?>" <?php echo(@in_array($item['valor'],get_option($option['nome'])))? 'checked="checked"' : ''; ?> /><?php echo $item['text']; ?></label>
									<?php
									$contador++;
								}
							}else{
								?>
							<input type="checkbox" name="<?php echo $option['nome']; ?>" id="<?php echo $option['nome']; ?>" />
								<?php
							}
							?>
                            <?php if($option['descricao'] != ''){ ?><p class="description"><?php echo $option['descricao'];?></p><?php } ?>
						</td>
					</tr>
					<?php
					}
					if($option['tipo'] == 'imagem'){
						
					?>
					<tr id="bloco_<?php echo $option['nome']; ?>" valign="top">
						<th scope="row"><label for="<?php echo $option['nome']; ?>"><?php echo $option['label']; ?></label></th>
						<td>
                            <input type="hidden" id="<?php echo $option['nome']; ?>" size="60" name="<?php echo $option['nome']; ?>" value="<?php echo @get_option($option['nome']); ?>" />
							<?php if(@get_option($option['nome']) != ''){
                                echo wp_get_attachment_image(@get_option($option['nome']), 'thumb_375x375', '', array('id' => $option['nome'].'_img', 'name' => $option['nome'].'_img','style' => 'background:#CCC; width:'.$option['tamanho'].'px; height:auto;')).'<br/>';
                            }else{
                            ?>
                            <img id="<?php echo $option['nome']; ?>_img" name="<?php echo $option['nome']; ?>_img" style="display:none; background:#CCC; width:<?php echo $option['tamanho']; ?>px; height:auto;" /><br/>
                            <?php }?>
							<input type="button" id="<?php echo $option['nome']; ?>_remover"  class="button button-primary" value="Remover imagem" style=" <?php echo(@get_option($option['nome']) == '')? 'display:none;' : ''; ?>" />
                            <input type="button" id="<?php echo $option['nome']; ?>_click"  class="button button-primary" value="Selecionar imagem" /><br/>
                            <?php if($option['descricao'] != ''){ ?><p class="description"><?php echo $option['descricao'];?></p><?php } ?>
                        </td>
						<script type="text/javascript">
                        jQuery(document).ready(function($){
                            var <?php echo $option['nome']; ?>;
                            $('#<?php echo $option['nome']; ?>_click').click(function(e) {
                                e.preventDefault();
                                if (<?php echo $option['nome']; ?>) {
                                    <?php echo $option['nome']; ?>.open();
                                    return;
                                }
                                <?php echo $option['nome']; ?> = wp.media.frames.file_frame = wp.media({
                                    title: 'Selecionar imagem',
                                    button: {
                                        text: 'Inserir imagem selecionada'
                                    },
                                    multiple: false
                                });
                                <?php echo $option['nome']; ?>.on('select', function() {
                                    attachment = <?php echo $option['nome']; ?>.state().get('selection').first().toJSON();
                                    $('#<?php echo $option['nome']; ?>').val(attachment.id);
                                    $("#<?php echo $option['nome']; ?>_img").fadeOut(function(){$(this).attr('src',attachment.url).fadeIn()});
                                    $('#<?php echo $option['nome']; ?>_remover').show();
                                });
                                <?php echo $option['nome']; ?>.open();
                            });
                            $('#<?php echo $option['nome']; ?>_remover').click(function(e) {
                                $(this).hide();
                                $('#<?php echo $option['nome']; ?>').val('');
                                $("#<?php echo $option['nome']; ?>_img").fadeOut(function(){$(this).attr('src','');});
                            });
                        });
                        </script>
					</tr>
					<?php
					}
					if($option['tipo'] == 'cor'){
					?>
					<tr id="bloco_<?php echo $option['nome']; ?>" valign="top">
					  <th scope="row"><label for="<?php echo $option['nome']; ?>"><?php echo $option['label']; ?></label></th>
					  <td>
						<link rel="Stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/lib/css/colorpicker.css" />
						<script src="<?php bloginfo('template_directory'); ?>/lib/js/jquery-1.11.2.min.js" type="text/javascript"></script>
						<script src="<?php bloginfo('template_directory'); ?>/lib/js/colorpicker.js" type="text/javascript"></script>
						<script type="text/javascript">        
						$(document).ready(function(){
							var corInicial = '<?php echo (get_option($option['nome']) != "")? get_option($option['nome']) : '0,0,0'; ?>';
							corInicial = corInicial.split(',');
							//console.log({r:corInicial[0], g:corInicial[1], b:corInicial[2]});
							$('#<?php echo $option['nome']; ?>_css').ColorPicker({
								color: {r:corInicial[0], g:corInicial[1], b:corInicial[2]},
								onShow: function (colpkr) {
									$(colpkr).fadeIn(500);
									return false;
								},
								onHide: function (colpkr) {
									$(colpkr).fadeOut(500);
									return false;
								},
								onChange: function (hsb, hex, rgb) {
									//console.log(rgb);
									$('#<?php echo $option['nome']; ?>').val(rgb.r + ',' + rgb.g + ',' + rgb.b);
									$('#<?php echo $option['nome']; ?>_css').css({'background': 'rgb(' + rgb.r + ',' + rgb.g + ',' + rgb.b + ')'});
								}
							});
						});
						</script>
						<input id="<?php echo $option['nome']; ?>" name="<?php echo $option['nome']; ?>" type="hidden" value="<?php echo (get_option($option['nome']) != "")? get_option($option['nome']) : '0,0,0'; ?>" />
						<div id="<?php echo $option['nome']; ?>_css" style="width:20px; height:20px; background: rgb(<?php echo (get_option($option['nome']) != "")? get_option($option['nome']) : '0,0,0'; ?>);"></div>
                        <?php if($option['descricao'] != ''){ ?><p class="description"><?php echo $option['descricao'];?></p><?php } ?>
					  </td>
					</tr>
					<?php
					}
					if($option['tipo'] == 'editor'){
					?>
					<tr id="bloco_<?php echo $option['nome']; ?>" valign="top">
					  <th scope="row"><label for="<?php echo $option['nome']; ?>"><?php echo $option['label']; ?></label></th>
					  <td>
							<?php wp_editor(htmlspecialchars_decode(get_option($option['nome'])), $option['nome'], $settings = array('textarea_name'=> $option['nome'])); ?>
                            <?php if($option['descricao'] != ''){ ?><p class="description"><?php echo $option['descricao'];?></p><?php } ?>
					  </td>
					</tr>
					<?php
					}
					
					if($option['tipo'] == 'galeria'){
						
					?>
					<tr id="bloco_<?php echo $option['nome']; ?>" valign="top">
						<th scope="row"><label for="<?php echo $option['nome']; ?>"><?php echo $option['label']; ?></label></th>
						<td>
                        	<style type="text/css">
								.lista_itens_<?php echo $option['nome']; ?>{border:solid 1px #ccc;}
								.lista_itens_<?php echo $option['nome']; ?> li{position:relative; width:100%; border-top:solid 1px #ccc; background:#fff; cursor:move;}
								.lista_itens_<?php echo $option['nome']; ?> li:active{border:dashed 1px #ccc;}
								.lista_itens_<?php echo $option['nome']; ?> li img{float:left; margin:12px 10px 0 12px;}
								.lista_itens_<?php echo $option['nome']; ?> li .link{position:absolute;right:0;top:0;padding: 5px 10px;background: #ccc;color: #f00;text-decoration: none;float: right;}
							</style>
                            
                            <ul class="lista_itens_<?php echo $option['nome']; ?>">
                            <?php
							$listaItens = get_option($option['nome']);
                            if($listaItens){
								for($i = 0; $i < count($listaItens); $i++){
									?>
                                    <li class="iten_<?php echo $option['nome']; ?>_<?php echo $listaItens[$i]['ID']; ?>">
                                    	<?php echo wp_get_attachment_image($listaItens[$i]['ID'],'thumbnail');?>
										<div class="campos">
                                            <p>
                                                <label>Título</label><br/>
                                                <input type="text" id="<?php echo $option['nome']; ?>_titulo[]" name="<?php echo $option['nome']; ?>_titulo[]" value="<?php echo $listaItens[$i]['titulo']; ?>" style="width:50%;" />
                                            </p>
                                            <p>
                                                <label>Descrição</label><br/>
                                                <input type="text" id="<?php echo $option['nome']; ?>_descricao[]" name="<?php echo $option['nome']; ?>_descricao[]" value="<?php echo $listaItens[$i]['descricao']; ?>" style="width:50%;" />
                                            </p>
                                            <p>
                                                <label>Link</label><br/>
                                                <input type="text" id="<?php echo $option['nome']; ?>_link[]" name="<?php echo $option['nome']; ?>_link[]" value="<?php echo $listaItens[$i]['link']; ?>" style="width:50%;" /><br>
                                                <label>Texto do Link</label><br/>
                                                <input type="text" id="<?php echo $option['nome']; ?>_link_texto[]" name="<?php echo $option['nome']; ?>_link_texto[]" value="<?php echo $listaItens[$i]['link_texto']; ?>" style="width:50%;" />
                                            </p>
                                            <input type="hidden" id="<?php echo $option['nome']; ?>_id[]" name="<?php echo $option['nome']; ?>_id[]" value="<?php echo $listaItens[$i]['ID']; ?>"  />
										</div>
										<a href="javascript:removerItem(<?php echo $listaItens[$i]['ID']; ?>);" class="link">Remover</a>
										</li>
                                    <?php
								}
							}
							?>
                            </ul><br/>
                            <input type="button" id="bt_<?php echo $option['nome']; ?>_click"  class="button button-primary" value="Selecionar imagens" />
                        </td>
						<script type="text/javascript">
						function removerItem(id){
							jQuery('.iten_<?php echo $option['nome']; ?>_'+id).remove();
						}
						jQuery(document).ready(function(e) {
							jQuery(".lista_itens_<?php echo $option['nome']; ?>").sortable();
							jQuery(".lista_itens_<?php echo $option['nome']; ?>").disableSelection(); 
							
                            var <?php echo $option['nome']; ?>;
                            jQuery('#bt_<?php echo $option['nome']; ?>_click').click(function(e) {
                                e.preventDefault();
                                if (<?php echo $option['nome']; ?>) {
                                    <?php echo $option['nome']; ?>.open();
                                    return;
                                }
                                <?php echo $option['nome']; ?> = wp.media.frames.file_frame = wp.media({
                                    title: 'Selecionar imagens',
                                    button: {
                                        text: 'Inserir imagens selecionadas'
                                    },
                                    multiple: true
                                });
                                <?php echo $option['nome']; ?>.on('select', function() {
                                    //attachment = <?php echo $option['nome']; ?>.state().get('selection').first().toJSON();
									attachment = <?php echo $option['nome']; ?>.state().get('selection').toJSON();
									
									var htmlAdd = '';
									
									for(var i = 0; i < attachment.length; i++){
										console.log(attachment[i]);
										htmlAdd +='<li class="iten_<?php echo $option['nome']; ?>_'+attachment[i].id+'">';
										if(attachment[i].sizes.thumbnail){
											htmlAdd +='<img src="'+attachment[i].sizes.thumbnail.url+'" width="150" height="150" />';
										}else{
											htmlAdd +='<img src="'+attachment[i].url+'" width="150" height="150" />';
										}
										htmlAdd +='<div class="campos"><p><label>Título</label><br/>';
										htmlAdd +='<input type="text" id="<?php echo $option['nome']; ?>_titulo[]" name="<?php echo $option['nome']; ?>_titulo[]" value="'+attachment[i].title+'" style="width:50%;" />';
										htmlAdd +='</p><p><label>Descrição</label><br/>';
										htmlAdd +='<input type="text" id="<?php echo $option['nome']; ?>_descricao[]" name="<?php echo $option['nome']; ?>_descricao[]" value="" style="width:50%;" />';
										htmlAdd +='</p><p><label>Link</label><br/>';
										htmlAdd +='<input type="text" id="<?php echo $option['nome']; ?>_link[]" name="<?php echo $option['nome']; ?>_link[]" value="'+attachment[i].url+'" style="width:50%;" />';
										htmlAdd +='</p>';
										htmlAdd +='<input type="hidden" id="<?php echo $option['nome']; ?>_id[]" name="<?php echo $option['nome']; ?>_id[]" value="'+attachment[i].id+'"  />';
										htmlAdd +='</div>';
										htmlAdd +='<a href="javascript:removerItem('+attachment[i].id+');" class="link">Remover</a>';
										htmlAdd +='</li>';
									}
									jQuery(".lista_itens_<?php echo $option['nome']; ?>").append(htmlAdd);
                                });
                                <?php echo $option['nome']; ?>.open();
                            });
                        });
                        </script>
					</tr>
					<?php
					}
				}
			}
		}
	}

	public function save_options(){
		if($_POST){
			if($this->list_options){
				foreach($this->list_options as $option){
					if($option['pagina'] == $_GET['page'] || $option['pagina'].'-'.$option['post_type'] == $_GET['page']){
						if($option['tipo'] == 'checkbox'){
							if(isset($_POST[$option['nome']])){
								update_option($option['nome'], $_POST[$option['nome']],'no') or add_option($option['nome'], $_POST[$option['nome']],'','no');
							}else{
								update_option($option['nome'], array(),'no') or add_option($option['nome'], array(),'','no');
							}
						}else
						if($option['tipo'] == 'galeria'){
							if(isset($_POST[$option['nome'].'_id'])){ 
								$listaItens = '';
								for($i = 0; $i < count($_POST[$option['nome'].'_id']); $i++){
									$listaItens[] = array(
										'ID' => $_POST[$option['nome'].'_id'][$i],
										'titulo' => $_POST[$option['nome'].'_titulo'][$i],
										'descricao' => $_POST[$option['nome'].'_descricao'][$i],
										'link' => $_POST[$option['nome'].'_link'][$i],
                                        'link_texto' => $_POST[$option['nome'].'_link_texto'][$i],
                                        'link_externo' => $_POST[$option['nome'].'_link_externo'][$i]

									);
								}
								
								update_option($option['nome'], $listaItens,'no') or add_option($option['nome'], $listaItens,'','no');
							}else{
								update_option($option['nome'], array(),'no') or add_option($option['nome'], array(),'','no');
							}
						}else
						if($option['tipo'] == 'editor'){	
							$string = str_replace('\"','',$_POST[$option['nome']]);
							//echo html_entity_decode($string);
							update_option($option['nome'], $string,'no') 
							or 
							add_option($option['nome'], $string,'','no');
						}else{
							if(isset($_POST[$option['nome']])){
								update_option($option['nome'], $_POST[$option['nome']],'no') or add_option($option['nome'], $_POST[$option['nome']],'','no');
							}
						}
					}
				}
			}
		}
	}
	
	public function list_options(){
		return $this->list_options;
	}
	
	public function set_option($label, $nome,$tipo, $lista_itens = null, $pagina, $descricao = "" , $tamanho = 0, $post_type = ''){
		$this->list_options[] = array('label' => $label,'nome' => $nome, 'tipo' => $tipo, 'lista_itens' => $lista_itens, 'pagina' => $pagina, 'descricao' => $descricao, 'tamanho' => $tamanho, 'post_type' => $post_type);
	}
	
	
	
	public function list_table(){
		return $this->tabela_listagem;
	}
	
	public function set_list_table($label, $query, $export = false, $lista_campos = null, $pagina){
		$this->tabela_listagem[] = array('label' => $label, 'query' => $query, 'export' => $export, 'lista_campos' => $lista_campos, 'pagina' => $pagina);
	}
	/* Estrutura para criação de options nas páginas do admim */
}
?>