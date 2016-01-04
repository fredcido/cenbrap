<?php

/**
 * @version $Id $
 */
class Default_LegislacaoController extends Zend_Controller_Action
{

    /**
     * @var Model_Mapper_Curso
     */
    protected $_mapper;

    /**
     * @access public
     * @return void
     */
    public function init()
    {
	$this->_mapper = new Model_Mapper_Curso();
	
	$config 	= Zend_Registry::get( 'config' );
	$this->_session = new Zend_Session_Namespace( $config->geral->appid );
    }

    /**
     * @access public
     * @return void
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
	    
	    $params = $this->_getAllParams();
	    $params['curso'] = $this->_session->curso;

	    $vagas = $this->_mapper->setData( $params )->legislacao();
	    $this->_session->vagas = $vagas;
	    $page = 1;
	    
	} else
	    $vagas = $this->_session->vagas;
	
	$paginator = Zend_Paginator::factory( $vagas );
	$paginator->setCurrentPageNumber( $page );
	$paginator->setItemCountPerPage( 5 );
	
	$this->view->legislacao = $paginator;
	$this->view->more = ( $page < $paginator->count() );
	$this->view->page = $page;
    }

}