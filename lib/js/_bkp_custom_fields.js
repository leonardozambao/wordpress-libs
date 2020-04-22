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
		jQuery("#bloco_arquivo_download").show();
		jQuery("#bloco_link_video").hide();
		jQuery("#bloco_link_tutorial").hide();
		alert('video');
	}else{
		jQuery("#bloco_restrito").hide();
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
			jQuery("#bloco_arquivo_download").show();
			jQuery("#bloco_link_video").hide();
			jQuery("#bloco_link_tutorial").hide();
		}else{
			jQuery("#bloco_restrito").hide();
			jQuery("#bloco_arquivo_download").hide();
			jQuery("#bloco_link_video").show();
			jQuery("#bloco_link_tutorial").show();
		}
    });
	/* Campos Bibliotecas */
	
});