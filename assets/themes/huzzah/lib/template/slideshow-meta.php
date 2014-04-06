<?php
    global $SlideDeckPlugin;
    $slidedecks = $SlideDeckPlugin->SlideDeck->get( null, 'post_title', 'ASC', 'publish' );
?>
<div class="my_meta_control" id="slideshow_metabox">
		<?php $mb->the_field('slideshow'); ?>
	<p><label><strong><?php _e( "Choose a SlideDeck", $namespace ); ?>:</strong><br />
    <select name="<?php $mb->the_name(); ?>" id="<?php $mb->the_id(); ?>" class="widefat">
        <?php foreach( (array) $slidedecks as $slidedeck ): ?>
        <option value="<?php echo $slidedeck['id']; ?>"<?php $mb->the_select_state($slidedeck['id']); ?>><?php echo $slidedeck['title']; ?></option>
        <?php endforeach; ?>
    </select>
    </label></p>
</div>