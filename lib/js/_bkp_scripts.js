$(document).ready(function(e) {
	loadClickVideo();
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
	
	$(".boxLinhaTempo .timeline  li span").click(function(e) {
		$(".showTimeLineBox",this).show();
		return false;
    });
	$(".showTimeLineBox .link").click(function(e) {
		var parentElm = $(this).parent();
		$(parentElm).hide();
		return false;
    });
	
    $(".navMenu .menu-item-has-children a").click(function(e) {
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
			$(this).removeClass('act');
			$('.header .linksTop').hide();
			$('.header .boxMenu').hide();
		}else{
			$(this).addClass('act');
			$('.header .linksTop').show();
			$('.header .boxMenu').show();
		}
		return false;
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
		if($(objParent).hasClass('act')){
			$('.texto',objParent).slideUp();
			$(objParent).removeClass('act');
		}else{
			$(".listaPerguntas li").removeClass('act');
			$(".listaPerguntas li .texto").slideUp();
			$('.texto',objParent).slideDown();
			$(objParent).addClass('act');
		}
    });
	
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
		if($(objParent).hasClass('act')){
			$('.cont',objParent).slideUp();
			$(objParent).removeClass('act');
		}else{
			$(".boxSanfona li").removeClass('act');
			$(".boxSanfona li .cont").slideUp();
			$('.cont',objParent).slideDown();
			$(objParent).addClass('act');
		}
    });
	
	
	
	$(".abasOferta a").click(function(e) {
        var obj = $(this).parent().parent().parent();
		var elem = $(this).attr('href').replace('#','');
		$(".abasOferta a",obj).removeClass('act');
		$(this).addClass('act');
		$(".contOferta",obj).hide();
		$(".contOferta."+elem,obj).show();
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
				console.log($(this).scrollTop()+' x '+ $(".boxAindaDuvidas").offset().top);
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
					console.log(objAtivo);	
					//$(".boxPerguntasFrequentes .colLeft li a").removeClass('act');
					$(".boxPerguntasFrequentes .colLeft li a").removeClass('ativo');
					$(objAtivo).addClass('ativo');
				}else{;
				}
			});
		}
    });
});

function showModalRestrito(){
	$(".boxPopup").show();
}
function fecharModalRestrito (){
	$(".boxPopup").hide();
}
function loadClickVideo(){
	jQuery(".video-player .play").click(function(){
		var objClick = jQuery(this).parent().parent();
		jQuery(".bgLigthBox").fadeIn(200);
		jQuery(".video-player",objClick).delay(200).fadeIn(200);
		//jQuery(".video embed").show();
		jQuery(".video-player iframe").show();
		jQuery(".bgLigthBox").click(function(){
			jQuery(".video-player").fadeOut(200);
			//jQuery(".video embed").hide();
			//jQuery(".video embed").show();
			jQuery(".video-player iframe").hide();
			jQuery(".video-player iframe").show();
			jQuery(".bgLigthBox").delay(200).fadeOut(200);
		});
		jQuery(".video-player").click(function(){
			jQuery(".video-player").fadeOut(200);
			//jQuery(".video embed").hide();
			//jQuery(".video embed").show();
			jQuery(".video-player iframe").hide();
			jQuery(".video-player iframe").show();
			jQuery(".bgLigthBox").delay(200).fadeOut(200);
		});
	});
}