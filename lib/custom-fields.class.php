<?php
class Meta_Box{
	private $list_meta_box;
	private $list_custom_fields;
	
	public function __construct(){
		add_action('admin_head', array($this, 'admin_head'));
		$this->list_meta_box = array();
	}
	
	public function admin_head() {
		echo '<script type="text/javascript" src="' . get_template_directory_uri() . '/lib/js/custom_fields.js' . '"></script>';
	}
	
	
	/* Estrutura para criação de meta box no admin */
	public function add_metas_box(){
		add_action('admin_init',  array($this, 'load_meta_box'));
	}
	
	public function load_meta_box(){
		foreach($this->list_meta_box as $metabox){
			add_meta_box($metabox['nome'], $metabox['titulo'], array($this,'create_meta_box'), $metabox['post_type'], "normal", "low");
		}
	}
	
	public function create_meta_box($post,$metabox){
		$campo = get_post_custom($post->ID);
		?>
		<!--<h3><strong><?php echo $metabox['title']; ?></strong></h3>-->
		<table class="form-table">
        <?php
		if($this->list_custom_fields){
			foreach($this->list_custom_fields as $option){
				if($option['meta_box_name'] == $metabox['id']){
					
					if($option['tipo'] == 'text'){
					?>
					<tr id="bloco_<?php echo $option['nome']; ?>" valign="top">
						<th scope="row"><label for="<?php echo $option['nome']; ?>"><?php echo $option['label']; ?></label></th>
						<td><input name="<?php echo $option['nome']; ?>" type="text" id="<?php echo $option['nome']; ?>" style="width:<?php echo($option['tamanho'] > 0)? $option['tamanho'].'px': '70%'; ?>;" value="<?php echo @$campo[$option['nome']][0]; ?>" class="regular-text" /><?php if($option['descricao'] != ''){ ?><p class="description"><?php echo $option['descricao'];?></p><?php } ?></td>
					</tr>
					<?php
					}
					
					if($option['tipo'] == 'password'){
					?>
					<tr id="bloco_<?php echo $option['nome']; ?>" valign="top">
						<th scope="row"><label for="<?php echo $option['nome']; ?>"><?php echo $option['label']; ?></label></th>
						<td><input name="<?php echo $option['nome']; ?>" type="password" id="<?php echo $option['nome']; ?>" style="width:<?php echo($option['tamanho'] > 0)? $option['tamanho'].'px': '70%'; ?>;" value="<?php echo @$campo[$option['nome']][0]; ?>" class="regular-text" /><?php if($option['descricao'] != ''){ ?><p class="description"><?php echo $option['descricao'];?></p><?php } ?></td>
					</tr>
					<?php
					}
					
					if($option['tipo'] == 'textarea'){
					?>
					<tr id="bloco_<?php echo $option['nome']; ?>" valign="top">
						<th scope="row"><label for="<?php echo $option['nome']; ?>"><?php echo $option['label']; ?></label></th>
						<td><textarea name="<?php echo $option['nome']; ?>" type="text" id="<?php echo $option['nome']; ?>" style="width:<?php echo($option['tamanho'] > 0)? $option['tamanho'].'px': '70%'; ?>; height:150px;" class="regular-text"><?php echo @$campo[$option['nome']][0]; ?></textarea><?php if($option['descricao'] != ''){ ?><p class="description"><?php echo $option['descricao'];?></p><?php } ?></td>
					</tr>
					<?php
					}

                    if($option['tipo'] == 'maps'){
                        ?>
                        <tr id="bloco_<?php echo $option['nome']; ?>" valign="top">
                            <th scope="row"><label for="<?php echo $option['nome']; ?>"><?php echo $option['label']; ?></label></th>
                            <td><textarea name="<?php echo $option['nome']; ?>" type="text" id="<?php echo $option['nome']; ?>" style="width:<?php echo($option['tamanho'] > 0)? $option['tamanho'].'px': '70%'; ?>; height:150px;" class="regular-text"><?php echo @$campo[$option['nome']][0]; ?></textarea><?php if($option['descricao'] != ''){ ?><p class="description"><?php echo $option['descricao'];?></p><?php } ?></td>
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
									<option value="<?php echo $item['valor']; ?>" <?php echo((@$campo[$option['nome']][0]) == $item['valor'])? 'selected="selected"' : ''; ?>><?php echo $item['text']; ?></option>
									<?php
								}
								?>
							</select>
                            <?php if($option['descricao'] != ''){ ?><p class="description"><?php echo $option['descricao'];?></p><?php } ?>
                            <input name="<?php echo $option['nome']; ?>_temp" id="<?php echo $option['nome']; ?>_temp" type="hidden" value="<?php echo $campo[$option['nome']][0]; ?>" />
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
									<label style="margin-right:10px;"><input type="radio" name="<?php echo $option['nome']; ?>" id="<?php echo $option['nome'].'_'.$contador; ?>" value="<?php echo $item['valor']; ?>" <?php echo((@$campo[$option['nome']][0]) == $item['valor'])? 'checked="checked"' : ''; ?>  /><?php echo $item['text']; ?></label>
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
									<label style="margin-right:10px;"><input type="checkbox" name="<?php echo $option['nome']; ?>[]" id="<?php echo $option['nome'].'_'.$contador; ?>" value="<?php echo $item['valor']; ?>" <?php echo(@in_array($item['valor'],(@unserialize($campo[$option['nome']][0]))))? 'checked="checked"' : ''; ?> /><?php echo $item['text']; ?></label>
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
                            <input type="hidden" id="<?php echo $option['nome']; ?>" size="60" name="<?php echo $option['nome']; ?>" value="<?php echo @$campo[$option['nome']][0]; ?>" />
							<?php if(@$campo[$option['nome']][0] != ''){
                                echo wp_get_attachment_image(@$campo[$option['nome']][0], 'thumb_375x375', '', array('id' => $option['nome'].'_img', 'name' => $option['nome'].'_img','style' => 'background:#CCC; width:200px; height:auto;')).'<br/>';
                            }else{
                            ?>
                            <img id="<?php echo $option['nome']; ?>_img" name="<?php echo $option['nome']; ?>_img" style="display:none; background:#CCC; width:200px; height:auto;" /><br/>
                            <?php }?>
							<input type="button" id="<?php echo $option['nome']; ?>_remover"  class="button button-primary" value="Remover imagem" style=" <?php echo(@$campo[$option['nome']][0] == '')? 'display:none;' : ''; ?>" />
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
					
					if($option['tipo'] == 'arquivo'){
						
					?>
					<tr id="bloco_<?php echo $option['nome']; ?>" valign="top">
						<th scope="row"><label for="<?php echo $option['nome']; ?>"><?php echo $option['label']; ?></label></th>
						<td>
                            <input type="text" id="<?php echo $option['nome']; ?>" size="60" name="<?php echo $option['nome']; ?>" value="<?php echo @$campo[$option['nome']][0]; ?>" />
                            <input type="button" id="<?php echo $option['nome']; ?>_click"  class="button button-primary" value="Selecionar Arquivo" /><br/>
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
                                    title: 'Selecionar arquivo',
                                    button: {
                                        text: 'Inserir arquivo selecionado'
                                    },
                                    multiple: false
                                });
                                <?php echo $option['nome']; ?>.on('select', function() {
                                    attachment = <?php echo $option['nome']; ?>.state().get('selection').first().toJSON();
                                    $('#<?php echo $option['nome']; ?>').val(attachment.url);
                                });
                                <?php echo $option['nome']; ?>.open();
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
							var corInicial = '<?php echo (@$campo[$option['nome']][0] != "")? $campo[$option['nome']][0] : '0,0,0'; ?>';
							corInicial = corInicial.split(',');
							console.log({r:corInicial[0], g:corInicial[1], b:corInicial[2]});
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
									console.log(rgb);
									console.log();
									$('#<?php echo $option['nome']; ?>').val(rgb.r + ',' + rgb.g + ',' + rgb.b);
									$('#<?php echo $option['nome']; ?>_css').css({'background': 'rgb(' + rgb.r + ',' + rgb.g + ',' + rgb.b + ')'});
								}
							});
						});
						</script>
						<input id="<?php echo $option['nome']; ?>" name="<?php echo $option['nome']; ?>" type="hidden" value="<?php echo (@$campo[$option['nome']][0] != "")? $campo[$option['nome']][0] : '0,0,0'; ?>" />
						<div id="<?php echo $option['nome']; ?>_css" style="width:20px; height:20px; background: rgb(<?php echo (@$campo[$option['nome']][0] != "")? $campo[$option['nome']][0] : '0,0,0'; ?>);"></div>
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
							<?php wp_editor(htmlspecialchars_decode(@$campo[$option['nome']][0]), $option['nome'], $settings = array('textarea_name'=> $option['nome'])); ?>
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
                            
                            <?php $listaItens = unserialize(@$campo[$option['nome']][0]); ?>
                            
                            <ul class="lista_itens_<?php echo $option['nome']; ?>">
                            <?php
                            if($listaItens){
								for($i = 0; $i < count($listaItens); $i++){
									?>
                                    <li class="iten_<?php echo $option['nome']; ?>_<?php echo $i; ?>">
                                    	<?php echo wp_get_attachment_image($listaItens[$i]['ID'],'thumb_galeria');?>
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
                                                <label>Link da Imagem</label><br/>
                                                <input type="text" readonly id="<?php echo $option['nome']; ?>_link[]" name="<?php echo $option['nome']; ?>_link[]" value="<?php echo $listaItens[$i]['link']; ?>" style="width:50%;" />
                                            </p>
                                            <p>
                                                <label>Texto do Botão (se houver)</label><br/>
                                                <input type="text" id="<?php echo $option['nome']; ?>_link_texto[]" name="<?php echo $option['nome']; ?>_link_texto[]" value="<?php echo $listaItens[$i]['link_texto']; ?>" style="width:50%;" />
                                            </p>
                                            <input type="hidden" id="<?php echo $option['nome']; ?>_id[]" name="<?php echo $option['nome']; ?>_id[]" value="<?php echo $listaItens[$i]['ID']; ?>"  />
										</div>
										<a href="javascript:removerItem<?php echo $option['nome']; ?>(<?php echo $i; ?>);" class="link">Remover</a>
										</li>
                                    <?php
								}
							}
							?>
                            </ul><br/>
                            <input type="button" id="bt_<?php echo $option['nome']; ?>_click"  class="button button-primary" value="Selecionar imagens" />
                        </td>
						<script type="text/javascript">
						function removerItem<?php echo $option['nome']; ?>(id){
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
										htmlAdd +='<img src="'+attachment[i].sizes.thumbnail.url+'" width="150" height="150" />';
										htmlAdd +='<div class="campos"><p><label>Título</label><br/>';
										htmlAdd +='<input type="text" id="<?php echo $option['nome']; ?>_titulo[]" name="<?php echo $option['nome']; ?>_titulo[]" value="'+attachment[i].title+'" style="width:50%;" />';
										htmlAdd +='</p><p><label>Descrição</label><br/>';
										htmlAdd +='<input type="text" id="<?php echo $option['nome']; ?>_descricao[]" name="<?php echo $option['nome']; ?>_descricao[]" value="" style="width:50%;" />';
										htmlAdd +='</p><p><label>Link</label><br/>';
										htmlAdd +='<input type="text" id="<?php echo $option['nome']; ?>_link[]" name="<?php echo $option['nome']; ?>_link[]" value="'+attachment[i].url+'" style="width:50%;" />';
										htmlAdd +='</p>';
										htmlAdd +='<input type="hidden" id="<?php echo $option['nome']; ?>_id[]" name="<?php echo $option['nome']; ?>_id[]" value="'+attachment[i].id+'"  />';
										htmlAdd +='</div>';
										htmlAdd +='<a href="javascript:removerItemBloco('+attachment[i].id+');" class="link">Remover</a>';
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
					
					
					if($option['tipo'] == 'blocos'){
					?>
					<tr id="bloco_<?php echo $option['nome']; ?>" valign="top">
						<th scope="row"><label for="<?php echo $option['nome']; ?>"><?php echo $option['label']; ?></label></th>
						<td>
                        	<style type="text/css">
								.lista_itens_<?php echo $option['nome']; ?>{border:solid 1px #ccc;}
								.lista_itens_<?php echo $option['nome']; ?> li{position:relative; width:100%; border-top:solid 1px #ccc; background:#fff; cursor:move; padding-bottom:10px; margin:0;}
								.lista_itens_<?php echo $option['nome']; ?> li:active{border:dashed 1px #ccc;}
								.lista_itens_<?php echo $option['nome']; ?> li.alter{background:#f5f5f5;}
								.lista_itens_<?php echo $option['nome']; ?> li img{float:left; margin:12px 10px 0 12px;}
								.lista_itens_<?php echo $option['nome']; ?> li .link{position:absolute;right:0;top:0;padding: 5px 10px;background: #ccc;color: #f00;text-decoration: none;float: right;}
								.lista_itens_<?php echo $option['nome']; ?> li .campos{padding-left:20px; display: block; padding-left: 230px;}
								.lista_itens_<?php echo $option['nome']; ?> li .tituloBloco{width: 100%;height: auto;padding: 10px 10px;background: #ccc;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;margin: 0;font-weight: bold;font-size: 14px;line-height: 14px;}
							</style>
                        	
                                                
							<script type="text/javascript">
                               function adicionarImagem(imagem_num){
                                    var <?php echo $option['nome']; ?>;
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
                                        jQuery('.<?php echo $option['nome']; ?>_imagem_id_'+imagem_num).val(attachment.id);
                                        jQuery(".<?php echo $option['nome']; ?>_imagem_"+imagem_num).fadeOut(function(){jQuery(this).attr('src',attachment.url).fadeIn()});
                                        jQuery('.<?php echo $option['nome']; ?>_remover_'+imagem_num).show();
                                    });
                                    <?php echo $option['nome']; ?>.open();
                               }
                                
                                function removerImagem(imagem_num){
                                    jQuery('.<?php echo $option['nome']; ?>_remover_'+imagem_num).hide();
                                    jQuery('.<?php echo $option['nome']; ?>_imagem_id_'+imagem_num).val('');
                                    jQuery(".<?php echo $option['nome']; ?>_imagem_"+imagem_num).fadeOut(function(){jQuery(this).attr('src','');});
                                }
                            </script>
                            
                            <?php 
							
							$listaItens = unserialize(@$campo[$option['nome']][0]); 
							
							// print_r($listaItens);
							
							$listaTipoConteudo = array(
								array('Conteudos','conteudo','type_conteudo')
							);
							?>
                            
                            <ul class="lista_itens_<?php echo $option['nome']; ?>">
                            <?php
                            if($listaItens){
								for($i = 0; $i < count($listaItens); $i++){
									
									$itensBloco = explode(',',$listaItens[$i]['itens']);
									?>
                                    <li class="iten_<?php echo $option['nome']; ?>_<?php echo $i; ?> <?php echo ($i % 2)? 'alter' : ''; ?>">
                                    	<p class="tituloBloco"><?php echo $listaItens[$i]['titulo_bloco']; ?></p>
                                        <img src="<?php bloginfo('template_directory'); ?>/blocos/thumbs/<?php echo str_replace('.php','.jpg',$listaItens[$i]['template'])?>" width="200" />
										<div class="campos">
                                            <p style=" <?php echo (in_array('imagem',$itensBloco)) ? 'display:block;' : 'display:none'; ?>">
                                                <label>Imagem</label><br/>
                                                <input type="hidden" id="<?php echo $option['nome']; ?>_imagem[]" name="<?php echo $option['nome']; ?>_imagem[]" value="<?php echo $listaItens[$i]['imagem']; ?>" style="width:50%;" class="<?php echo $option['nome']; ?>_imagem_id_<?php echo $i; ?>" />
                                                
												<?php if($listaItens[$i]['imagem'] != ''){
                                                    echo wp_get_attachment_image($listaItens[$i]['imagem'], 'thumb_375x375', '', array('id' => $option['nome'].'_img', 'name' => $option['nome'].'_img','style' => 'background:#CCC; width:200px; height:auto; float:none;', 'class' => $option['nome'].'_imagem_'.$i)).'<br/>';
                                                }else{
                                                ?>
                                                <img id="<?php echo $option['nome']; ?>_img" name="<?php echo $option['nome']; ?>_img" style="display:none; background:#CCC; width:200px; height:auto; float:none;" class="<?php echo $option['nome']; ?>_imagem_<?php echo $i; ?>" /><br/>
                                                <?php }?>
                                                <input type="button" id="<?php echo $option['nome']; ?>_remover" onclick="removerImagem(<?php echo $i; ?>);" class="button button-primary <?php echo $option['nome']; ?>_remover_<?php echo $i; ?>" value="Remover imagem" style=" <?php echo($listaItens[$i]['imagem'] == '')? 'display:none;' : ''; ?>" />
                                                <input type="button" id="<?php echo $option['nome']; ?>_click" onclick="adicionarImagem(<?php echo $i; ?>);"  class="button button-primary" value="Selecionar imagem" /><br/>
                                                
                                            </p>
                                        
                                        
                                            <p style=" <?php echo (in_array('titulo',$itensBloco)) ? 'display:block;' : 'display:none'; ?>">
                                                <label>Título</label><br/>
                                                <input type="text" id="<?php echo $option['nome']; ?>_titulo[]" name="<?php echo $option['nome']; ?>_titulo[]" value="<?php echo $listaItens[$i]['titulo']; ?>" style="width:90%;" />
                                            </p>
                                            
                                            <p style=" <?php echo (in_array('descricao',$itensBloco)) ? 'display:block;' : 'display:none'; ?>">
                                                <label>Descrição</label><br/>
                                                <textarea id="<?php echo $option['nome']; ?>_descricao[]" name="<?php echo $option['nome']; ?>_descricao[]" style="width:90%; height:100px;"><?php echo $listaItens[$i]['descricao']; ?></textarea>
                                            </p>
                                            
                                            <p style=" <?php echo (in_array('text1',$itensBloco)) ? 'display:block;' : 'display:none'; ?>">
                                                <label>Texto1</label><br/>
                                                <input type="text" id="<?php echo $option['nome']; ?>_text1[]" name="<?php echo $option['nome']; ?>_text1[]" value="<?php echo $listaItens[$i]['text1']; ?>" style="width:90%;" />
                                            </p>
                                            
                                            <p style=" <?php echo (in_array('text2',$itensBloco)) ? 'display:block;' : 'display:none'; ?>">
                                                <label>Texto2</label><br/>
                                                <input type="text" id="<?php echo $option['nome']; ?>_text2[]" name="<?php echo $option['nome']; ?>_text2[]" value="<?php echo $listaItens[$i]['text2']; ?>" style="width:90%;" />
                                            </p>
                                            
                                            <p style=" <?php echo (in_array('text3',$itensBloco)) ? 'display:block;' : 'display:none'; ?>">
                                                <label>Texto3</label><br/>
                                                <input type="text" id="<?php echo $option['nome']; ?>_text3[]" name="<?php echo $option['nome']; ?>_text3[]" value="<?php echo $listaItens[$i]['text3']; ?>" style="width:90%;" />
                                            </p>
                                            
                                            
                                            <p style=" <?php echo (in_array('link1',$itensBloco)) ? 'display:block;' : 'display:none'; ?>">
                                                <label>Link 1</label><br/>
                                                <input type="text" id="<?php echo $option['nome']; ?>_link1[]" name="<?php echo $option['nome']; ?>_link1[]" value="<?php echo $listaItens[$i]['link1']; ?>" style="width:90%;" />
                                            </p>
                                            
                                            <p style=" <?php echo (in_array('link2',$itensBloco)) ? 'display:block;' : 'display:none'; ?>">
                                                <label>Link 2</label><br/>
                                                <input type="text" id="<?php echo $option['nome']; ?>_link2[]" name="<?php echo $option['nome']; ?>_link2[]" value="<?php echo $listaItens[$i]['link2']; ?>" style="width:90%;" />
                                            </p>
                                            
                                            
                                            <p style=" <?php echo (in_array('link3',$itensBloco)) ? 'display:block;' : 'display:none'; ?>">
                                                <label>Link 3</label><br/>
                                                <input type="text" id="<?php echo $option['nome']; ?>_link3[]" name="<?php echo $option['nome']; ?>_link3[]" value="<?php echo $listaItens[$i]['link3']; ?>" style="width:90%;" />
											</p>
											
											<p style=" <?php echo (in_array('textBotao',$itensBloco)) ? 'display:block;' : 'display:none'; ?>">
                                                <label>Texto Botão</label><br/>
                                                <input type="text" id="<?php echo $option['nome']; ?>_textBotao[]" name="<?php echo $option['nome']; ?>_textBotao[]" value="<?php echo $listaItens[$i]['textBotao']; ?>" style="width:90%;" />
                                            </p>
                                            
                                            <p style=" <?php echo (in_array('type_conteudo',$itensBloco)) ? 'display:block;' : 'display:none'; ?>">
                                                <label>Listagem de conteúdo</label><br/>
                                                <select id="<?php echo $option['nome']; ?>_type_conteudo[]" name="<?php echo $option['nome']; ?>_type_conteudo[]" style="width:50%;" onchange="CarregarTaxonomys(<?php echo $i; ?>);" class="<?php echo $option['nome']; ?>_type_conteudo_change_<?php echo $i; ?>">
                                                	<option value="0">Nenhum</option>
													<?php
													for($ic = 0; $ic < count($listaTipoConteudo); $ic++){
														echo '<option value="'.$listaTipoConteudo[$ic][1].'" '.(($listaTipoConteudo[$ic][1] == $listaItens[$i]['type_conteudo'])? 'selected="selected"' : '').' data-type="'.@$listaTipoConteudo[$ic][2].'">'.$listaTipoConteudo[$ic][0].'</option>';
													}
													?>
                                                </select>
                                            </p>
                                            
                                            <p style=" <?php echo (in_array('type_conteudo',$itensBloco)) ? 'display:block;' : 'display:none'; ?>" class="<?php echo $option['nome']; ?>_taxonomy_<?php echo $item->ID; ?>">
                                                <label>Tipo da listagem</label><br/>
                                                <select id="<?php echo $option['nome']; ?>_campo_bloco[<?php echo $item->ID; ?>][taxonomy_id_conteudo]" name="<?php echo $option['nome']; ?>_campo_bloco[<?php echo $item->ID; ?>][taxonomy_id_conteudo]" style="width:50%;">
                                                	<option value="0">Todos</option>
													<?php
													$taxonomys = get_terms();
													// print_r($taxonomys);
													foreach($taxonomys as $taxonomy){
														echo '<option value="'.$taxonomy->term_id.'" style="'.(($dadosBloco['taxonomy_conteudo'] == $taxonomy->taxonomy)? '' : 'display:none;').'" '.(($dadosBloco['taxonomy_id_conteudo'] == $taxonomy->term_id)? 'selected="selected"' : '').' data-type="'.$taxonomy->taxonomy.'">'.$taxonomy->name.'</option>';
													}
													?>
                                                </select>
                                            </p>
                                            
                                            
                                            <p style=" <?php echo (in_array('qtd_showposts',$itensBloco)) ? 'display:block;' : 'display:none'; ?>">
                                                <label>QTD. itens por página</label><br/>
                                                <input type="text" id="<?php echo $option['nome']; ?>_qtd_showposts[]" name="<?php echo $option['nome']; ?>_qtd_showposts[]" style="width:50%;" value="<?php echo $listaItens[$i]['qtd_showposts']; ?>" />
                                            </p>
                                            
                                            
                                            <input type="hidden" id="<?php echo $option['nome']; ?>_template[]" name="<?php echo $option['nome']; ?>_template[]" value="<?php echo $listaItens[$i]['template']; ?>"  />
                                            <input type="hidden" id="<?php echo $option['nome']; ?>_titulo_bloco[]" name="<?php echo $option['nome']; ?>_titulo_bloco[]" value="<?php echo $listaItens[$i]['titulo_bloco']; ?>"  />
                                            
											<input type="hidden" id="<?php echo $option['nome']; ?>_itens[]" name="<?php echo $option['nome']; ?>_itens[]" value="<?php echo $listaItens[$i]['itens']; ?>"  />
                                            
											<input type="hidden" id="<?php echo $option['nome']; ?>_taxonomy_conteudo[]" name="<?php echo $option['nome']; ?>_taxonomy_conteudo[]" value="<?php echo $listaItens[$i]['taxonomy_conteudo']; ?>" class="<?php echo $option['nome']; ?>_taxonomy_conteudo_val_<?php echo $i; ?>"  />
										</div>
										<a href="javascript:removerItemBloco(<?php echo $i; ?>);" class="link">Remover</a>
									</li>
									<?php
								}
							}
							?>
                            </ul><br/>
                        
                        	
                        	<select name="<?php echo $option['nome']; ?>" id="<?php echo $option['nome']; ?>" style="width:<?php echo($option['tamanho'] > 0)? $option['tamanho'].'px': '70%'; ?>;" class="regular-text" />
                            	<option value="">(--Selecione--)</option>
                            	<?php
								$pal = "NomeBlocoTemplate:";
								$dir = get_template_directory().'/blocos/';
								$open = opendir($dir);
								while(false !== ($files = readdir($open))){
									@$fp = fopen($dir.$files,"r");
									@$le = fread($ab,filesize($dir.$files));
									@fclose($ab);
									if($fp){
										while (!feof($fp)){
											$linha = fgets($fp,1024);
											if(preg_match("/($pal)/",$linha)){
												$linha = explode('*/',$linha);
												$templateName = explode('|',trim(str_replace(array('/*','*/',$pal),'',$linha[0])));
												$templateName = @trim($templateName[0]);
												$itensTemplate = explode('|',trim(str_replace(array('/*','*/',$pal),'',$linha[0])));
												$itensTemplate = @trim($itensTemplate[1]);
												?>
												<option value="<?php echo $files; ?>" data-type="<?php echo $itensTemplate; ?>"><?php echo $templateName; ?></option>
												<?php
											};
											
										}
										
									}
								}
								?>
                            </select>
                            
                            <input type="button" id="bt_<?php echo $option['nome']; ?>_click"  class="button button-primary" value="Adicionar Bloco" />
							
							<?php if($option['descricao'] != ''){ ?>
                            	<p class="description"><?php echo $option['descricao'];?></p>
							<?php } ?>
                            
                            <script type="text/javascript">
							
							function CarregarTaxonomys(id){
								var taxonomy = jQuery(".<?php echo $option['nome']; ?>_type_conteudo_change_"+id+" option:selected").attr('data-type');
								jQuery(".<?php echo $option['nome']; ?>_taxonomy_conteudo_val_"+id).val(taxonomy);
								jQuery(".<?php echo $option['nome']; ?>_taxonomy_"+id+" select option").each(function(index, element) {
									if(jQuery(this).val() == 0){
										jQuery(this).attr('selected');
									}else{
										jQuery(this).removeAttr('selected');
									}
									if(jQuery(this).val() > 0){
										if(jQuery(this).attr('data-type') == taxonomy){
											jQuery(this).show();
										}else{
											jQuery(this).hide();
										}
									}
								});
								
							}
							
							function updateListagem(){
								jQuery(".lista_itens_<?php echo $option['nome']; ?> li").each(function(index, element) {
									jQuery(this).attr('class','iten_<?php echo $option['nome']; ?>_'+index+' '+((index % 2)? 'alter' : ''));
									jQuery('.link', this).attr('href','javascript:removerItemBloco('+index+');');
									jQuery('.<?php echo $option['nome']; ?>_taxonomy', this).attr('class','<?php echo $option['nome']; ?>_taxonomy_'+index);
									jQuery('.<?php echo $option['nome']; ?>_type_conteudo_change', this).attr('onchange','CarregarTaxonomys('+index+');').attr('class','<?php echo $option['nome']; ?>_type_conteudo_change_'+index);
									
									jQuery('.<?php echo $option['nome']; ?>_taxonomy_conteudo_val_', this).attr('class','<?php echo $option['nome']; ?>_taxonomy_conteudo_val_'+index);
									
									
								});
							}
							
							function removerItemBloco(id){
								jQuery('.iten_<?php echo $option['nome']; ?>_'+id).remove();
								updateListagem();
							}
							
							
							jQuery(document).ready(function(e) {
								jQuery(".lista_itens_<?php echo $option['nome']; ?>").sortable();
								jQuery(".lista_itens_<?php echo $option['nome']; ?>").disableSelection(); 
								jQuery(".lista_itens_<?php echo $option['nome']; ?>").sortable({
									stop: function( ) {
										updateListagem();
									}
								});
								
								var <?php echo $option['nome']; ?>;
								jQuery('#bt_<?php echo $option['nome']; ?>_click').click(function(e) {
									if(jQuery("#<?php echo $option['nome']; ?>").val() != ''){
										var titulo = jQuery("#<?php echo $option['nome']; ?> option:selected").text();
										var template = jQuery("#<?php echo $option['nome']; ?> option:selected").val();
										var itens = jQuery("#<?php echo $option['nome']; ?> option:selected").attr('data-type');
										var html = '';
										var nome_imagem = template.replace('.php','.jpg');
										html += '<li>';
											html += '<p class="tituloBloco">'+titulo+'</p>';
											html += '<img src="<?php bloginfo('template_directory'); ?>/blocos/thumbs/'+nome_imagem+'" width="200" />';
											
											html += '<div class="campos">';
												
												html += '<p style="display:'+((itens.indexOf("imagem") != -1)? 'block': 'none')+';">';
													html += '<label>Imagem</label><br/>';
													
													html += '<input type="hidden" id="<?php echo $option['nome']; ?>_imagem[]" name="<?php echo $option['nome']; ?>_imagem[]" value="<?php echo $listaItens[$i]['imagem']; ?>" style="width:50%;" class="<?php echo $option['nome']; ?>_imagem_id_<?php echo $i; ?>" />';
										
													html += '<?php if($listaItens[$i]['imagem'] != ''){
														echo wp_get_attachment_image($listaItens[$i]['imagem'], 'thumb_375x375', '', array('id' => $option['nome'].'_img', 'name' => $option['nome'].'_img','style' => 'background:#CCC; width:200px; height:auto; float:none;', 'class' => $option['nome'].'_imagem_'.$i)).'<br/>';
													}else{
														echo '<img id='.$option['nome'].'_img" name="'.$option['nome'].'_img" style="display:none; background:#CCC; width:200px; height:auto; float:none;" class="'.$option['nome'].'_imagem_'.$i.'" /><br/>';
													}
													?>';
													
													html += '<input type="button" id="<?php echo $option['nome']; ?>_remover" onclick="removerImagem(<?php echo $i; ?>);" class="button button-primary <?php echo $option['nome']; ?>_remover_<?php echo $i; ?>" value="Remover imagem" style=" <?php echo($listaItens[$i]['imagem'] == '')? 'display:none;' : ''; ?>" />';
													html += '<input type="button" id="<?php echo $option['nome']; ?>_click" onclick="adicionarImagem(<?php echo $i; ?>);"  class="button button-primary" value="Selecionar imagem" /><br/>';
													
												html += '</p>';
												
												html += '<p style="display:'+((itens.indexOf("titulo") != -1)? 'block': 'none')+';">';
													html += '<label>Título</label><br/>';
													html += '<input type="text" id="<?php echo $option['nome']; ?>_titulo[]" name="<?php echo $option['nome']; ?>_titulo[]" value="" style="width:90%;" />';
												html += '</p>';
												
												
												html += '<p style="display:'+((itens.indexOf("descricao") != -1)? 'block': 'none')+';">';
													html += '<label>Descrição</label><br/>';
													html += '<textarea id="<?php echo $option['nome']; ?>_descricao[]" name="<?php echo $option['nome']; ?>_descricao[]" style="width:90%; height:100px;" />';
												html += '</p>';
												
												html += '<p style="display:'+((itens.indexOf("text1") != -1)? 'block': 'none')+';">';
													html += '<label>Texto1</label><br/>';
													html += '<input type="text" id="<?php echo $option['nome']; ?>_text1[]" name="<?php echo $option['nome']; ?>_text1[]" value="" style="width:90%;" />';
												html += '</p>';
												
												html += '<p style="display:'+((itens.indexOf("text2") != -1)? 'block': 'none')+';">';
													html += '<label>Texto2</label><br/>';
													html += '<input type="text" id="<?php echo $option['nome']; ?>_text2[]" name="<?php echo $option['nome']; ?>_text2[]" value="" style="width:90%;" />';
												html += '</p>';
												
												html += '<p style="display:'+((itens.indexOf("text3") != -1)? 'block': 'none')+';">';
													html += '<label>Texto3</label><br/>';
													html += '<input type="text" id="<?php echo $option['nome']; ?>_text3[]" name="<?php echo $option['nome']; ?>_text3[]" value="" style="width:90%;" />';
												html += '</p>';
												
												
												html += '<p style="display:'+((itens.indexOf("link1") != -1)? 'block': 'none')+';">';
													html += '<label>Link 1</label><br/>';
													html += '<input type="text" id="<?php echo $option['nome']; ?>_link1[]" name="<?php echo $option['nome']; ?>_link1[]" value="" style="width:90%;" />';
												html += '</p>';
												
												
												html += '<p style="display:'+((itens.indexOf("link2") != -1)? 'block': 'none')+';">';
													html += '<label>Link 2</label><br/>';
													html += '<input type="text" id="<?php echo $option['nome']; ?>_link2[]" name="<?php echo $option['nome']; ?>_link2[]" value="" style="width:90%;" />';
												html += '</p>';
												
												
												html += '<p style="display:'+((itens.indexOf("link3") != -1)? 'block': 'none')+';">';
													html += '<label>Link 3</label><br/>';
													html += '<input type="text" id="<?php echo $option['nome']; ?>_link3[]" name="<?php echo $option['nome']; ?>_link3[]" value="" style="width:90%;" />';
												html += '</p>';

												html += '<p style="display:'+((itens.indexOf("textBotao") != -1)? 'block': 'none')+';">';
													html += '<label>Texto Botão</label><br/>';
													html += '<input type="text" id="<?php echo $option['nome']; ?>_textBotao[]" name="<?php echo $option['nome']; ?>_textBotao[]" value="" style="width:90%;" />';
												html += '</p>';
												
												
												html += '<p style="display:'+((itens.indexOf("type_conteudo") != -1)? 'block': 'none')+';">';
													
                                                html += '<label>Listagem de conteúdo</label><br/>';
                                                html += '<select id="<?php echo $option['nome']; ?>_type_conteudo[]" name="<?php echo $option['nome']; ?>_type_conteudo[]" style="width:50%;" onchange="CarregarTaxonomys(<?php echo $i; ?>);" class="<?php echo $option['nome']; ?>_type_conteudo_change_<?php echo $i; ?>">';
                                                	html += '<option value="0">Nenhum</option><?php
													for($ic = 0; $ic < count($listaTipoConteudo); $ic++){
														echo '<option value="'.$listaTipoConteudo[$ic][1].'" '.(($listaTipoConteudo[$ic][1] == $listaItens[$i]['type_conteudo'])? 'selected="selected"' : '').' data-type="'.@$listaTipoConteudo[$ic][2].'">'.$listaTipoConteudo[$ic][0].'</option>';
													}
													?>';
                                                html += '</select>';
                                            html += '</p>';
                                            
                                            
											html += '<p style="display:'+((itens.indexOf("type_conteudo") != -1)? 'block': 'none')+';" class="<?php echo $option['nome']; ?>_taxonomy_<?php echo $i; ?>">';
                                                html += '<label>Tipo da listagem</label><br/>';
                                                html += '<select id="<?php echo $option['nome']; ?>_taxonomy_id_conteudo[]" name="<?php echo $option['nome']; ?>_taxonomy_id_conteudo[]" style="width:50%;">';
                                                	html += '<option value="0">Todos</option><?php
													$taxonomys = get_terms();
													for($ti = 0; $ti < count($taxonomys); $ti++){
														echo '<option value="'.$taxonomys[$ti]->term_id.'" style="'.(($listaItens[$i]['taxonomy_conteudo'] == $taxonomys[$ti]->taxonomy)? 'a': 'display:none;').'" data-type="'.$taxonomys[$ti]->taxonomy.'">'.$taxonomys[$ti]->name.'</option>';
													}
													?>';
                                                html += '</select>';
                                            html += '</p>';
												
												
												html += '<p style="display:'+((itens.indexOf("qtd_showposts") != -1)? 'block': 'none')+';">';
													html += '<label>QTD. itens por página</label><br/>';
													html += '<input type="text" id="<?php echo $option['nome']; ?>_qtd_showposts[]" name="<?php echo $option['nome']; ?>_qtd_showposts[]" style="width:50%;" />';
												html += '</p>';
												
												
												
												html += '<input type="hidden" id="<?php echo $option['nome']; ?>_template[]" name="<?php echo $option['nome']; ?>_template[]" value="'+template+'"  />';
												html += '<input type="hidden" id="<?php echo $option['nome']; ?>_titulo_bloco[]" name="<?php echo $option['nome']; ?>_titulo_bloco[]" value="'+titulo+'"  />';
												html += '<input type="hidden" id="<?php echo $option['nome']; ?>_itens[]" name="<?php echo $option['nome']; ?>_itens[]" value="'+itens+'"  />';
                                            
											html += '<input type="hidden" id="<?php echo $option['nome']; ?>_taxonomy_conteudo[]" name="<?php echo $option['nome']; ?>_itens[]" value="<?php echo $listaItens[$i]['taxonomy_conteudo']; ?>" class="<?php echo $option['nome']; ?>_taxonomy_conteudo_val_"  />';
											html += '</div>';
											html += '<a href="#" class="link">Remover</a>';
										html += '</li>';
										jQuery(".lista_itens_<?php echo $option['nome']; ?>").append(html);
										updateListagem();
									}else{
										alert('Selecione um bloco');
									}
								});
							});
							</script>
                        
                        </td>
					</tr>
					<?php
					}
					
					
				}
			}
		}
		?>
        </table>
        <?php
	}
	
	public function set_meta_box($titulo, $nome, $post_type){
		$this->list_meta_box[] = array('titulo' => $titulo, 'nome' => $nome, 'post_type' => $post_type);
	}
	/* Estrutura para criação de meta box no admin */
	
	
	/* Estrutura para criação de options nas páginas do admim */
	public function save_options(){
		add_action('save_post', array($this,'list_save_options'));
	}
	
	public function list_save_options(){
		global $post;
		if($_POST){
			if($this->list_custom_fields){
				foreach($this->list_custom_fields as $option){
					if($option['tipo'] == 'checkbox'){
						if(isset($_POST[$option['nome']])){
							update_post_meta($post->ID, $option['nome'], $_POST[$option['nome']]);
						}else{
							update_post_meta($post->ID, $option['nome'], array());
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
							update_post_meta($post->ID, $option['nome'], $listaItens);
						}else{
							update_post_meta($post->ID, $option['nome'], array());
						}
					}else
					if($option['tipo'] == 'blocos'){
						if(isset($_POST[$option['nome'].'_template'])){
							$listaItens = array();
							for($i = 0; $i < count($_POST[$option['nome'].'_template']); $i++){
								$listaItens[] = array(
									'imagem' => $_POST[$option['nome'].'_imagem'][$i],
									'titulo' => $_POST[$option['nome'].'_titulo'][$i],
									'text1' => $_POST[$option['nome'].'_text1'][$i],
									'text2' => $_POST[$option['nome'].'_text2'][$i],
									'text3' => $_POST[$option['nome'].'_text3'][$i],
									'descricao' => $_POST[$option['nome'].'_descricao'][$i],
									'link1' => $_POST[$option['nome'].'_link1'][$i],
									'link2' => $_POST[$option['nome'].'_link2'][$i],
									'link3' => $_POST[$option['nome'].'_link3'][$i],
									'textBotao' => $_POST[$option['nome'].'_textBotao'][$i],
									'type_conteudo' => $_POST[$option['nome'].'_type_conteudo'][$i],
									'template' => $_POST[$option['nome'].'_template'][$i],
									'titulo_bloco' => $_POST[$option['nome'].'_titulo_bloco'][$i],
									'qtd_showposts' => $_POST[$option['nome'].'_qtd_showposts'][$i],
									'itens' => $_POST[$option['nome'].'_itens'][$i],
									'taxonomy_id_conteudo' => $_POST[$option['nome'].'_taxonomy_id_conteudo'][$i],
									'taxonomy_conteudo' => $_POST[$option['nome'].'_taxonomy_conteudo'][$i]
								);
							}
							update_post_meta($post->ID, $option['nome'], $listaItens);
						}else{
							update_post_meta($post->ID, $option['nome'], array());
						}
					}else{
						if(isset($_POST[$option['nome']])){
							update_post_meta($post->ID, $option['nome'], $_POST[$option['nome']]);
						}

						if($option['tipo'] == 'maps') {
						    print_r('teste');
                        }
					}
				}
			}
		}
	}
	
	public function list_custom_fields(){
		return $this->list_custom_fields;
	}
	
	public function set_custom_field($label, $nome,$tipo, $lista_itens = null, $meta_box_name, $descricao = "" , $tamanho = 0){
		$this->list_custom_fields[] = array('label' => $label,'nome' => $nome, 'tipo' => $tipo, 'lista_itens' => $lista_itens, 'meta_box_name' => $meta_box_name, 'descricao' => $descricao, 'tamanho' => $tamanho);
	}
	/* Estrutura para criação de options nas páginas do admim */
}

add_action( 'wp_default_scripts', function( $scripts ) {
    if ( ! empty( $scripts->registered['jquery'] ) ) {
        $scripts->registered['jquery']->deps = array_diff( $scripts->registered['jquery']->deps, array( 'jquery-migrate' ) );
    }
} );
?>