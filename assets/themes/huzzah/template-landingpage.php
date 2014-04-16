<?php
/*
Template Name: Landing Page
*/
function msdlab_landingpage_tabs(){
    global $allowedposttags,$landingpage_metabox;
    $landingpage_metabox->the_meta();
    $nav_tabs = $tab_content = array();
    $i=1;
    $allowedposttags['script'] = array('id'=>true,'src'=>true,'type'=>true);

    $allowedposttags['hidden'] = array('id'=>true,'name'=>true,'value'=>true,'class'=>true);
    $allowedposttags['select'] = array('id'=>true,'name'=>true,'value'=>true,'class'=>true,'selected'=>true);
    $allowedposttags['option'] = array('id'=>true,'name'=>true,'value'=>true,'class'=>true);
    $allowedposttags['input'] = array('id'=>true,'name'=>true,'value'=>true,'class'=>true);
    $allowedposttags['submit'] = array('id'=>true,'name'=>true,'value'=>true,'class'=>true);
    $allowedposttags['button'] = array('id'=>true,'name'=>true,'value'=>true,'class'=>true);
    $nav_tabs = $tab_content = array();
    $i=0;
    while($landingpage_metabox->have_fields('tabs')):
        if($i==0){$buttontext = wp_strip_all_tags($landingpage_metabox->get_the_value('title'));}
        $nav_tabs[$i] = '<li'.($i==0?' class="active"':'').'><a href="#'.sanitize_title(wp_strip_all_tags($landingpage_metabox->get_the_value('title'))).'" data-toggle="tab" data-option-value=".'.sanitize_title(wp_strip_all_tags($landingpage_metabox->get_the_value('title'))).'"><h4 class="tab-title">'.$landingpage_metabox->get_the_value('title').'</h4></a></li>';       
        $tab_content[$i] = '<div class="tab-pane fade'.($i==0?' in active':'').'" id="'.sanitize_title(wp_strip_all_tags($landingpage_metabox->get_the_value('title'))).'">'.apply_filters('the_content',$landingpage_metabox->get_the_value('content')).'</div>';
        $i++;
    endwhile; //end loop
    print '<div class="landingpage-tabs">
    ';
    print '<!-- Nav tabs -->
        <div class="btn-group">
          <button type="button" class="btn btn-default"><strong>'.$buttontext.'</strong></button>
          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
          </button>
          <ul class="nav dropdown-menu tabs-'.count($nav_tabs).'" role="menu">
            '.implode("\n", $nav_tabs).'
          </ul>
        </div>
        ';
    print '<!-- Tab panes -->
        <div class="tab-content">
        '.implode("\n", $tab_content).'
        </div>
        '; 
    print '</div>
    ';
}
add_action('genesis_entry_content','msdlab_landingpage_tabs',30);
function msdlab_landingpage_tabs_js(){
    print "
    <script>
jQuery(document).ready(function($) {
    $('.dropdown-menu li').click(function(){
        $(this).siblings().removeClass('active');
        $(this).parents('.btn-group').find('.btn.first-child').html($(this).find('a').html());
    })
});
</script>";
}
add_action('wp_footer','msdlab_landingpage_tabs_js');
genesis();
