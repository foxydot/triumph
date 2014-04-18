<?php
/*** WIDGET AREAS ***/
/**
 * Hero and (3) widget areas
 */
function msdlab_add_homepage_hero_flex_sidebars(){
    genesis_register_sidebar(array(
    'name' => 'Homepage Hero',
    'description' => 'Homepage hero space',
    'id' => 'homepage-top'
            ));
    genesis_register_sidebar(array(
    'name' => 'Homepage Widget Area',
    'description' => 'Homepage central widget areas',
    'id' => 'homepage-widgets',
    'before_widget' => genesis_markup( array(
        'html5' => '<section id="%1$s" class="widget %2$s"><div class="widget-wrap">',
        'xhtml' => '<div id="%1$s" class="widget %2$s"><div class="widget-wrap">',
        'echo'  => false,
    ) ),
    
    'after_widget'  => genesis_markup( array(
        'html5' => '</div><div class="clear"></div></section>' . "\n",
        'xhtml' => '</div><div class="clear"></div></div>' . "\n",
        'echo'  => false
    ) ),
            )); 
}

/**
 * Callout Bar widget area
 */
function msdlab_add_homepage_callout_sidebars(){
    genesis_register_sidebar(array(
    'name' => 'Homepage Callout',
    'description' => 'Homepage call to action',
    'id' => 'homepage-callout'
            ));
}
/**
 * Add a hero space with the site description
 */
function msdlab_hero(){
    if(is_active_sidebar('homepage-top')){
        print '<div id="hp-top">';
        dynamic_sidebar('homepage-top');
        print '</div>';
    } 
}

/**
 * Add a hero space with the site description
 */
function triumph_hero(){
    global $homepage_metabox;
    
    print '<div id="hp-top">';
    $i = 0;
    while($homepage_metabox->have_fields('sliders')):
        $active = $i==0?' active':'';
        $items .= '
        <div class="item'.$active.'">
           <div class="image_block" style="background: url('.$homepage_metabox->get_the_value('image').') center top no-repeat #000000;background-size: cover;">
               <div class="quote_block">
                  <div class="wrap">
                    <div class="quote">'.apply_filters('the_content',$homepage_metabox->get_the_value('quote')).'</div>
                    <div class="attribution">'.$homepage_metabox->get_the_value('attribution').'</div>
                  </div>
               </div>
           </div>
           <div class="wrap">
               <div class="content-sidebar-wrap row">
                <main itemprop="mainContentOfPage" role="main" class="content col-md-9 col-sm-12">
                    <article itemtype="http://schema.org/CreativeWork" itemscope="itemscope" class="page entry">
                        <header class="entry-header">
                            <h1 itemprop="headline" class="entry-title">'.$homepage_metabox->get_the_value('title').'</h1> 
                        </header>
                        <div itemprop="text" class="entry-content">
                            '.apply_filters('the_content',$homepage_metabox->get_the_value('content')).'
                        </div>
                    </article>
                </main>
                <aside itemtype="http://schema.org/WPSideBar" itemscope="itemscope" role="complementary" class="sidebar sidebar-primary widget-area col-md-3 hidden-sm hidden-xs">
                    '.apply_filters('the_content',$homepage_metabox->get_the_value('sidebar')).'
                </aside>
                </div>
            </div>
        </div>';
        $i++;
    endwhile;
    print msd_carousel_wrapper($items,array('id' => $id));
    print '</div>';
}

/**
 * Add a hero space with the site description
 */
function msdlab_callout(){
	print '<div id="hp-callout">';
	print '<div class="wrap">';
    if(is_active_sidebar('homepage-callout')){
    	dynamic_sidebar('homepage-callout');
	} else {
        do_action( 'genesis_site_description' );
    }
	print '</div>';
	print '</div>';
}

/**
 * Add flaxible widget area
 */
function msdlab_homepage_widgets(){
	print '<div id="homepage-widgets" class="widget-area">';
	print '<div class="wrap"><div class="row">';
        dynamic_sidebar('homepage-widgets');
  	print '</div></div>';
	print '</div>';
}

/**
 * Create a long scrollie page with child pages of homepage.
 * Uses featured image for background of each wrap section.
 */
function msdlab_scrollie_page(){
    global $post;
    $edit = get_edit_post_link($post->ID) != ''?'<a href="'.get_edit_post_link($post->ID).'"><i class="icon-edit"></i></a>':'';
    $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
    $background = $thumbnail?' style="background-image:url('.$thumbnail[0].');"':'';
    remove_filter('the_content','wpautop',12);
    print '<div id="intro" class="scrollie parent div-intro div0">
                <div class="background-wrapper"'.$background.'>
                        <div class="wrap">
                            <div class="page-content">
                                    <div class="entry-content">';
    print apply_filters('the_content', $post->post_content);
    print '                     </div>
                            '.$edit.'
                            </div>
                        </div>
                    </div>
                </div>';
    print '<div id="callout"><p>'.get_option('blogdescription').'</p></div>';

    add_filter('the_content','wpautop',12);
    $my_wp_query = new WP_Query();
    $args = array(
            'post_type' => 'page',
            'order' => 'ASC',
            'orderby' => 'menu_order',
            'tax_query' => array(
                    array(
                        'taxonomy' => 'msdlab_scrollie',
                        'field' => 'slug',
                        'terms' => 'home'
                        )
                    )
            );
    $children = $my_wp_query->query($args);
    $i = 1;
    foreach($children AS $child){
        $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($child->ID), 'full' );
        $background = $thumbnail?' style="background-image:url('.$thumbnail[0].');"':'';
        $form = $child->post_name=='contact-us'?do_shortcode('[gravityform id="1" name="Untitled Form" title="false" ajax="true"]'):'';
        $edit = get_edit_post_link($child->ID) != ''?'<a href="'.get_edit_post_link($child->ID).'"><i class="icon-edit"></i></a>':'';
        print '<div id="'.$child->post_name.'" class="scrollie child div-'.$child->post_name.' div'.$i.' trigger" postid="'.$child->ID.'">
                <div class="background-wrapper"'.$background.'>
                        <div class="wrap">'.$form.'
                            <div class="page-content">
                                <h2 class="entry-title">'.$child->post_title.'</h2>
                                <div class="entry-content">'.apply_filters('the_content', $child->post_content).'</div>
                                '.$edit.'
                            </div>
                        </div>
                    </div>
                </div>';
        $i++;
    }
}

/**
 * create a taxonomy for long scrollies
 */
function register_taxonomy_scrollie() {

    $labels = array(
            'name' => _x( 'Scrollie Sections', 'scrollie' ),
            'singular_name' => _x( 'Scrollie Section', 'scrollie' ),
            'search_items' => _x( 'Search Scrollie Sections', 'scrollie' ),
            'popular_items' => _x( 'Popular Scrollie Sections', 'scrollie' ),
            'all_items' => _x( 'All Scrollie Sections', 'scrollie' ),
            'parent_item' => _x( 'Parent Scrollie Section', 'scrollie' ),
            'parent_item_colon' => _x( 'Parent Scrollie Section:', 'scrollie' ),
            'edit_item' => _x( 'Edit Scrollie Section', 'scrollie' ),
            'update_item' => _x( 'Update Scrollie Section', 'scrollie' ),
            'add_new_item' => _x( 'Add New Scrollie Section', 'scrollie' ),
            'new_item_name' => _x( 'New Scrollie Section Name', 'scrollie' ),
            'separate_items_with_commas' => _x( 'Separate scrollies with commas', 'scrollie' ),
            'add_or_remove_items' => _x( 'Add or remove scrollies', 'scrollie' ),
            'choose_from_most_used' => _x( 'Choose from the most used scrollies', 'scrollie' ),
            'menu_name' => _x( 'Scrollie Sections', 'scrollie' ),
    );

    $args = array(
            'labels' => $labels,
            'public' => false,
            'show_in_nav_menus' => false,
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true,

            'rewrite' => true,
            'query_var' => true
    );

    register_taxonomy( 'msdlab_scrollie', array('page'), $args );
}   

if(!class_exists('WPAlchemy_MetaBox')){
    include_once (WP_CONTENT_DIR.'/wpalchemy/MetaBox.php');
}
global $wpalchemy_media_access;
if(!class_exists('WPAlchemy_MediaAccess')){
    include_once (WP_CONTENT_DIR.'/wpalchemy/MediaAccess.php');
}
$wpalchemy_media_access = new WPAlchemy_MediaAccess();
add_action('init','add_homepage_metaboxes');
add_action('admin_footer','homepage_footer_hook');
//add_action( 'admin_print_scripts', 'homepage_metabox_styles' );

function add_homepage_metaboxes(){
    global $post,$homepage_metabox;
    $homepage_metabox = new WPAlchemy_MetaBox(array
    (
        'id' => '_homepage',
        'title' => 'Home Page Sliders',
        'types' => array('page'),
        'context' => 'normal', // same as above, defaults to "normal"
        'priority' => 'high', // same as above, defaults to "high"
        'template' => get_stylesheet_directory() . '/lib/template/metabox-homepage.php',
        'autosave' => TRUE,
        'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
        'prefix' => '_msdlab_', // defaults to NULL
        'include_template' => 'front-page.php',
    ));
}

function homepage_footer_hook()
{
    ?><script type="text/javascript">
        jQuery('#postdivrich').after(jQuery('#_homepage_metabox'));
    </script><?php
}
/* eof */