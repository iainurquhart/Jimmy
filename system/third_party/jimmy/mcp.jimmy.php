<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ExpressionEngine - by EllisLab
 *
 * @package		ExpressionEngine
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2003 - 2011, EllisLab, Inc.
 * @license		http://expressionengine.com/user_guide/license.html
 * @link		http://expressionengine.com
 * @since		Version 2.0
 * @filesource
 */
 
// ------------------------------------------------------------------------

/**
 * Jimmy Module Control Panel File
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Module
 * @author		Iain Urquhart
 * @link		http://iain.co.nz
 */

class Jimmy_mcp {
	
	public $return_data;
	
	private $_base_url;
	
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->EE =& get_instance();
		
		$this->_form_base_url 	= 'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=jimmy';
		$this->_base_url		= BASE.AMP.$this->_form_base_url;
		$this->_theme_base_url 	= $this->EE->config->item('theme_folder_url').'third_party/jimmy_assets/';
		$this->_site_id	 		= $this->EE->config->item('site_id');
		$this->_site_url		= $this->EE->functions->fetch_site_index();
		
		$this->EE->load->library('table');
		
		$this->EE->cp->set_right_nav(array(
			'module_home'	=> $this->_base_url
			// Add more right nav items here.
		));
	}
	
	// ----------------------------------------------------------------

	/**
	 * Index Function
	 *
	 * @return 	void
	 */
	public function index()
	{

		$vars = array();
		$image_ids = array();
		
		$images = $this->EE->db->get_where('jimmy_images', array('site_id' => $this->_site_id))->result_array();
		
		if(!$images)
			return $this->content_wrapper('manage_image', 'jimmy_module_name', $vars);

		foreach ($images as $image)
		{
			$vars['images'][ $image['id'] ]['id'] 		= $image['id'];
			$vars['images'][ $image['id'] ]['site_id'] 	= $image['site_id'];
			$vars['images'][ $image['id'] ]['label'] 	= $image['label'];
			$vars['images'][ $image['id'] ]['filename'] = $image['filename'];
		}
		
		$vars['action_id'] = $this->EE->cp->fetch_action_id('Jimmy', 'trigger_output');

		return $this->content_wrapper('index', 'jimmy_module_name', $vars);
	}

	/**
	 * Start on your custom code here...
	 */

	
	public function add_image()
	{
	
		if(!$this->EE->input->post('label'))
			return $this->content_wrapper('manage_image', 'jimmy_module_name', '');
	
		$data = array(
		   'site_id' 	=> $this->_site_id,
		   'label' 		=> $this->EE->input->post('label', TRUE),
		   'dir_id' 	=> $this->EE->input->post('dir_id', TRUE),
		   'filename' 	=> $this->EE->input->post('filename', TRUE)
		);
		
		$this->EE->db->insert('jimmy_images', $data);
		
		$this->EE->session->set_flashdata('message_success', lang('image_added'));
		$this->EE->functions->redirect($this->_base_url); 
		
	}
	
	
	public function delete()
	{
		
		$id = $this->EE->input->get('id');
		$this->EE->db->delete('jimmy_images', array('id' => $id)); 
		
		$this->EE->session->set_flashdata('message_success', lang('image_deleted'));
		$this->EE->functions->redirect($this->_base_url); 
		
	}
	 
	 
	function content_wrapper($content_view, $lang_key, $vars = array())
	{
		
		$vars['content_view'] = $content_view;
		$vars['_base_url'] = $this->_base_url;
		$vars['_form_base_url'] = $this->_form_base_url;
		$vars['_theme_base_url'] = $this->_theme_base_url;
		$vars['_site_url'] = $this->_site_url;
		$title_extra = (isset($vars['title_extra'])) ? ': '.$vars['title_extra'] : '';

		$this->EE->cp->set_variable('cp_page_title', lang($lang_key).$title_extra);
		$this->EE->cp->set_breadcrumb($this->_base_url, lang('jimmy_module_name'));

		return $this->EE->load->view('_wrapper', $vars, TRUE);
	}
	
}
/* End of file mcp.jimmy.php */
/* Location: /system/expressionengine/third_party/jimmy/mcp.jimmy.php */