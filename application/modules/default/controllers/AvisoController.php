<?php

class Default_AvisoController extends Zend_Controller_Action
{
    /**
     *
     * @var Model_Mapper_Aviso
     */
    protected $_mapper;
    
    /**
     * 
     * @see Zend_Controller_Action::init()
     */
    public function init()
    {
	$this->_mapper = new Model_Mapper_Aviso();
	
	$config 	= Zend_Registry::get( 'config' );
	$this->_session = new Zend_Session_Namespace( $config->geral->appid );
    }

    /**
     * 
     */
    public function indexAction()
    {
    }
    
    /**
     * 
     */
    public function paginatorAction()
    {
	$page = $this->_getParam( 'p' );
	
	if ( empty( $page ) ) {
	 
	    $avisos = $this->_mapper->listAvisos( $this->_session->curso, $page );
	    $this->_session->avisos = $avisos;
	    $page = 1;
	    
	} else
	    $avisos = $this->_session->avisos;
	
	$paginator = Zend_Paginator::factory( $avisos );
	$paginator->setCurrentPageNumber( $page );
	$paginator->setItemCountPerPage( 5 );
	
	$this->view->avisos = $paginator;
	$this->view->more = ( $page < $paginator->count() );
	$this->view->page = $page;
    }

    /**
     * 
     */
    public function readAction()
    {
       $params = $this->_getAllParams();
       $params['curso'] = $this->_session->curso;
       
       $aviso = $this->_mapper->setData( $params )->detalhaAviso();
       
       $this->view->aviso = $aviso;
    }
}