<div class="cp_button">
	<a href="<?=$_base_url?>&amp;method=add_image" class="add-node close">Add an image to track</a>
</div>
<div style="clear: left;">
<?php

	$this->table->set_template($cp_table_template);
	$this->table->set_heading(
		array('data' => lang('id'), 'style' => 'width: 25px; text-align: center;')
		,
		lang('label'),
		lang('filename'),
		lang('tag'),
		lang('preview'),
		lang('delete')
	);
	foreach( $images as $image)
	{
		$this->table->add_row(
				$image['id'],
				$image['label'],
				$image['filename'],
				"<code>&lt;img src=&quot;".$_site_url."?ACT=".$action_id.AMP."id=".$image['id']."&quot; alt=&quot;&quot; /&gt;</code>",
				'<img src="'.$_site_url."?ACT=".$action_id.AMP."id=".$image['id'].AMP.'preview=1" style="max-width: 300px;" />',
				array('data' => '<a href="'.$_base_url.AMP.'method=delete'.AMP.'id='.$image['id'].'" class="delete_image_confirm">
					<img src="'.$this->cp->cp_theme_url.'images/icon-delete.png" /></a>', 'style' => 'width: 20px; text-align: center;')
			);
	}
	echo $this->table->generate();

?>
</div>