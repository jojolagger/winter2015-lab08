<?php

/**
 * core/MY_Controller.php
 *
 * Default application controller
 *
 * @author		JLP
 * @copyright           2010-2013, James L. Parry
 * ------------------------------------------------------------------------
 */
class Application extends CI_Controller {

    protected $data = array();      // parameters for view components
    protected $id;                  // identifier for our content

    /**
     * Constructor.
     * Establish view parameters & load common helpers
     */

    function __construct() {
        parent::__construct();
        $this->data = array();
        $this->data['title'] = "Top Secret Government Site";    // our default title
        $this->errors = array();
        $this->data['pageTitle'] = 'welcome';   // our default page
    }

    /**
     * Render this page
     */
    function render() {
		$this->data['menudata'] = $this->makemenu();
		$this->data['menubar'] = $this->parser->parse('_menubar', $this->data,true);
        $this->data['content'] = $this->parser->parse($this->data['pagebody'], $this->data, true);
		$this->data['sessionid'] = session_id();

        // finally, build the browser page!
        $this->data['data'] = &$this->data;
        $this->parser->parse('_template', $this->data);
    }

	function restrict($roleNeeded = null) {
		
		if ($roleNeeded != null) {
			if (is_array($roleNeeded)) {
				if (!in_array($userRole, $roleNeeded)) {
					redirect("/");
					return;
				}
			} else if ($userRole != $roleNeeded) {
				redirect("/");
				return;
			}
		}
	}
	
	function makemenu() {
		$userRole = $this->session->userdata('userRole');
		$userName = $this->session->userdata('name');
		$menudata = array();
		// make array, with menu choice for alpha
		$menudata[] = array('name' => "Alpha", 'link' => '/alpha');
		// if not logged in, add menu choice to login
		if($userRole == null){
			$menudata[] = array('name' => "Login", 'link' => '/auth');
		}
		// if user, add menu choice for beta and logout
		if($userRole == ROLE_USER){
			$menudata[] = array('name' => "Beta", 'link' => '/beta');
			$menudata[] = array('name' => "Logout", 'link' => '/auth/logout');
		}
		// if admin, add menu choices for beta, gamma and logout
		if($userRole == ROLE_ADMIN){
			$menudata[] = array('name' => "Beta", 'link' => '/beta');
			$menudata[] = array('name' => "Gamma", 'link' => '/gamma');
			$menudata[] = array('name' => "Logout", 'link' => '/auth/logout');
		}
		return $menudata;
	}


	
}

/* End of file MY_Controller.php */
/* Location: application/core/MY_Controller.php */