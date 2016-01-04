<?php

/**
 * 
 */
class Default_NoticiaController extends Zend_Controller_Action
{

    /**
     *
     * @var Model_Mapper_Noticia
     */
    protected $_mapper;
    
    /**
     * @access public
     * @return void 
     */
    public function init()
    {
	$this->_mapper = new Model_Mapper_Noticia();
    }

    /**
     * @access public
     * @return void
     */
    public function indexAction()
    {
    	$this->view->noticias = $this->_mapper->listNews();
    }

}