<?php global $rcl_box; ?>
<div class="rcl-content-box">
	<div class="field-icons">
		<a href="#" title="<?php _e('delete','wp-recall') ?>" onclick="return confirm('<?php _e('Are you sare?','wp-recall')?>')? rcl_delete_editor_box(this): false;" class="rcl-icon"><i class="fa fa-times"></i></a>
		<span class="rcl-icon move-box" title="<?php _e('move','wp-recall') ?>"><i class="fa fa-arrows"></i></span>
	</div>
	<?php if($rcl_box['content']): ?>
		<img class="aligncenter" src="<?php echo $rcl_box['content']; ?>">
		<input type="hidden" name="post_content[][image]" value="<?php echo $rcl_box['content']; ?>">
	<?php else: ?>
		<div id="rcl-upload-<?php echo $rcl_box['id_box']; ?>" class="rcl-upload-box">
                    <div class="rcl-icon-upload"><i class="fa fa-picture-o"></i></div>
                    <div class="recall-button rcl-upload-button">
                        <span><?php _e('Select an image','wp-recall'); ?></span>
                        <input class="rcl-box-uploader" name="editor_upload[]" type="file" accept="image/*" multiple>
                    </div>
                    <span><?php _e('or enter url image','wp-recall'); ?></span>
                    <input name="url_upload[]" class="upload-image-url" type="url">
		</div>
		<script> rcl_init_upload_box(<?php echo $rcl_box['id_box']; ?>); </script>
	<?php endif; ?>
</div>