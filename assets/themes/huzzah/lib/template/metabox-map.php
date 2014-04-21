<?php global $wpalchemy_media_access; ?>
<?php 

$postid = is_admin()?$_GET['post']:$post->ID;
$template_file = get_post_meta($postid,'_wp_page_template',TRUE);
  // check for a template type
if (is_admin() && $template_file == 'front-page.php') { ?>
<div class="homepage_meta_control">
 <p id="warning" style="display: none;background:lightYellow;border:1px solid #E6DB55;padding:5px;">Order has changed. Please click Save or Update to preserve order.</p>
    <div class="table">
    <div class="row">
        <div class="cell">
            <label>Map Content</label>
            <div class="input_container">
                <?php 
                $mb->the_field('content');
                $mb_content = html_entity_decode($mb->get_the_value(), ENT_QUOTES, 'UTF-8');
                $mb_editor_id = sanitize_key($mb->get_the_name());
                $mb_settings = array('textarea_name'=>$mb->get_the_name(),'textarea_rows' => '5',);
                wp_editor( $mb_content, $mb_editor_id, $mb_settings );
                ?>
           </div>
        </div>
    </div>
    </div>
</div>
<?php } else {
    print "Select \"Front Page\" template and save to activate.";
} ?>
