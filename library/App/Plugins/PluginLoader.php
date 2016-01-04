<?php

/**
 * 
 */
class App_Plugins_PluginLoader extends Zend_Controller_Plugin_Abstract
{
	/**
	 * 
	 * @var array
	 */
	private $_plugins = array();
	
	/**
	 * 
	 * @access 	public
	 * @param 	string $module
	 * @param 	string $pluginName
	 * @return 	void
	 */
	public function addPlugin( $module, $pluginName )
	{
		$module = strtolower($module);
		
		if ( !isset($this->_plugins[$module]) )
			$this->_plugins[$module] = array();
			
		$this->_plugins[$module][] = $pluginName;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Zend_Controller_Plugin_Abstract::routeShutdown()
	 */
	public function routeShutdown( Zend_Controller_Request_Abstract $request )
	{
		$module = strtolower( $request->getModuleName() );
		$front 	= Zend_Controller_Front::getInstance();
		
		//$module = empty( $module ) ? 'default' : $module;
		
		if ( empty($this->_plugins[$module]) )
			return;
			
		foreach ( $this->_plugins[$module] as $pluginName )
			$front->registerPlugin( new $pluginName() );
	}
}