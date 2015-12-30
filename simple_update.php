<?php
class Simple_Update extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->events->add_filter( 'admin_menus', array( $this, 'menus' ) );
		$this->events->add_action( 'load_dashboard', array( $this, 'dashboard' ) );
	}
	function menus( $menus )
	{
		$menus[ 'simple_update' ]	=	array(
			array(
				'title'	=>	'Simple Update',
				'href'	=>	site_url( array( 'dashboard', 'simple_update' ) )
			)
		);
		return $menus;
	}
	function dashboard()
	{
		$this->gui->register_page( 'simple_update', array( $this, 'update_home' ) );
	}
	function update_home()
	{
		$this->load->view( '../modules/simple_update/views/home' );    
	}
}
new Simple_Update;