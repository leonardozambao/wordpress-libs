<?php
class Custom_Category{
	private $list_custom_fields;
	
	public function __construct(){
		add_filter( 'nav_menu_css_class', array($this,'custom_class_nav'), 10, 2 );
		foreach ( array( 'pre_term_description' ) as $filter ) {
			remove_filter( $filter, 'wp_filter_kses' );
		}
		foreach ( array( 'term_description' ) as $filter ) {
			remove_filter( $filter, 'wp_kses_data' );
		}
		add_action('admin_enqueue_scripts', array($this, 'script_galeria'));
	}
	
	public function custom_class_nav( $classes, $item ){
		if( 'category' == $item->object ){
			$category = get_category( $item->object_id );
			$classes[] = 'menu-' . $category->slug;
		}
		return $classes;
	}
	
	public function script_galeria() {
		if (isset($_GET['taxonomy'])) {
			wp_enqueue_media();
		}
	}
	
	
	/* Estrutura para criação de campos nas categorias */
	public function add_custom_fields($taxonomy){
		add_action( $taxonomy.'_add_form_fields', array($this,'load_custom_fields_add_category'), 10);
		add_action( $taxonomy.'_edit_form_fields', array($this,'load_custom_fields_edit_category'), 10, 2);
	}
	
	public function save_custom_fields($taxonomy){
		add_action( 'created_'.$taxonomy, array($this,'list_save_custom_fields'), 10, 2);	
		add_action( 'edited_'.$taxonomy, array($this,'list_save_custom_fields'), 10, 2);
		add_action( 'delete_'.$taxonomy, array($this,'list_remove_custom_fields'), 10, 2);
		
	}
	
	public function list_save_custom_fields($term_id, $t_id){
		global $post;
		
		if($_POST){
			$taxonomy_name =  $_POST['taxonomy'];
			if($this->list_custom_fields){
				foreach($this->list_custom_fields as $option){
					$option_name = $taxonomy_name.'_custom_'.$option['nome'];
					$option_name_id = $taxonomy_name.'_custom_'.$option['nome'].'_'.$term_id;
														
					if($option['tipo'] == 'checkbox'){
						if (isset($_POST[$option_name])) {	
							update_option( $option_name_id, $_POST[$option_name],'no');
						}else if(isset($_POST[$option_name_id])) {	
							update_option( $option_name_id, $_POST[$option_name_id],'no');
						}else{
							update_option( $option_name_id, array(),'no');
						}
					}else if($option['tipo'] == 'editor'){
						if(isset($_POST[$option_name_id])) {	
							//update_option($option_name_id, htmlentities(stripslashes($_POST[$option_name_id])),'no');
							update_option($option_name_id, $_POST[$option_name_id],'no');
						}else{
							//update_option($option_name_id, htmlentities(stripslashes($_POST[$option_name])),'no');
							update_option($option_name_id, $_POST[$option_name],'no');
						}
					}else{
						if(isset($_POST[$option_name_id])) {		
							update_option( $option_name_id, $_POST[$option_name_id],'no');
						}else{
							update_option( $option_name_id, $_POST[$option_name],'no');
						}
					}
				}
			}
		}
	}
	
	
	public function list_remove_custom_fields($term_id, $t_id){
		$taxonomy_name =  $_GET['taxonomy'];
		global $post;
		if($this->list_custom_fields){
			foreach($this->list_custom_fields as $option){
				$option_name_id = $taxonomy_name.'_custom_'.$option['nome'].'_'.$term_id;
				delete_option( $option_name_id);
			}
		}
	}
	
	public function load_custom_fields_add_category( $taxonomy ) {
		
		$taxonomy_name = $_GET['taxonomy'];
		
		if($this->list_custom_fields){
			foreach($this->list_custom_fields as $option){
		
				if($taxonomy_name == $option['taxonomy']){
					if($option['tipo'] == 'text'){
						
					?>
					<div id="bloco_<?php echo $option['nome']; ?>" class="form-field">
						<label for="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome']; ?>"><?php echo $option['label']; ?></label>
						<input id="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome']; ?>" name="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome']; ?>" type="text" value="<?php echo @$campo[$option['nome']][0]; ?>" />
						<?php if($option['descricao'] != ''){ ?><p class="description"><?php echo $option['descricao'];?></p><?php } ?>
					</div>
					<?php
					}
					
					if($option['tipo'] == 'password'){
					?>
					<div id="bloco_<?php echo $option['nome']; ?>" class="form-field">
						<label for="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome']; ?>"><?php echo $option['label']; ?></label>
						<input id="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome']; ?>" name="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome']; ?>" type="password" value="<?php echo @$campo[$option['nome']][0]; ?>" />
						<?php if($option['descricao'] != ''){ ?><p class="description"><?php echo $option['descricao'];?></p><?php } ?>
					</div>
					<?php
					}
					
					if($option['tipo'] == 'textarea'){
					?>
					<div id="bloco_<?php echo $option['nome']; ?>" class="form-field">
						<label for="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome']; ?>"><?php echo $option['label']; ?></label>
						<textarea name="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome']; ?>" type="text" id="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome']; ?>" style="width:70%; height:150px;" class="regular-text"><?php echo @$campo[$option['nome']][0]; ?></textarea>
						<?php if($option['descricao'] != ''){ ?><p class="description"><?php echo $option['descricao'];?></p><?php } ?>
					</div>
					<?php
					}
					
					if($option['tipo'] == 'select'){
					?>
					<div id="bloco_<?php echo $option['nome']; ?>" class="form-field">
						<label for="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome']; ?>"><?php echo $option['label']; ?></label>
						<select name="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome']; ?>" id="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome']; ?>">
							<?php
							foreach($option['lista_itens'] as $item){
								?>
								<option value="<?php echo $item['valor']; ?>"><?php echo $item['text']; ?></option>
								<?php
							}
							?>
						</select>
						<?php if($option['descricao'] != ''){ ?><p class="description"><?php echo $option['descricao'];?></p><?php } ?>
					</div>
					<?php
					}
					
					if($option['tipo'] == 'radio'){
					?>
					<div id="bloco_<?php echo $option['nome']; ?>" class="form-field">
						<label for="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome']; ?>"><?php echo $option['label']; ?></label>
						<?php
						if($option['lista_itens']){
							$contador = 0;
							foreach($option['lista_itens'] as $item){
								?>
								<label style="margin-right:10px;"><input type="radio" name="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome']; ?>" id="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome'].'_'.$contador; ?>" value="<?php echo $item['valor']; ?>" /><?php echo $item['text']; ?></label>
								<?php
								$contador++;
							}
						}else{
							?>
							<input type="radio" name="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome']; ?>" id="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome']; ?>" />
							<?php
						}
						?>
						<?php if($option['descricao'] != ''){ ?><p class="description"><?php echo $option['descricao'];?></p><?php } ?>
					</div>
					<?php
					}
					
					if($option['tipo'] == 'checkbox'){
					?>
					<div id="bloco_<?php echo $option['nome']; ?>" class="form-field">
						<label for="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome']; ?>"><?php echo $option['label']; ?></label>
						<?php
						if($option['lista_itens']){
							$contador = 0;
							foreach($option['lista_itens'] as $item){
								?>
								<label style="margin-right:10px;"><input type="checkbox" name="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome']; ?>[]" id="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome'].'_'.$contador; ?>" value="<?php echo $item['valor']; ?>" /><?php echo $item['text']; ?></label>
								<?php
								$contador++;
							}
						}else{
							?>
							<input type="checkbox" name="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome']; ?>" id="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome']; ?>" />
							<?php
						}
						?>
						<?php if($option['descricao'] != ''){ ?><p class="description"><?php echo $option['descricao'];?></p><?php } ?>
					</div>
					<?php
					}
					
					if($option['tipo'] == 'imagem'){
						
					?>
					<div id="bloco_<?php echo $option['nome']; ?>" class="form-field">
						<label for="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome']; ?>"><?php echo $option['label']; ?></label>
						
						<input type="hidden" id="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome']; ?>" size="60" name="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome']; ?>" value="<?php echo @get_option($taxonomy_name.'_'.$option['nome']); ?>" />
						<?php if(@get_option($taxonomy_name.'_custom_'.$option['nome']) != ''){
							echo wp_get_attachment_image(@get_option($taxonomy_name.'_custom_'.$option['nome']), 'thumb_375x375', '', array('id' => $taxonomy_name.'_custom_'.$option['nome'].'_img', 'name' => $taxonomy_name.'_custom_'.$option['nome'].'_img','style' => 'background:#CCC; width:200px; height:auto;')).'<br/>';
						}else{
						?>
						<img id="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome']; ?>_img" name="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome']; ?>_img" style="display:none; background:#CCC; width:<?php echo $option['tamanho']; ?>px; height:auto;" /><br/>
						<?php }?>
						<input type="button" id="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome']; ?>_remover"  class="button button-primary" value="Remover imagem" style=" <?php echo(@$campo[$option['nome']][0] == '')? 'display:none;' : ''; ?>" />
						<input type="button" id="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome']; ?>_click"  class="button button-primary" value="Selecionar imagem" /><br/>
						<?php if($option['descricao'] != ''){ ?><p class="description"><?php echo $option['descricao'];?></p><?php } ?>
						<script type="text/javascript">
						jQuery(document).ready(function($){
							var <?php echo $taxonomy_name.'_custom_'.$option['nome']; ?>;
							$('#<?php echo $taxonomy_name.'_custom_'.$option['nome']; ?>_click').click(function(e) {
								e.preventDefault();
								if (<?php echo $taxonomy_name.'_custom_'.$option['nome']; ?>) {
									<?php echo $taxonomy_name.'_custom_'.$option['nome']; ?>.open();
									return;
								}
								<?php echo $taxonomy_name.'_custom_'.$option['nome']; ?> = wp.media.frames.file_frame = wp.media({
									title: 'Selecionar imagem',
									button: {
										text: 'Inserir imagem selecionada'
									},
									multiple: false
								});
								<?php echo $taxonomy_name.'_custom_'.$option['nome']; ?>.on('select', function() {
									attachment = <?php echo $taxonomy_name.'_custom_'.$option['nome']; ?>.state().get('selection').first().toJSON();
									$('#<?php echo $taxonomy_name.'_custom_'.$option['nome']; ?>').val(attachment.id);
									$("#<?php echo $taxonomy_name.'_custom_'.$option['nome']; ?>_img").fadeOut(function(){$(this).attr('src',attachment.url).fadeIn()});
									$('#<?php echo $taxonomy_name.'_custom_'.$option['nome']; ?>_remover').show();
								});
								<?php echo $taxonomy_name.'_custom_'.$option['nome']; ?>.open();
							});
							$('#<?php echo $taxonomy_name.'_custom_'.$option['nome']; ?>_remover').click(function(e) {
								$(this).hide();
								$('#<?php echo $taxonomy_name.'_custom_'.$option['nome']; ?>').val('');
								$("#<?php echo $taxonomy_name.'_custom_'.$option['nome']; ?>_img").fadeOut(function(){$(this).attr('src','');});
							});
						});
						</script>
					</div>
					<?php
					}
					if($option['tipo'] == 'cor'){
					?>
					<tr id="bloco_<?php echo $option['nome']; ?>" class="form-field">
					  <th scope="row" valign="top"><label for="<?php echo $taxonomy_name.'_custom_'.$option['nome']; ?>"><?php echo $option['label']; ?></label></th>
					  <td>
						<link rel="Stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/lib/css/colorpicker.css" />
						<script src="<?php bloginfo('template_directory'); ?>/lib/js/jquery-1.11.2.min.js" type="text/javascript"></script>
						<script src="<?php bloginfo('template_directory'); ?>/lib/js/colorpicker.js" type="text/javascript"></script>
						<script type="text/javascript">        
						$(document).ready(function(){
							var corInicial = '0,0,0';
							corInicial = corInicial.split(',');
							console.log({r:corInicial[0], g:corInicial[1], b:corInicial[2]});
							$('#<?php echo $taxonomy_name.'_custom_'.$option['nome']; ?>_css').ColorPicker({
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
									$('#<?php echo $taxonomy_name.'_custom_'.$option['nome']; ?>').val(rgb.r + ',' + rgb.g + ',' + rgb.b);
									$('#<?php echo $taxonomy_name.'_custom_'.$option['nome']; ?>_css').css({'background': 'rgb(' + rgb.r + ',' + rgb.g + ',' + rgb.b + ')'});
								}
							});
						});
						</script>
						<input id="<?php echo $taxonomy_name.'_custom_'.$option['nome']; ?>" name="<?php echo $taxonomy_name.'_custom_'.$option['nome']; ?>" type="hidden" value="0,0,0" />
						<div id="<?php echo $taxonomy_name.'_custom_'.$option['nome']; ?>_css" style="width:20px; height:20px; background: rgb(0,0,0);"></div>
						<?php if($option['descricao'] != ''){ ?><p class="description"><?php echo $option['descricao'];?></p><?php } ?>
					  </td>
					</tr>
					<?php
					}
					if($option['tipo'] == 'editor'){
					?>
					<tr id="bloco_<?php echo $option['nome']; ?>" class="form-field">
					  <th scope="row" valign="top"><label for="<?php echo $taxonomy_name.'_custom_'.$option['nome']; ?>"><?php echo $option['label']; ?></label></th>
					  <td>
						<?php wp_editor('', $taxonomy_name.'_custom_'.$option['nome'] , $settings = array( 'textarea_name' => $taxonomy_name.'_custom_'.$option['nome'])); ?>
						<?php if($option['descricao'] != ''){ ?><p class="description"><?php echo $option['descricao'];?></p><?php } ?>
					  </td>
					</tr>
					<script type="text/javascript">
					jQuery(document).ready( function() {
						jQuery('#submit').mousedown( function() {
							tinyMCE.triggerSave();
						}); 
					});
					</script>
					<?php
					}
				}
			}
		}
	}
	
	function load_custom_fields_edit_category( $tag, $taxonomy ) {
		$taxonomy_name =  $_GET['taxonomy'];
		if($this->list_custom_fields){
			foreach($this->list_custom_fields as $option){
				if($taxonomy_name == $option['taxonomy']){
					if($option['tipo'] == 'text'){
					?>
					<tr id="bloco_<?php echo $option['nome']; ?>" class="form-field">
						<th scope="row" valign="top"><label for="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome'].'_'.$tag->term_id; ?>"><?php echo $option['label']; ?></label></th>
						<td>
						<input id="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome'].'_'.$tag->term_id; ?>" name="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome'].'_'.$tag->term_id; ?>" type="text" value="<?php echo @get_option($taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id); ?>" />
						<?php if($option['descricao'] != ''){ ?><p class="description"><?php echo $option['descricao'];?></p><?php } ?>
						</td>
					</tr>
					<?php
					}
					
					if($option['tipo'] == 'password'){
					?>
					<tr id="bloco_<?php echo $option['nome']; ?>" class="form-field">
						<th scope="row" valign="top"><label for="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome'].'_'.$tag->term_id; ?>"><?php echo $option['label']; ?></label></th>
						<td>
						<input id="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome'].'_'.$tag->term_id; ?>" name="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome'].'_'.$tag->term_id; ?>" type="password" value="<?php echo @get_option($taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id); ?>" />
						<?php if($option['descricao'] != ''){ ?><p class="description"><?php echo $option['descricao'];?></p><?php } ?>
						</td>
					</tr>
					<?php
					}
					
					if($option['tipo'] == 'textarea'){
					?>
					<tr id="bloco_<?php echo $option['nome']; ?>" class="form-field">
						<th scope="row" valign="top"><label for="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome'].'_'.$tag->term_id; ?>"><?php echo $option['label']; ?></label></th>
						<td>
						<textarea name="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome'].'_'.$tag->term_id; ?>" type="text" id="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome'].'_'.$tag->term_id; ?>" style="width:70%; height:150px;" class="regular-text"><?php echo @get_option($taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id); ?></textarea>
						<?php if($option['descricao'] != ''){ ?><p class="description"><?php echo $option['descricao'];?></p><?php } ?>
						</td>
					</tr>
					<?php
					}
					
					if($option['tipo'] == 'select'){
					?>
					<tr id="bloco_<?php echo $option['nome']; ?>" class="form-field">
						<th scope="row" valign="top"><label for="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome'].'_'.$tag->term_id; ?>"><?php echo $option['label']; ?></label></th>
						<td>
						<select name="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome'].'_'.$tag->term_id; ?>" id="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome'].'_'.$tag->term_id; ?>">
							<?php
							foreach($option['lista_itens'] as $item){
								?>
								<option value="<?php echo $item['valor']; ?>" <?php echo((@get_option($taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id)) == $item['valor'])? 'selected="selected"' : ''; ?>><?php echo $item['text']; ?></option>
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
					<tr id="bloco_<?php echo $option['nome']; ?>" class="form-field">
						<th scope="row" valign="top"><label for="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome'].'_'.$tag->term_id; ?>"><?php echo $option['label']; ?></label></th>
						<td>
						<?php
						if($option['lista_itens']){
							$contador = 0;
							foreach($option['lista_itens'] as $item){
								?>
								<label style="margin-right:10px;"><input type="radio" name="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome'].'_'.$tag->term_id; ?>" id="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome'].'_'.$tag->term_id.'_'.$contador; ?>" value="<?php echo $item['valor']; ?>" <?php echo((@get_option($taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id)) == $item['valor'])? 'checked="checked"' : ''; ?>  /><?php echo $item['text']; ?></label>
								<?php
								$contador++;
							}
						}else{
							?>
							<input type="radio" name="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome'].'_'.$tag->term_id; ?>" id="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome'].'_'.$tag->term_id; ?>" />
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
					<tr id="bloco_<?php echo $option['nome']; ?>" class="form-field">
						<th scope="row" valign="top"><label for="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome'].'_'.$tag->term_id; ?>"><?php echo $option['label']; ?></label></th>
						<td>
						<?php
						if($option['lista_itens']){
							$contador = 0;
							foreach($option['lista_itens'] as $item){
								?>
								<label style="margin-right:10px;"><input type="checkbox" name="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome'].'_'.$tag->term_id; ?>[]" id="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome'].'_'.$tag->term_id.'_'.$contador; ?>" value="<?php echo $item['valor']; ?>" <?php echo(@in_array($item['valor'],(@get_option($taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id))))? 'checked="checked"' : ''; ?> /><?php echo $item['text']; ?></label>
								<?php
								$contador++;
							}
						}else{
							?>
							<input type="checkbox" name="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome'].'_'.$tag->term_id; ?>" id="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome'].'_'.$tag->term_id; ?>" />
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
					<tr id="bloco_<?php echo $option['nome']; ?>" class="form-field">
						<th scope="row" valign="top"><label for="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome'].'_'.$tag->term_id; ?>"><?php echo $option['label']; ?></label></th>
						<td>
						
						<input type="hidden" id="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome'].'_'.$tag->term_id; ?>" size="60" name="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome'].'_'.$tag->term_id; ?>" value="<?php echo @get_option($taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id); ?>" />
						<?php if(@get_option($taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id) != ''){
							echo wp_get_attachment_image(@get_option($taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id), 'thumb_375x375', '', array('id' => $taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id.'_img', 'name' => $taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id.'_img','style' => 'background:#CCC; width:'.$option['tamanho'].'px; height:auto;')).'<br/>';
						}else{
						?>
						<img id="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome'].'_'.$tag->term_id; ?>_img" name="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome'].'_'.$tag->term_id; ?>_img" style="display:none; background:#CCC; width:<?php echo $option['tamanho']; ?>px; height:auto;" /><br/>
						<?php }?>
						<input type="button" id="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome'].'_'.$tag->term_id; ?>_remover"  class="button button-primary" value="Remover imagem" style=" <?php echo(@get_option($taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id) == '')? 'display:none;' : ''; ?>" />
						<input type="button" id="<?php echo $taxonomy_name; ?>_custom_<?php echo $option['nome'].'_'.$tag->term_id; ?>_click"  class="button button-primary" value="Selecionar imagem" /><br/>
						<?php if($option['descricao'] != ''){ ?><p class="description"><?php echo $option['descricao'];?></p><?php } ?>
						
						<script type="text/javascript">
						jQuery(document).ready(function($){
							var <?php echo $taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id; ?>;
							$('#<?php echo $taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id; ?>_click').click(function(e) {
								e.preventDefault();
								if (<?php echo $taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id; ?>) {
									<?php echo $taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id; ?>.open();
									return;
								}
								<?php echo $taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id; ?> = wp.media.frames.file_frame = wp.media({
									title: 'Selecionar imagem',
									button: {
										text: 'Inserir imagem selecionada'
									},
									multiple: false
								});
								<?php echo $taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id; ?>.on('select', function() {
									attachment = <?php echo $taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id; ?>.state().get('selection').first().toJSON();
									$('#<?php echo $taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id; ?>').val(attachment.id);
									$("#<?php echo $taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id; ?>_img").fadeOut(function(){$(this).attr('src',attachment.url).fadeIn()});
									$('#<?php echo $taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id; ?>_remover').show();
								});
								<?php echo $taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id; ?>.open();
							});
							$('#<?php echo $taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id; ?>_remover').click(function(e) {
								$(this).hide();
								$('#<?php echo $taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id; ?>').val('');
								$("#<?php echo $taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id; ?>_img").fadeOut(function(){$(this).attr('src','');});
							});
						});
						</script>
						</td>
					</tr>
					<?php
					}
					if($option['tipo'] == 'cor'){
					?>
					<tr id="bloco_<?php echo $option['nome']; ?>" class="form-field">
					  <th scope="row" valign="top"><label for="<?php echo $taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id; ?>"><?php echo $option['label']; ?></label></th>
					  <td>
						<link rel="Stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/lib/css/colorpicker.css" />
						<script src="<?php bloginfo('template_directory'); ?>/lib/js/jquery-1.11.2.min.js" type="text/javascript"></script>
						<script src="<?php bloginfo('template_directory'); ?>/lib/js/colorpicker.js" type="text/javascript"></script>
						<script type="text/javascript">        
						$(document).ready(function(){
							var corInicial = '<?php echo (get_option($taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id) != "")? get_option($taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id) : '0,0,0'; ?>';
							corInicial = corInicial.split(',');
							console.log({r:corInicial[0], g:corInicial[1], b:corInicial[2]});
							$('#<?php echo $taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id; ?>_css').ColorPicker({
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
									$('#<?php echo $taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id; ?>').val(rgb.r + ',' + rgb.g + ',' + rgb.b);
									$('#<?php echo $taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id; ?>_css').css({'background': 'rgb(' + rgb.r + ',' + rgb.g + ',' + rgb.b + ')'});
								}
							});
						});
						</script>
						<input id="<?php echo $taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id; ?>" name="<?php echo $taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id; ?>" type="hidden" value="<?php echo (get_option($taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id) != "")? get_option($taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id) : '0,0,0'; ?>" />
						<div id="<?php echo $taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id; ?>_css" style="width:20px; height:20px; background: rgb(<?php echo (get_option($taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id) != "")? get_option($taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id) : '0,0,0'; ?>);"></div>
						<?php if($option['descricao'] != ''){ ?><p class="description"><?php echo $option['descricao'];?></p><?php } ?>
					  </td>
					</tr>
					<?php
					}
					if($option['tipo'] == 'editor'){
					?>
					<tr id="bloco_<?php echo $option['nome']; ?>" class="form-field">
					  <th scope="row" valign="top"><label for="<?php echo $taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id; ?>"><?php echo $option['label']; ?></label></th>
					  <td>
							<?php wp_editor(htmlspecialchars_decode(get_option($taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id)), $taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id, $settings = array('textarea_name'=> $taxonomy_name.'_custom_'.$option['nome'].'_'.$tag->term_id)); ?>
							<?php if($option['descricao'] != ''){ ?><p class="description"><?php echo $option['descricao'];?></p><?php } ?>
					  </td>
					</tr>
					<?php
					}
				}
			}
		}
	}
	
	public function list_custom_fields($tag, $taxonomy){
		return $this->list_custom_fields;
	}
	
	public function set_custom_field($label, $nome,$tipo, $lista_itens = null, $taxonomy, $descricao = "" , $tamanho = 0){
		$this->list_custom_fields[] = array('label' => $label,'nome' => $nome, 'tipo' => $tipo, 'lista_itens' => $lista_itens, 'descricao' => $descricao, 'tamanho' => $tamanho, 'taxonomy' => $taxonomy);
	}
	/* Estrutura para criação de campos nas categorias */
	
}

function get_field_taxonomy($taxonomy, $term_id, $field){
	$option_name = $taxonomy.'_custom_'.$field.'_'.$term_id;
	$option_value = get_option($option_name);
	return $option_value;
}
?>