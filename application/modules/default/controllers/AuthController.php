<?php

/**
 * @version $Id $
 */ 
class Default_AuthController extends Zend_Controller_Action
{

    /**
     *
     * @var Model_Mapper_Auth 
     */
    protected $_mapper;
    
    /**
     *
     * @var Default_Form_Auth 
     */
    protected $_formAuth;
    
    /**
     *
     * @var Zend_Config
     */
    protected $_config;
    
    /**
     * 
     * @access public
     * @return void
     */
    public function init()
    {
    	$this->_mapper = new Model_Mapper_Auth();
    	$this->_config = Zend_Registry::get( 'config' );
    }

    /**
     * 
     * @access public
     * @return void
     */
    public function indexAction()
    {
	   $this->view->form = $this->_getFormAuth();
	   
	   if ( !empty( $_COOKIE['email_cenbrap'] ) )
	       $this->view->form->getElement( 'usuario' )->setValue( $_COOKIE['email_cenbrap'] );
    }
    
    /**
     * 
     * @access protected
     * @return Default_Form_Auth
     */
    protected function _getFormAuth()
    {
    	if ( is_null( $this->_formAuth ) ) {

    	    $this->_formAuth = new Default_Form_Auth(
    			array(
    				'action' => $this->_helper->url( 'login' ),
    				'method' => Zend_Form::METHOD_POST
    			)
    	    );
    	}

    	return $this->_formAuth;
    }

    /**
     * 
     * @access public
     * @return void
     */
    public function loginAction()
    {
    	if ( $this->getRequest()->isPost() ) {

    	    $form = $this->_getFormAuth();

    	    if ( $form->isValid( $this->getRequest()->getPost() ) ) {

    		$mapper = new Model_Mapper_Auth();
    		$mapper->setData( $form->getValues() );

    		$result = array(
    		    'valid'	=> $mapper->login(),
    		    'message'	=> $mapper->getMessage()->toArray()
    		);
    		
    	    } else {

    		$message = new App_Message();
    		$message->addMessage( $this->_config->messages->warning, App_Message::WARNING );

    		$result = array(
    		    'valid'	=> false,
    		    'message'	=> $message->toArray(),
    		    'error'	=> $form->getMessages()
    		);
    	    }

    	    $this->_helper->json( $result );
    	}
    }

    /**
     * @access public
     * @return void
     */
    public function logoutAction()
    {
        $auth = Zend_Auth::getInstance();

        if ( $auth->hasIdentity() ) {
            $auth->getStorage()->clear();
            $auth->clearIdentity();
        }

        $this->_helper->json( array('valid' => true) );
    }
}