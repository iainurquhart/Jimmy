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
 * Jimmy Module Install/Update File
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Module
 * @author		Iain Urquhart
 * @link		http://iain.co.nz
 */

class Jimmy_upd {
	
	public $version = '0.1';
	
	private $EE;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->EE =& get_instance();
	}
	
	// ----------------------------------------------------------------
	
	/**
	 * Installation Method
	 *
	 * @return 	boolean 	TRUE
	 */
	public function install()
	{
	
		$mod_data = array(
			'module_name'			=> 'Jimmy',
			'module_version'		=> $this->version,
			'has_cp_backend'		=> "y",
			'has_publish_fields'	=> 'n'
		);
		
		$this->EE->db->insert('modules', $mod_data);
		
		// register our shizzle
		$data = array(
			'class'		=> 'Jimmy',
			'method'	=> 'trigger_output'
		);
		$this->EE->db->insert('actions', $data);
		
		
		// create our key table
		$this->EE->load->dbforge();
		
		$fields = array(
						'id' => array('type' => 'int',
									  'constraint' => '10',
									  'unsigned' => TRUE,
									  'auto_increment' => TRUE),

						'site_id' => array('type'	=> 'int', 
										   'constraint'	=> '10'),

						'label'	=> array('type' => 'varchar',
										 'constraint' => '250'),
						
						'filename'	=> array('type' => 'varchar',
										 'constraint' => '250')
						
						);
		
		$this->EE->dbforge->add_field($fields);
		$this->EE->dbforge->add_key('id', TRUE);
		$this->EE->dbforge->create_table('jimmy_images');
		unset($fields);
		
		// create our (basic) stats table
		$fields = array(
						'id' => array('type' => 'int',
									  'constraint' => '10',
									  'unsigned' => TRUE,
									  'auto_increment' => TRUE),
						
						'image_id' => array('type'	=> 'int', 
										   'constraint'	=> '10'),

						'timestamp' => array('type'	=> 'int', 
										   'constraint'	=> '10'),
										   
						'ip_address' => array('type'	=> 'varchar', 
										    			   'constraint'	=> '16'),
										    			   
						'user_agent' => array('type'	=> 'varchar', 
										    			   'constraint'	=> '120'),
										    			   
						'referer' => array('type'	=> 'text')
						);
		
		$this->EE->dbforge->add_field($fields);
		$this->EE->dbforge->add_key('id', TRUE);
		$this->EE->dbforge->create_table('jimmy_stats');
		unset($fields);
		

		
		return TRUE;
	}

	// ----------------------------------------------------------------
	
	/**
	 * Uninstall
	 *
	 * @return 	boolean 	TRUE
	 */	
	public function uninstall()
	{
		$mod_id = $this->EE->db->select('module_id')
								->get_where('modules', array(
									'module_name'	=> 'Jimmy'
								))->row('module_id');
		
		$this->EE->db->where('module_id', $mod_id)
					 ->delete('module_member_groups');
		
		$this->EE->db->where('module_name', 'Jimmy')
					 ->delete('modules');
		
		$this->EE->db->where('class', 'Jimmy');
		$this->EE->db->delete('actions');
		
		$this->EE->load->dbforge();
		$this->EE->dbforge->drop_table('jimmy_images');
		$this->EE->dbforge->drop_table('jimmy_stats');
		
		return TRUE;
	}
	
	// ----------------------------------------------------------------
	
	/**
	 * Module Updater
	 *
	 * @return 	boolean 	TRUE
	 */	
	public function update($current = '')
	{
		// If you have updates, drop 'em in here.
		return TRUE;
	}
	
}
/* End of file upd.jimmy.php */
/* Location: /system/expressionengine/third_party/jimmy/upd.jimmy.php */