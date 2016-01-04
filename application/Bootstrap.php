<?php

/**
 * 
 * @version $Id: Bootstrap.php 788 2012-07-30 20:44:13Z fred $
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    
    /**
     * 
     * @access protected
     * @return void
     */
    protected function _initConfig()
    {
	$config = new Zend_Config_Ini( APPLICATION_PATH . '/configs/config.ini' );

	Zend_Registry::set( 'config', $config );
    }
}