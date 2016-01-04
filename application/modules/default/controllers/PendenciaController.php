<?php

/**
 * @version $Id $
 */
class Default_PendenciaController extends Zend_Controller_Action
{

    /**
     *
     * @var Model_Mapper_Curso
     */
    protected $_mapper;
    
    /**
     * @access public
     * @return void
     */
    public function init()
    {
	$config 	= Zend_Registry::get( 'config' );
	$this->_session = new Zend_Session_Namespace( $config->geral->appid );
	
	$this->_mapper = new Model_Mapper_Curso();
    }

    /**
     * @access public
     * @return void
     */
    public function indexAction()
    {
	$data = $this->_mapper->listPendencias( $this->_session->curso );

	//$this->_session->pendencias = $data['pendencias'];
	$this->view->pendencias = $data['pendencias'];
	$this->view->documentos = $data['documentos'];
    }

    /**
     * @access public
     * @return void
     */
    public function cursoAction()
    {
	$pendencia = $this->_getParam( 'p' );
	//$disponibilidades = $this->_session->pendencias[$pendencia];

	$data = $this->_mapper->listPendencias( $this->_session->curso );

	$disponibilidades = $data['pendencias'][$pendencia];
		
	if ( empty( $disponibilidades ) )
	    $this->_helper->redirector->goToSimple( 'index' );

	$this->view->pendencia = $disponibilidades;
	$this->view->disponibilidades = $disponibilidades['disponibilidade'];
    }

    /**
     * @access public
     * @return void
     */
    public function formAction()
    {
		$this->_helper->layout->disableLayout();

		$params['curso'] 		= $this->_getParam( 'c' );
		$params['disciplina'] 	= $this->_getParam( 'd' );
		$params['encontro'] 	= $this->_getParam( 'e' );
		
		$form = new Default_Form_Pendencia( array('action' => $this->_helper->url( 'send' )) );
		
		$mapperUsuario = new Model_Mapper_Usuario();
		$dados = $mapperUsuario->recuperaDados();

		$form->populate( array_merge($dados, $params) );

		$this->view->form = $form;
    }

    /**
     * @access public
     * @return void
     */
    public function sendAction()
    {
	$form = new Default_Form_Pendencia( array('action' => $this->_helper->url( 'send' )) );
	
	$request = $this->getRequest();

	if ( $request->isPost() && $form->isValid( $request->getPost() ) ) {

	    $mapperCurso = new Model_Mapper_Curso();

	    $values = $form->getValues();
	  
	    $retorno = $mapperCurso->setData( $values )->agendarEncontro();

	    $result = array(
		'valid'	    => (bool)$retorno,
		'message'   => $mapperCurso->getMessage()->toArray()
	    );
	    
	} else {

	    $config = Zend_Registry::get( 'config' );

	    $message = new App_Message();
	    $message->addMessage( $config->messages->warning, App_Message::WARNING );

	    $result = array(
		'valid'	    => false,
		'message'   => $message->toArray(),
		'error'	    => $form->getMessages()
	    );
	}

	$this->_helper->json( $result );
    }

}