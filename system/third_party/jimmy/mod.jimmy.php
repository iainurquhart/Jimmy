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
 * Jimmy Module Front End File
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Module
 * @author		Iain Urquhart
 * @link		http://iain.co.nz
 */

class Jimmy {
	
	public $return_data;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->EE =& get_instance();
	}
	
	// ----------------------------------------------------------------

	/**
	 * Start on your custom code here...
	 */
	 
	 
	function trigger_output()
	{
		$this->EE->load->library('user_agent');
		$this->EE->load->library('filemanager');
		$this->EE->load->helper('file');
		
		$image_id = (int) $this->EE->input->get('id');
		$preview = $this->EE->input->get('preview');
		
		// don't record robots, or previews
		// @todo restrict by ip
		if( $image_id && $this->EE->agent->is_robot() == FALSE && !$preview )
		{
			$data = array(
			   'image_id' 	=> $image_id,
			   'timestamp' 	=> $this->EE->localize->now,
			   'ip_address' => $this->EE->input->ip_address(),
			   'user_agent' => $this->EE->input->user_agent(),
			   'referer' 	=> $this->EE->agent->referrer() // stores the url where the image was rendered
			);
			$this->EE->db->insert('jimmy_stats', $data); 
		}
		
		$img_info = $this->EE->db->get_where('jimmy_images', array('id' => $image_id));
		$file 	  = PATH_THEMES . 'third_party/jimmy/images/' . $img_info->row('filename');
		
		if( file_exists($file) )
		{	
			header('Content-Type:' . get_mime_by_extension($file));
			header('Content-Length: ' . filesize($file));
			readfile($file);
		}
		else
		{
			// echo 'no file';
		}
		exit();
	}
	
}
/* End of file mod.jimmy.php */
/* Location: /system/expressionengine/third_party/jimmy/mod.jimmy.php */