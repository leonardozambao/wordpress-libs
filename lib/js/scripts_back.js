$(document).ready(function(e) {
	
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
	
	$(window).scroll(function(e) {
		if($(".boxPerguntasFrequentes .colRight").length){
			if($(this).scrollTop() >= ($(".boxPerguntasFrequentes .colRight").offset().top - $('.header').height())){
				$(".boxPerguntasFrequentes .colLeft").addClass('act');
			}else{
				$(".boxPerguntasFrequentes .colLeft").removeClass('act');
			}
			
			if($(this).scrollTop() >= ($(".footer").offset().top - $(".footer").height() - $('.header').height())){
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