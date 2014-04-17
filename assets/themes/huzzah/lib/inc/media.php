<?php
/**
 * Add new image sizes
 */
add_image_size('post-thumb', 225, 160, TRUE);
add_image_size( 'post-image', 960, 350, TRUE ); //image to float at the top of the post. Reversed Out does these a lot.
add_image_size('landingpage-tab', 144, 138, TRUE);
/* Display a custom favicon */
add_filter( 'genesis_pre_load_favicon', 'msdlab_favicon_filter' );
function msdlab_favicon_filter( $favicon_url ) {
    return get_stylesheet_directory_uri().'/lib/img/favicon.ico';
}

add_action('genesis_before_content','msd_post_image');
/**
 * Manipulate the featured image
 */
function msd_post_image() {
    global $post,$slideshow_metabox;
    //first check for a slideshow
    $slideshow_metabox->the_meta();
    $slideshow_id = $slideshow_metabox->get_the_value('slideshow');
    if($slideshow_id){
        print '<section class="header-image">';
        print do_shortcode('[SlideDeck2 id='.$slideshow_id.']');
        print '</section>';
        return;
    }
    //setup thumbnail image args to be used with genesis_get_image();
    $size = 'post-image'; // Change this to whatever add_image_size you want
    $default_attr = array(
            'class' => "alignright attachment-$size $size",
            'alt'   => $post->post_title,
            'title' => $post->post_title,
    );

    // This is the most important part!  Checks to see if the post has a Post Thumbnail assigned to it. You can delete the if conditional if you want and assume that there will always be a thumbnail
    if ( has_post_thumbnail() && is_page() ) {
        print '<section class="header-image">';
        printf( '<a title="%s" href="%s">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), genesis_get_image( array( 'size' => $size, 'attr' => $default_attr ) ) );
        print '</section>';
    }

}

/**
 * Add new image sizes to the media panel
 */
if(!function_exists('msd_insert_custom_image_sizes')){
function msd_insert_custom_image_sizes( $sizes ) {
	global $_wp_additional_image_sizes;
	if ( empty($_wp_additional_image_sizes) )
		return $sizes;

	foreach ( $_wp_additional_image_sizes as $id => $data ) {
		if ( !isset($sizes[$id]) )
			$sizes[$id] = ucfirst( str_replace( '-', ' ', $id ) );
	}

	return $sizes;
}
}
add_filter( 'image_size_names_choose', 'msd_insert_custom_image_sizes' );

add_shortcode('carousel','msd_bootstrap_carousel');
function msd_bootstrap_carousel($atts){
    $slidedeck = new SlideDeck();
    extract( shortcode_atts( array(
        'id' => NULL,
    ), $atts ) );
    $sd = $slidedeck->get($id);
    $slides = $slidedeck->fetch_and_sort_slides( $sd );
    $i = 0;
    foreach($slides AS $slide){
        $active = $i==0?' active':'';
        $items .= '
        <div style="background: url('.$slide['image'].') center top no-repeat #000000;background-size: cover;" class="item'.$active.'">
           '.$slide['content'].'
        </div>';
        $i++;
    }
    return msd_carousel_wrapper($items,array('id' => $id));
}

function msd_carousel_wrapper($slides,$params = array()){
    extract( array_merge( array(
    'id' => NULL,
    'navleft' => '‹',
    'navright' => '›'
    ), $params ) );
    return '
<div class="carousel slide" id="myCarousel_'.$id.'">
    <div class="carousel-inner">'.($slides).'</div>
    <a data-slide="prev" href="#myCarousel_'.$id.'" class="left carousel-control">'.$navleft.'</a>
    <a data-slide="next" href="#myCarousel_'.$id.'" class="right carousel-control">'.$navright.'</a>
</div>';
}

/* Slideshow Support */
if(!class_exists('WPAlchemy_MetaBox')){
    include_once WP_CONTENT_DIR.'/wpalchemy/MetaBox.php';
}
if(class_exists('SlideDeckPlugin')){
    add_action('init','add_slideshow_metaboxes');
    add_action('admin_footer','slideshow_footer_hook');
    add_action( 'admin_print_scripts', 'slideshow_metabox_styles' );
    add_action( 'genesis_before_post_content', 'msdlab_do_post_slideshow' );
    
    
    function add_slideshow_metaboxes(){
        global $slideshow_metabox;
        $slideshow_metabox = new WPAlchemy_MetaBox(array
        (
            'id' => '_slideshow',
            'title' => 'Slideshow',
            'types' => array('post','page'),
            'context' => 'side', // same as above, defaults to "normal"
            'priority' => 'high', // same as above, defaults to "high"
            'template' => get_stylesheet_directory() . '/lib/template/slideshow-meta.php',
            'autosave' => TRUE,
            'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
            'prefix' => '_msdlab_', // defaults to NULL
            'exclude_template' => 'front-page.php',
        ));
    }
    
    function slideshow_footer_hook()
    {
        ?><script type="text/javascript">
            jQuery('#postimagediv').before(jQuery('#_slideshow_metabox'));
        </script><?php
    }
    
    // include css to help style our custom meta boxes
     
    function slideshow_metabox_styles()
    {
        if ( is_admin() )
        {
            wp_enqueue_style('wpalchemy-metabox', get_stylesheet_directory_uri() . '/lib/template/meta.css');
        }
    }
    
    function msdlab_do_post_slideshow() {
        global $slideshow_metabox;
        $slideshow_metabox->the_meta();
        $slideshow = $slideshow_metabox->get_the_value('slideshow');
    
        if ( strlen( $slideshow ) == 0 )
            return;
    
        $slideshow = sprintf( '<h2 class="entry-slideshow">%s</h2>', apply_filters( 'genesis_post_title_text', $slideshow ) );
        echo apply_filters( 'genesis_post_title_output', $slideshow ) . "\n";
    
    }
}