<?php


class Taxonomy
{

    public $fields = array();

    public function addField($label, $nome, $tipo, $descricao = null, $taxonomy) {
        if(count($this->fields[$taxonomy]) == 0) {
            $this->fields[$taxonomy] = array();
        }
        $this->fields[$taxonomy][] = array(
            'label' => $label,
            'nome' => $nome,
            'tipo' => $tipo,
            'descricao' => $descricao,
        );


    }

    public function RegisterFields() {
        foreach ($this->fields as $key => $tax) {
            $functionName = $key.'_add_fields';
            $functionEditName = $key.'_edit_fields';

            ${$functionEditName} = function ($term_id) use ($tax, $key) {
                foreach($tax as $field ) {
                    print_r($this->fields[$key]['campos']);
                    if ( isset( $_POST[$field['nome']] ) ) {
                        $term_field = $_POST[$field['nome']];
                        if( $term_field ) {
                            update_term_meta( $term_id, $field['nome'], $term_field);
                        }
                    }
                }
            };


            ${$functionName} = function ($term) use ($tax) {
                $term_id = $_GET['tag_ID'];
                foreach($tax as $field ) {
                    $campos[$field['nome']] = get_term_meta( $term_id, $field['nome']);
                    $this->ItensHTML($field, $campos);
                }
            };




            add_action( $key.'_add_form_fields', ${$functionName}, 10, 2 );
            add_action( $key.'_edit_form_fields', ${$functionName}, 10, 2 );
            add_action( 'edited_'.$key, ${$functionEditName});
            add_action( 'create_'.$key, ${$functionEditName});
        }
    }

    public function ItensHTML($option, $campo) {
        ?> <div class="form-field" style="margin-bottom: 20px"> <?php
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
        ?>
        </div>
        <?php
    }

}