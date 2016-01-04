<?php

/**
 * @version $Id $
 */
class Default_PerfilController extends Zend_Controller_Action
{

    /**
     * @var Model_Mapper_Usuario
     */
    protected $_mapper;

    /**
     * @var Default_Form_Perfil
     */
    protected $_form;

    /**
     * @access public
     * @return void 
     */
    public function init()
    {
	$this->_form = new Default_Form_Perfil( array('action' => $this->_helper->url( 'send' )) );
	
	$this->_mapper = new Model_Mapper_Usuario();
	
	$config 	= Zend_Registry::get( 'config' );
	$this->_session = new Zend_Session_Namespace( $config->geral->appid );
    }

    /**
     * @access public
     * @return void 
     */
    public function indexAction()
    {
	$params = $this->_getAllParams();
	$params['curso'] = $this->_session->curso;
	
	$dados = $this->_mapper->setData( $params )->recuperaDados();
	$this->_form->populate( $dados );
	
	$this->view->form = $this->_form;
    }

    /**
     * @access public
     * @return void
     */
    public function sendAction()
    {
	$request = $this->getRequest();

	if ( $request->isPost() && $this->_form->isValid( $request->getPost() ) ) {
	    
	    $values = $this->_form->getValues();
	    $values['curso'] = $this->_session->curso;
	    
	    $retorno = $this->_mapper->setData( $values )->atualizacaoDados();
	    
	    $result = array(
		'valid'	    => (bool)$retorno,
		'message'   => $this->_mapper->getMessage()->toArray()
	    );
	    
	} else {

	    $config = Zend_Registry::get( 'config' );

	    $message = new App_Message();
	    $message->addMessage( $config->messages->warning, App_Message::WARNING );

	    $result = array(
		'valid' => false,
		'message' => $message->toArray(),
		'error' => $this->_form->getMessages()
	    );
	}

	$this->_helper->json( $result );
    }

}