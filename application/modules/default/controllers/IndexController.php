<?php

/**
 * @version $Id: IndexController.php 121 2013-07-11 06:27:41Z josecarlos $
 */ 
class Default_IndexController extends Zend_Controller_Action
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
        $cursos = $this->_mapper->listCursos();

        if ( 1 === count($cursos) ) {

            $curso = current( $cursos );

            $this->_forward( 'menu', null, null, array('id' => $curso['codigo']) );

        } else {

            $this->view->cursos = $cursos;

            $this->view->noBack = true;

        }
    }

    /**
     * @access public
     * @return void
     */ 
    public function menuAction()
    {
	$id = $this->_getParam( 'id' );
	$this->_session->curso = $id;
	$this->view->menu = $this->_mapper->setData( $this->_getAllParams() )->menu();
	$this->view->nome_curso = $this->_session->cursos[$id];
    }
}