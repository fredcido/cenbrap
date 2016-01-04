<?php

/**
 * 
 * @version $Id: Auth.php 33 2013-03-21 22:52:35Z fred $
 */
class App_Plugins_Auth extends Zend_Controller_Plugin_Abstract
{

    /**
     *
     * @var Zend_Controller_Request_Abstract 
     */
    protected $_request;

    /**
     *
     * @var Zend_Auth
     */
    protected $_auth;

    /**
     *
     * @var Zend_Config
     */
    protected $_config;

    /**
     *
     * @var array
     */
    protected $_noAuth = array(
	'module'	=> 'default',
	'controller'	=> 'auth',
	'action'	=> 'index'
    );

    /**
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
	$this->_auth = Zend_Auth::getInstance();
	$this->_config = Zend_Registry::get( 'config' );

	$session = 'Auth_' . ucfirst( $this->_config->geral->appid );

	$this->_auth->setStorage( new Zend_Auth_Storage_Session( $session ) );
    }

    /**
     *
     * @access public
     * @param Zend_Controller_Request_Abstract $request
     * @return mixed 
     */
    public function dispatchLoopStartup( Zend_Controller_Request_Abstract $request )
    {
	$this->_request = $request;

	switch ( true ) {

	    case $this->_checkRoute( 'auth', 'default' ):
	    case $this->_checkRoute( 'recovery', 'default' ):
		return true;
		break;

	    case!$this->_auth->hasIdentity():
		$this->_routeNoAuth();
		break;
	}
    }

    /**
     * 
     * @access protected
     * @return void
     */
    protected function _routeNoAuth()
    {
	$path = $this->_request->getRequestUri();

	$session = new Zend_Session_Namespace( $this->_config->geral->appid );

	$this->_setRoute( $this->_noAuth );
    }

    /**
     * 
     * @access protected
     * @param array $route
     */
    protected function _setRoute( array $route )
    {
	$this->_request->setModuleName( $route['module'] );
	$this->_request->setControllerName( $route['controller'] );
	$this->_request->setActionName( $route['action'] );
    }

    /**
     * 
     * @access protected
     * @param string $controller
     * @param string|null $module
     * @param string|null $action
     * @return boolean 
     */
    protected function _checkRoute( $controller, $module = null, $action = null )
    {
	$valid = $controller == $this->_request->getControllerName();

	if ( $module )
	    $valid = $valid && $module == $this->_request->getModuleName();

	if ( $action )
	    $valid = $valid && $action == $this->_request->getActionName();

	return $valid;
    }

}