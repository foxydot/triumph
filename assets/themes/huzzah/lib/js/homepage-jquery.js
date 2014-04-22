jQuery(document).ready(function($) {
    /*var numwidgets = $('#homepage-widgets section.widget').length;
    $('#homepage-widgets').addClass('cols-'+numwidgets);
    var cols = 12/numwidgets;
    $('#homepage-widgets section.widget').addClass('col-sm-'+cols);
    $('#homepage-widgets section.widget').addClass('col-xs-12');*/
    var bw_img;
    $('#homepage-widgets section.widget').hover(function(e){
        bw_img = $(this).find('.bw').attr('style');
        $(this).find('.bw').attr('style','');
    },function(e){
        $(this).find('.bw').attr('style',bw_img);
    });
    
    var s = Snap('#the_map');
    $('.state').hover(function(){
        $(this).toFront();
    },function(){});
});