
<?php
	echo form_open($_form_base_url.AMP.'method=add_image');
	
	$this->table->set_template($cp_table_template);
	$this->table->set_heading(
		lang('option'),
		lang('value')
	);
	
	$this->table->add_row(
			lang('label'),
			form_input('label', '')
		);
	
	$this->table->add_row(
			lang('filename'),
			form_input('filename', '')
		);
	
	$this->table->add_row(
			'',
			form_submit('submit', lang('submit'))
		);
	
	echo $this->table->generate();

?>