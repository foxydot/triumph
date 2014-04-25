<?php global $wpalchemy_media_access; ?>
<?php 

$postid = is_admin()?$_GET['post']:$post->ID;
$template_file = get_post_meta($postid,'_wp_page_template',TRUE);
  // check for a template type
if (is_admin() && $template_file == 'front-page.php') { ?>
<div class="homepage_meta_control">
 <p id="warning" style="display: none;background:lightYellow;border:1px solid #E6DB55;padding:5px;">Order has changed. Please click Save or Update to preserve order.</p>
    <div class="table">
    <?php $i = 0; ?>
    <?php while($mb->have_fields('features',3)): ?>
    <?php $mb->the_group_open(); ?>
    <div class="row <?php print $i%2==0?'even':'odd'; ?>">
        <div class="cell">
        <?php $mb->the_field('title'); ?>
        <label>Feature Area Title</label>            
        <div class="input_container">
            <input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/></div>
        </div>
        <div class="cell file">
            <label>Grayscale Image</label>
            <div class="input_container">
        <?php $mb->the_field('bw_image'); ?>
        <?php $wpalchemy_media_access->setGroupName('bw-img'. $mb->get_the_index())->setInsertButtonLabel('Insert This')->setTab('gallery'); ?>
        <?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
        <?php echo $wpalchemy_media_access->getButton(array('label' => 'Add Image')); ?>
            </div>
        </div>        
        <div class="cell file">
            <label>Color Image</label>
            <div class="input_container">
        <?php $mb->the_field('color_image'); ?>
        <?php $wpalchemy_media_access->setGroupName('color-img'. $mb->get_the_index())->setInsertButtonLabel('Insert This')->setTab('gallery'); ?>
        <?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
        <?php echo $wpalchemy_media_access->getButton(array('label' => 'Add Image')); ?>
            </div>
        </div>
        <div class="cell">
        <?php $mb->the_field('url'); ?>
        <label>URL to link to</label>            
        <div class="input_container">
            <input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/></div>
        </div>
        <div class="cell">
            <label>Feature Content</label>
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
    <?php $i++; ?>
    <?php $mb->the_group_close(); ?>
    <?php endwhile; ?>
    </div>
</div>
<script>
jQuery(function($){
    $("#wpa_loop-tabs").sortable({
        change: function(){
            $("#warning").show();
        }
    });
});</script>
<?php } else {
    print "Select \"Front Page\" template and save to activate.";
} ?>
