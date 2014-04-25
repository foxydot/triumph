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
      interval: 4000
    });

});