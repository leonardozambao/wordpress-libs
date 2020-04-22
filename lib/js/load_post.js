function LoadBuscaClick(termo){
	
	$('.loader').show();
	$('.vermaisMobile').hide();
	
	$.get(URL_THEME+"/load_post_busca.php?termo="+termo+"&pagina="+PAGINA_ATUAL, function(data){
		if(data){
			$(".listagemNoticias").append(data);
			//$('.loader').hide();
			//$('.vermaisMobile').show();
		}else{
			$('.loader').remove();
			$('.vermaisMobile').remove();
		}
		PAGINA_ATUAL++;
		loadClickVideo();
		$.get(URL_THEME+"/load_post_busca.php?termo="+termo+"&pagina="+PAGINA_ATUAL, function(data){
			if(data == ""){
				$('.loader').hide();
				$('.vermaisMobile').remove();
			}else{
				$('.loader').hide();
				$('.vermaisMobile').show();
			}
		});
	}).fail(function(xhr, ajaxOptions, thrownError) {
		alert(thrownError);
		//$('.loader').hide();
		$('.vermaisMobile').show();
	});
				
}





function LoadBusca(termo){
    var pagina_load = 2;
    var loading  = false;
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() == $(document).height()){
            if(loading==false){
                loading = true;
                $('.loader').show();
				
                $.get(URL_THEME+"/load_post_busca.php?termo="+termo+"&pagina="+pagina_load, function(data){
					if(data){
						$(".listagemNoticias").append(data);
						//$('.loader').hide();
					}else{
						$('.loader').remove();
					}
                    pagina_load++;
                    loading = false; 
					loadClickVideo();
					$.get(URL_THEME+"/load_post_busca.php?termo="+termo+"&pagina="+pagina_load, function(data){
						if(data == ""){
							$('.loader').hide();
							$('.vermaisMobile').remove();
						}else{
							$('.loader').hide();
							$('.vermaisMobile').show();
						}
					});
                }).fail(function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                    //$('.loader').hide();
                    loading = false;
                });
            }
        }
    });
}







function loadClickVideo(){
	jQuery(".listagem li .video a").click(function(){
		jQuery(this).hide();
		jQuery(".video_url",jQuery(this).parent()).show();
		return false;
	});
}
function Load_Noticas_Relacionadas(id_elemento,url,pagina){
	var page = "";
	if(url.indexOf("?") >= 0)
		page ='&pagina=';
	else
		page ='?pagina=';
		
	$.get(url+page+pagina, function(data){ 
		if($(data).find(id_elemento+" li").length){
			$(data).find(id_elemento+" li").appendTo(id_elemento);
			pagina++;
			jQuery(".ultimasNoticias .btVerMais.loadNotRelec").attr('href','javascript:Load_Noticas_Relacionadas(\''+id_elemento+'\', \''+url+'\','+pagina+');');
			jQuery(".boxInterna .colRight .btVerMaisNot.loadNotRelec").attr('href','javascript:Load_Noticas_Relacionadas(\''+id_elemento+'\', \''+url+'\','+pagina+');');
			
		}else{
			jQuery(".ultimasNoticias .btVerMais.loadNotRelec").hide();
			jQuery(".boxInterna .colRight .btVerMaisNot.loadNotRelec").hide();
		}
	});
}
function Load_Conteudo_Relacionadas(id_relacioados,id_maislidos,url,pagina){
	var page = "";
	if(url.indexOf("?") >= 0)
		page ='&pagina=';
	else
		page ='?pagina=';
		
	$.get(url+page+pagina, function(data){ 
		if($(data).find(id_relacioados+" li").length || $(data).find(id_maislidos+" li").length){
			$(data).find(id_relacioados+" li").appendTo(id_relacioados);
			$(data).find(id_maislidos+" li").appendTo(id_maislidos);
			pagina++;
			jQuery(".ultimasNoticias .btVerMais.contRelacionado").attr('href','javascript:Load_Conteudo_Relacionadas(\''+id_relacioados+'\',\''+id_maislidos+'\', \''+url+'\','+pagina+');');
			jQuery(".boxInterna .colRight .btVerMaisNot.contRelacionado").attr('href','javascript:Load_Conteudo_Relacionadas(\''+id_relacioados+'\',\''+id_maislidos+'\', \''+url+'\','+pagina+');');
			
		}else{
			jQuery(".ultimasNoticias .btVerMais.contRelacionado").hide();
			jQuery(".boxInterna .colRight .btVerMaisNot.contRelacionado").hide();
		}
	});
}


function LoadHome(){
    var pagina_load = 2;
    var loading  = false;
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() == $(document).height()){
            if(loading==false){
                loading = true;
                $('.loader').show();
				
                $.get(URL_THEME+"/load_post_home.php?pagina="+pagina_load, function(data){
					if(data){
						$(".listagem").append(data);
						//$('.loader').hide();
					}else{
						//$('.loader').hide();
					}
					if(data.indexOf("<li") < 1){
						//$('.loader').remove();
					}
                    pagina_load++;
                    loading = false; 
					loadClickVideo();
					$.get(URL_THEME+"/load_post_home.php?pagina="+pagina_load, function(data){
						if(data == ""){
							$('.loader').hide();
							$('.vermaisMobile').remove();
						}else{
							$('.loader').hide();
							$('.vermaisMobile').show();
						}
					});
                }).fail(function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                    $('.loader').hide();
                    loading = false;
                });
            }
        }
    });
}

function LoadHomeClick(){
	
	$('.loader').show();
	$('.vermaisMobile').hide();
	$.get(URL_THEME+"/load_post_home.php?pagina="+PAGINA_ATUAL, function(data){
		if(data != ""){
			$(".listagem").append(data);
			//$('.loader').hide();
			//$('.vermaisMobile').show();
		}else{
			$('.loader').remove();
			$('.vermaisMobile').remove();
		}
		PAGINA_ATUAL++;
		loadClickVideo();
		$.get(URL_THEME+"/load_post_home.php?pagina="+PAGINA_ATUAL, function(data){
			if(data == ""){
				$('.loader').hide();
				$('.vermaisMobile').remove();
			}else{
				$('.loader').hide();
				$('.vermaisMobile').show();
			}
		});
	}).fail(function(xhr, ajaxOptions, thrownError) {
		alert(thrownError);
		//$('.loader').hide();
		$('.vermaisMobile').show();
	});	
}

function LoadCategoria(id_categoria){
    var pagina_load = 2;
    var loading  = false;
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() == $(document).height()){
            if(loading==false){
                loading = true;
                $('.loader').show();
				
                $.get(URL_THEME+"/load_post_cat.php?id_categoria="+id_categoria+"&pagina="+pagina_load, function(data){
					if(data){
						$(".listagem").append(data);
						//$('.loader').hide();
					}else{
						$('.loader').hide();
						$('.loader').remove();
					}
                    pagina_load++;
                    loading = false; 
					loadClickVideo();
					$.get(URL_THEME+"/load_post_cat.php?id_categoria="+id_categoria+"&pagina="+pagina_load, function(data){
						if(data == ""){
							$('.loader').hide();
							$('.vermaisMobile').remove();
						}else{
							$('.loader').hide();
							$('.vermaisMobile').show();
						}
					});
                }).fail(function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                    //$('.loader').hide();
                    loading = false;
                });
            }
        }
    });
}

function LoadCategoriaClick(id_categoria){
	
	$('.loader').show();
	$('.vermaisMobile').hide();
	
	$.get(URL_THEME+"/load_post_cat.php?id_categoria="+id_categoria+"&pagina="+PAGINA_ATUAL, function(data){
		if(data){
			$(".listagem").append(data);
			//$('.loader').hide();
			//$('.vermaisMobile').show();
		}else{
			$('.loader').remove();
			$('.vermaisMobile').remove();
		}
		PAGINA_ATUAL++;
		loadClickVideo();
		$.get(URL_THEME+"/load_post_cat.php?id_categoria="+id_categoria+"&pagina="+PAGINA_ATUAL, function(data){
			if(data == ""){
				$('.loader').hide();
				$('.vermaisMobile').remove();
			}else{
				$('.loader').hide();
				$('.vermaisMobile').show();
			}
		});
	}).fail(function(xhr, ajaxOptions, thrownError) {
		alert(thrownError);
		$('.loader').hide();
		$('.vermaisMobile').show();
	});
}


function LoadNoticias(id_categoria){
    var pagina_load = 2;
    var loading  = false;
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() == $(document).height()){
            if(loading==false){
                loading = true;
                $('.loader').show();
				
                $.get(URL_THEME+"/load_post_not.php?id_categoria="+id_categoria+"&pagina="+pagina_load, function(data){
					if(data){
						$(".listagemNoticias").append(data);
						//$('.loader').hide();
					}else{
						$('.loader').remove();
					}
                    pagina_load++;
                    loading = false; 
					loadClickVideo();
					$.get(URL_THEME+"/load_post_not.php?id_categoria="+id_categoria+"&pagina="+pagina_load, function(data){
						if(data == ""){
							$('.loader').hide();
							$('.vermaisMobile').remove();
						}else{
							$('.loader').hide();
							$('.vermaisMobile').show();
						}
					});
                }).fail(function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                    //$('.loader').hide();
                    loading = false;
                });
            }
        }
    });
}


function LoadNoticiasClick(id_categoria){
	
	$('.loader').show();
	$('.vermaisMobile').hide();
	
	$.get(URL_THEME+"/load_post_not.php?id_categoria="+id_categoria+"&pagina="+PAGINA_ATUAL, function(data){
		if(data){
			$(".listagemNoticias").append(data);
			//$('.loader').hide();
			//$('.vermaisMobile').show();
		}else{
			$('.loader').remove();
			$('.vermaisMobile').remove();
		}
		PAGINA_ATUAL++;
		loadClickVideo();
		$.get(URL_THEME+"/load_post_not.php?id_categoria="+id_categoria+"&pagina="+PAGINA_ATUAL, function(data){
			if(data == ""){
				$('.loader').hide();
				$('.vermaisMobile').remove();
			}else{
				$('.loader').hide();
				$('.vermaisMobile').show();
			}
		});
	}).fail(function(xhr, ajaxOptions, thrownError) {
		alert(thrownError);
		//$('.loader').hide();
		$('.vermaisMobile').show();
	});
}

function LoadBusca(termo){
    var pagina_load = 2;
    var loading  = false;
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() == $(document).height()){
            if(loading==false){
                loading = true;
                $('.loader').show();
				
                $.get(URL_THEME+"/load_post_busca.php?termo="+termo+"&pagina="+pagina_load, function(data){
					if(data){
						$(".listagemNoticias").append(data);
						//$('.loader').hide();
					}else{
						$('.loader').remove();
					}
                    pagina_load++;
                    loading = false; 
					loadClickVideo();
					$.get(URL_THEME+"/load_post_busca.php?termo="+termo+"&pagina="+pagina_load, function(data){
						if(data == ""){
							$('.loader').hide();
							$('.vermaisMobile').remove();
						}else{
							$('.loader').hide();
							$('.vermaisMobile').show();
						}
					});
                }).fail(function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                    //$('.loader').hide();
                    loading = false;
                });
            }
        }
    });
}


function LoadArquivos(query_string){
    var pagina_load = 2;
    var loading  = false;
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() == $(document).height()){
            if(loading==false){
                loading = true;
                $('.loader').show();
				
                $.get(URL_THEME+"/load_post_arq.php?"+query_string+"&pagina="+pagina_load, function(data){
					if(data){
						$(".listagem").append(data);
						//$('.loader').hide();
					}else{
						$('.loader').remove();
					}
                    pagina_load++;
                    loading = false; 
					loadClickVideo();
					$.get(URL_THEME+"/load_post_arq.php?"+query_string+"&pagina="+pagina_load, function(data){
						if(data == ""){
							$('.loader').hide();
							$('.vermaisMobile').remove();
						}else{
							$('.loader').hide();
							$('.vermaisMobile').show();
						}
					});
                }).fail(function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                    //$('.loader').hide();
                    loading = false;
                });
            }
        }
    });
	
}

function LoadArquivosClick(query_string){
	
	$('.loader').show();
	$('.vermaisMobile').hide();
	
	$.get(URL_THEME+"/load_post_arq.php?"+query_string+"&pagina="+PAGINA_ATUAL, function(data){
		if(data){
			$(".listagem").append(data);
			//$('.loader').hide();
			//$('.vermaisMobile').show();
		}else{
			$('.loader').remove();
			$('.vermaisMobile').remove();
		}
		PAGINA_ATUAL++;
		loadClickVideo();
		$.get(URL_THEME+"/load_post_arq.php?"+query_string+"&pagina="+PAGINA_ATUAL, function(data){
			if(data == ""){
				$('.loader').hide();
				$('.vermaisMobile').remove();
			}else{
				$('.loader').hide();
				$('.vermaisMobile').show();
			}
		});
	}).fail(function(xhr, ajaxOptions, thrownError) {
		alert(thrownError);
		//$('.loader').hide();
		$('.vermaisMobile').show();
	});
}