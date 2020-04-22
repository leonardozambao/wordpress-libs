jQuery(document).ready(function(e) {
	/* Campos página configurações de formulários */
	if(jQuery("input[name='envio_email_atutenticado']:checked").val() == 'sim'){
		jQuery("#bloco_servidor_smtp").show();
		jQuery("#bloco_porta_smtp").show();
		jQuery("#bloco_usuario_smtp").show();
		jQuery("#bloco_senha_smtp").show();
	}else{
		jQuery("#bloco_servidor_smtp").hide();
		jQuery("#bloco_porta_smtp").hide();
		jQuery("#bloco_usuario_smtp").hide();
		jQuery("#bloco_senha_smtp").hide();
	}
    jQuery("input[name='envio_email_atutenticado']").click(function(e) {
        if(jQuery(this).val() == 'sim'){
			jQuery("#bloco_servidor_smtp").show();
			jQuery("#bloco_porta_smtp").show();
			jQuery("#bloco_usuario_smtp").show();
			jQuery("#bloco_senha_smtp").show();
		}else{
			jQuery("#bloco_servidor_smtp").hide();
			jQuery("#bloco_porta_smtp").hide();
			jQuery("#bloco_usuario_smtp").hide();
			jQuery("#bloco_senha_smtp").hide();
		}
    });
	/* Campos página configurações de formulários */
	
	
	/* Campos página configurações de formulários */
	if(jQuery("input[name='tipo_post']:checked").val() == 'citacao'){
		jQuery("#bloco_citacao").show();
	}else{
		jQuery("#bloco_citacao").hide();
	}
    jQuery("input[name='tipo_post']").click(function(e) {
        if(jQuery(this).val() == 'citacao'){
			jQuery("#bloco_citacao").show();
		}else{
			jQuery("#bloco_citacao").hide();
		}
    });
	/* Campos página configurações de formulários */
	
	
	/* Campos página configurações de formulários */
	if(!jQuery("input[name='status_oferta']:checked").length){
		jQuery("#status_oferta_0").attr('checked','checked');
	}
	/* Campos página configurações de formulários */
	
	
	/* Campos Bibliotecas */
	if(!jQuery("input[name='restrito']:checked").length){
		jQuery("#restrito_0").attr('checked','checked');
	}
	
	if(!jQuery("input[name='tipo']:checked").length){
		jQuery("#tipo_0").attr('checked','checked');
	}
	
	if(jQuery("input[name='tipo']:checked").val() == 'arquivo'){
		jQuery("#bloco_restrito").show();
		jQuery("#bloco_arquivo_download").show();
		jQuery("#bloco_link_video").hide();
		jQuery("#bloco_link_tutorial").hide();
	}else
	if(jQuery("input[name='tipo']:checked").val() == 'video'){
		jQuery("#bloco_restrito").show();
		jQuery("#bloco_arquivo_download").hide();
		jQuery("#bloco_link_video").show();
		jQuery("#bloco_link_tutorial").hide();
	}else
	if(jQuery("input[name='tipo']:checked").val() == 'link'){
		jQuery("#bloco_restrito").show();
		jQuery("#bloco_arquivo_download").hide();
		jQuery("#bloco_link_video").hide();
		jQuery("#bloco_link_tutorial").show();
	}
    jQuery("input[name='tipo']").click(function(e) {
        if(jQuery(this).val() == 'arquivo'){
			jQuery("#bloco_restrito").show();
			jQuery("#bloco_arquivo_download").show();
			jQuery("#bloco_link_video").hide();
			jQuery("#bloco_link_tutorial").hide();
		}else
		if(jQuery(this).val() == 'video'){
			jQuery("#bloco_restrito").show();
			jQuery("#bloco_arquivo_download").hide();
			jQuery("#bloco_link_video").show();
			jQuery("#bloco_link_tutorial").hide();
		}else
		if(jQuery(this).val() == 'link'){
			jQuery("#bloco_restrito").show();
			jQuery("#bloco_arquivo_download").hide();
			jQuery("#bloco_link_video").hide();
			jQuery("#bloco_link_tutorial").show();
		}
    });
	
	
	/* Campos Posts Investimentos */
	if(!jQuery("input[name='bt_saiba_mais']:checked").length){
		jQuery("#bt_saiba_mais_0").attr('checked','checked');
	}
	if(!jQuery("input[name='bt_invista_ja']:checked").length){
		jQuery("#bt_invista_ja_0").attr('checked','checked');
	}
	
	/* Campos Bibliotecas */
	
	if(jQuery("#estado_escritorio").length && jQuery("#estado_escritorio").val() != ''){
        var ID_estado = jQuery("#estado_escritorio").val();
		jQuery.ajax({
			type: "POST",
			url: window.location.href,
			data: {
				request_json : true,
				estado_escritorio : ID_estado
			},
			success: function(dados) {
				var obj = jQuery.parseJSON(dados);
				var options_sel = '<option value="">Selecione</option>';
				jQuery.each(obj, function( key, value ) {
					if(value.id == jQuery("#cidade_escritorio_temp").val())
						options_sel += '<option value="'+value.id+'" selected="selected">'+value.nome+'</option>';
					else
						options_sel += '<option value="'+value.id+'">'+value.nome+'</option>';
				});
				jQuery("#cidade_escritorio").html(options_sel);
			}
		});
	}
	
	jQuery("#estado_escritorio").change(function(e) {
        var ID_estado = jQuery(this).val();
		jQuery.ajax({
			type: "POST",
			url: window.location.href,
			data: {
				request_json : true,
				estado_escritorio : ID_estado
			},
			success: function(dados) {
				var obj = jQuery.parseJSON(dados);
				var options_sel = '<option value="">Selecione</option>';
				jQuery.each(obj, function( key, value ) {
					options_sel += '<option value="'+value.id+'">'+value.nome+'</option>';
				});
				jQuery("#cidade_escritorio").html(options_sel);
			}
		});
    });
	
});