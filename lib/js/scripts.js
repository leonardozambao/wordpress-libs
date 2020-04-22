var thisLink;
var thisVideo;
$(document).ready(function(e) {
	$('.listaPerguntas a[href$=".pdf"]').addClass('pdf');
	/*
	$(document).on('click', 'a', function(event){
		if(($.attr(this, 'href').indexOf("#") != -1)){
			$('html, body').animate({
				scrollTop: $($.attr(this, 'href')).offset().top
			}, 500);
			return false;
		}else{
			return true;
		}
	});
	*/
	
	$(document).on('click', '.boxPerguntasFrequentes a', function(event){
		if(($.attr(this, 'href').indexOf("#") != -1)){
			$('html, body').animate({
				scrollTop: $($.attr(this, 'href')).offset().top
			}, 500);
			return false;
		}else{
			return true;
		}
	});
	
	
	/* Alinhamento header tabela fundos*/
	var posTableFundos = 0;
	function fposTableFundos(posTableFundos){
		if($(window).scrollTop() >= (posTableFundos - 110)){
			$(".boxFundos .tableTop.tableV2").addClass('act');
		}else{
			$(".boxFundos .tableTop.tableV2").removeClass('act');
		}
	}
	if($(".boxFundos .tableTop.tableV2").length){
		posTableFundos = $(".boxFundos .tableTop.tableV2").offset().top;
		fposTableFundos(posTableFundos);
		$(window).scroll(function(e) {
            fposTableFundos(posTableFundos);
        });
	}
	
	$(".boxLinhaTempo .timeline  li span").click(function(e) {
		$(".showTimeLineBox",this).show();
		return false;
    });
	$(".showTimeLineBox .link").click(function(e) {
		var parentElm = $(this).parent();
		$(parentElm).hide();
		return false;
    });
	
	
    $(".navMenu .menu-item-has-children > a").click(function(e) {
		
		if($(window).width() < 768){
			var liCont = $(this).parent();
			if($(this).hasClass('act')){
				$('ul',liCont).slideUp(200);
				$(this).removeClass('act');
			}else{
				$(".navMenu li ul").slideUp(200);
				$(".navMenu a").removeClass('act');
				$('ul',liCont).slideDown(200);
				$(this).addClass('act');
			}
			return false;
		}
    });
	
	$(".btBuscar").click(function(e) {
		if($(this).hasClass('act')){
			$(this).removeClass('act');
	        $(".boxBusca").hide();
		}else{
			$(this).addClass('act');
	        $(".boxBusca").show();
		}
		return false;
    });
	
    $(".menuMobile").click(function(e) {
		if($(this).hasClass('act')){
			$(".menuClose").hide();
			$(this).removeClass('act');
			$('.header .linksTop').hide();
			$('.header .boxMenu').hide();
		}else{
			$(".menuClose").css({'position': 'fixed', 'z-index' : '99998', 'width' : '100%', 'height' : '100%', 'top' : '0', 'left' : '0', 'position': 'fixed'});
			$(".menuClose").show();
			$(this).addClass('act');
			$('.header .linksTop').show();
			$('.header .boxMenu').show();
		}
		var alturaTela = $(window).height();
		var postMenuTop = 170; //$("#menu-menu-cabecalho").offset().top;
		
		var maxMenuTam = (alturaTela - postMenuTop);
		$("#menu-menu-cabecalho").css({'max-height': maxMenuTam+ 'px'});
		return false;
	});
	
	$(".menuClose").click(function(e) {
		$(".menuClose").hide();
		$(".menuMobile").removeClass('act');
		$('.header .linksTop').hide();
		$('.header .boxMenu').hide();
	});
	
	$(window).resize(function(e) {
		if($(window).width() < 768){
			if($(".menuMobile").hasClass('act')){
				$('.header .linksTop').show();
				$('.header .boxMenu').show();
			}else{
				$('.header .linksTop').hide();
				$('.header .boxMenu').hide();
			}
		}else{
			$('.header .linksTop').show();
			$('.header .boxMenu').show();
		}
    });
	
	$(".btVoltarTop").click(function(){
		$("html, body").animate({ scrollTop: 0 }, "slow");
		return false;
	});
	
	$(".listaPerguntas li .titulo").click(function(e) {
        var objParent = $(this).parent();
		var objthis = $(this);
		if($(objParent).hasClass('act')){
			$('.texto',objParent).slideUp();
			$(objParent).removeClass('act');
		}else{
			$(".listaPerguntas li").removeClass('act');
			$(".listaPerguntas li .texto").slideUp();
			$('.texto',objParent).slideDown(function(){
				scrollthis(objthis);
			});
			$(objParent).addClass('act');
		}
    });
	function scrollthis(e){
		var headerH = $('.header').height();
		var pos = e.offset().top;
		$('html, body').animate({
			scrollTop: pos - headerH - 35
		}, 500);
	}
	$(".listaPrecos li .titulo").click(function(e) {
        var objParent = $(this).parent();
		if($(objParent).hasClass('act')){
			$('.texto',objParent).slideUp();
			$(objParent).removeClass('act');
		}else{
			$(".listaPrecos li").removeClass('act');
			$(".listaPrecos li .texto").slideUp();
			$('.texto',objParent).slideDown();
			$(objParent).addClass('act');
		}
    });
	
	
	$(".listaImprensa li .titulo").click(function(e) {
        var objParent = $(this).parent();
		if($(objParent).hasClass('act')){
			$('.cont',objParent).slideUp();
			$(objParent).removeClass('act');
		}else{
			$(".listaImprensa li").removeClass('act');
			$(".listaImprensa li .cont").slideUp();
			$('.cont',objParent).slideDown();
			$(objParent).addClass('act');
		}
    });
	
	$(".boxSanfona li .titulo").click(function(e) {
        var objParent = $(this).parent();
		var objthis = $(this);
		if($(objParent).hasClass('act')){
			$('.cont',objParent).slideUp();
			$(objParent).removeClass('act');
		}else{
			//$(".boxSanfona li").removeClass('act');
			//$(".boxSanfona li .cont").slideUp();
			$('.cont',objParent).slideDown(function(){
				scrollthis(objthis);
			});
			$(objParent).addClass('act');
		}
    });
	
	$('.boxFundosDetalhe .box_opcoes p').click(function(){
		if ($(this).hasClass('aba_performance')){
			$('.boxFundosDetalhe .box_opcoes li').removeClass('act');
			$(this).parent().addClass('act');
			$('.bloco.estrategia').css('display','none');
			$('.bloco.detalhes').css('display','none');
			$('.bloco.performance').css('display','inline-block');
			}
		if ($(this).hasClass('aba_estrategia')){
			$('.boxFundosDetalhe .box_opcoes li').removeClass('act');
			$(this).parent().addClass('act');
			$('.bloco.performance').css('display','none');
			$('.bloco.detalhes').css('display','none');
			$('.bloco.estrategia').css('display','inline-block');
			}
		if ($(this).hasClass('aba_caracteristicas')){
			$('.boxFundosDetalhe .box_opcoes li').removeClass('act');
			$(this).parent().addClass('act');
			$('.bloco.performance').css('display','none');
			$('.bloco.estrategia').css('display','none');
			$('.bloco.detalhes').css('display','inline-block');
			}
	})
	
	
	$(".abasOferta a").click(function(e) {
        var obj = $(this).parent().parent().parent();
		var elem = $(this).attr('href').replace('#','');
		$(".abasOferta a",obj).removeClass('act');
		$(this).addClass('act');
		$(".contOferta",obj).hide();
		$(".contOferta."+elem,obj).show();
		return false;
    });
	$(".dropdown a.collapse").click(function(e) {
        $(this).parent().toggleClass('collapsed');
		return false;
    });
	
	$(".ver_detalhe").click(function(e) {
		$(this).toggleClass('act').parent().parent().parent().next('tr').addClass('act').slideToggle();
		return false;
    });
	
	$(window).scroll(function(e) {
		if($(".boxPerguntasFrequentes .colRight").length){
			if($(this).scrollTop() >= ($(".boxPerguntasFrequentes .colRight").offset().top - $('.header').height())){
				$(".boxPerguntasFrequentes .colLeft").addClass('act');
			}else{
				$(".boxPerguntasFrequentes .colLeft").removeClass('act');
			}
			
			//if($(this).scrollTop() >= ($(".footer").offset().top - $(".footer").height() - $('.header').height())){
				//console.log($(this).scrollTop()+' x '+ $(".boxAindaDuvidas").offset().top);
			if($(this).scrollTop() >= ($(".boxAindaDuvidas").offset().top - 500)){
				$(".boxPerguntasFrequentes .colLeft").addClass('foot');
			}else{
				$(".boxPerguntasFrequentes .colLeft").removeClass('foot').removeAttr('style');
			}
			
			var scrollTop = $(this).scrollTop();
			
			$(".colRight .tituloCat").each(function(index, element) {
				var nextElementHeight = ($(this).next().height()) + 155;
				var posElement = ($(this).offset().top - $('.header').height() -155);
				if((scrollTop >= posElement) && (scrollTop <= posElement + nextElementHeight)){
					var objAtivo = ".listaFaq."+$(this).attr('class').replace('tituloCat ','');
					//console.log(objAtivo);	
					//$(".boxPerguntasFrequentes .colLeft li a").removeClass('act');
					$(".boxPerguntasFrequentes .colLeft li a").removeClass('ativo');
					$(objAtivo).addClass('ativo');
				}else{;
				}
			});
		}
    });
	jQuery(".video .play").click(function(){
        thisVideo = jQuery(this).next('.video_url');
        lightboxVideo(thisVideo);
	});
    jQuery('.bg-lightbox, .bt-fechar-video').click(function(){
        fecharVideo();
    });
	
	$('.share .popup').click(function(e) {
	  $(this).customerPopup(e);
	});
	
	ocultaPaiSemVazio('.boxBiblioteca .boxCenter');
	ocultaPaiSemVazio('.colRight .listaItens');
});
function ocultaPaiSemVazio(e){
	$(e).each(function(){
        if($(this).children().length == 0){
           $(this).parent().css('display','none');
        };
    });
};



function showModalRestrito(){
	$(".boxPopup").show();
	$(".boxPopup.pop2").hide();
}
function showModalRestrito2(){
	$(".boxPopup").hide();
	$(".boxPopup.pop2").show();
}
function fecharModalRestrito (){
	$(".boxPopup").hide();
}
function lightboxVideo(e){
    jQuery('.img-clone').remove();
    jQuery(e).clone().prependTo( ".main" ).addClass('img-clone').show();
	if (jQuery(window).width() < 960){ 
		jQuery('.img-clone').width(jQuery(window).width() - 20);
		jQuery('.img-clone').height(jQuery(window).height() - 20);
		var cloneHalfWidth = jQuery('.img-clone').width()/2;
		jQuery('.img-clone').css({'left': -cloneHalfWidth, 'top': '10px', 'margin-top': 0});
    };
    bgLightbox()
    //$(thisButton).parent().next('.links-download').clone().insertAfter( ".img-selected" ).addClass('img-clone'); 
};
function bgLightbox(){
    if (jQuery('.bg-lightbox').hasClass('act')){
        jQuery('.bg-lightbox, .bt-fechar-video').removeClass('act').fadeOut();
    }else{
        jQuery('.bg-lightbox, .bt-fechar-video').addClass('act').fadeIn();
    };
}
function fecharVideo(){
    jQuery('.bg-lightbox, .bt-fechar-video').removeClass('act').fadeOut();
    jQuery('.img-clone').remove();    
}

$.fn.customerPopup = function (e, intWidth, intHeight, blnResize) {
    
// Prevent default anchor event
	e.preventDefault();

	// Set values for window
	intWidth = intWidth || '500';
	intHeight = intHeight || '400';
	strResize = (blnResize ? 'yes' : 'no');

	// Set title and open popup with focus on it
	var strTitle = ((typeof this.attr('title') !== 'undefined') ? this.attr('title') : 'Social Share'),
		strParam = 'width=' + intWidth + ',height=' + intHeight + ',resizable=' + strResize,            
		objWindow = window.open(this.attr('href'), strTitle, strParam).focus();
}