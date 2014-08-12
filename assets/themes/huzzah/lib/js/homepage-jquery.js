jQuery(document).ready(function($) {
    /*var numwidgets = $('#homepage-widgets section.widget').length;
    $('#homepage-widgets').addClass('cols-'+numwidgets);
    var cols = 12/numwidgets;
    $('#homepage-widgets section.widget').addClass('col-sm-'+cols);
    $('#homepage-widgets section.widget').addClass('col-xs-12');*/
    var bw_img;
    $('#homepage-widgets section.widget').hover(function(){
        bw_img = $(this).find('.bw').attr('style');
        $(this).find('.bw').attr('style','');
    },function(){
        $(this).find('.bw').attr('style',bw_img);
    });
    $('.carousel .carousel-indicators, .carousel .carousel-control, .carousel .item .image_block').hover(function(){
        $(this).parents('.carousel').find('.carousel-inner .item .quote_block').css('height','25%');
    },function(){
        $(this).parents('.carousel').find('.carousel-inner .item .quote_block').css('height','0%');
    });
    
    $('.carousel').carousel({
      interval: 8000
    });
    var container_h = $('.carousel').find('.carousel-inner .item.active .image_block').height();
    $('.carousel .carousel-indicators').css('top',function(){
        var top = container_h - ($(this).height()+10);
        return top+'px';
    });
    $('.carousel .carousel-control').css('height',function(){
        return container_h+'px';
    });
    $('#hp-top').css('min-height',function(){
        return (container_h+260)+'px';
    });
    $( window ).resize(function() {
    var container_h = $('.carousel').find('.carousel-inner .item.active .image_block').height();
        $('.carousel .carousel-indicators').css('top',function(){
            var top = container_h - ($(this).height()+10);
            return top+'px';
        });
        $('.carousel .carousel-control').css('height',function(){
            return container_h+'px';
        });
        $('#hp-top').css('min-height',function(){
            return (container_h+250)+'px';
        });
    });
});