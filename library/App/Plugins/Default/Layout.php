<?php

/**
 *
 */
class App_Plugins_Default_Layout extends Zend_Controller_Plugin_Abstract
{
    /**
     *
     * @var Zend_Controller_Request_Abstract
     */
    protected $_request;

    /**
     * (non-PHPdoc)
     * @see Zend_Controller_Plugin_Abstract::dispatchLoopStartup()
     */
    public function dispatchLoopStartup( Zend_Controller_Request_Abstract $request )
    {
        $this->_request = $request;
	
        $this->_configLayout();
        $this->_configView();

        $this->_includeJsController();
        $this->_includeCssController();
    }

    /**
     *
     * @access protected
     * @return void
     */
    protected function _configLayout()
    {
        Zend_Layout::getMvcInstance()->setLayoutPath( APPLICATION_PATH . '/modules/default/layouts/' );
    }

    /**
     *
     * @access protected
     * @return void
     */
    protected function _configView()
    {
        $view = Zend_Controller_Front::getInstance()->getParam( 'bootstrap' )->getResource( 'view' );

        //Title
        $view->headTitle( 'Cenbrap' );

        //Styles
        //$view->headLink()->appendStylesheet( $view->baseUrl( 'public/styles/default/style.css' ), '' );

        //Scripts
        //$view->headScript()->appendFile( $view->baseUrl( 'public/scripts/jquery.js' ) );
    }

    /**
     *
     * @access protected
     * @return void
     */
    protected function _includeJsController()
    {
        $ds = '/';
        //DIRECTORY_SEPARATOR;

        $file = 'public' . $ds . 'scripts' . $ds . $this->_request->getModuleName() . $ds . $this->_request->getControllerName() . '.js';

        if ( file_exists( APPLICATION_PATH . $ds . '..' . $ds . $file ) ) {
            $view = Zend_Controller_Front::getInstance()->getParam( 'bootstrap' )->getResource( 'view' );
            $view->headScript()->appendFile( $view->baseUrl( $file ) );
        }
    }

    /**
     *
     * @access protected
     * @return void
     */
    protected function _includeCssController()
    {
        $ds = '/';
        //DIRECTORY_SEPARATOR;

        $file = 'public' . $ds . 'styles' . $ds . $this->_request->getModuleName() . $ds . $this->_request->getControllerName() . '.css';

        if ( file_exists( APPLICATION_PATH . $ds . '..' . $ds . $file ) ) {
            $view = Zend_Controller_Front::getInstance()->getParam( 'bootstrap' )->getResource( 'view' );
            $view->headLink()->appendStylesheet( $view->baseUrl( $file ) );
        }
    }

}