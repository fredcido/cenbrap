<?php

/**
 * @version $Id $
 */
class Default_LancamentoController extends Zend_Controller_Action
{

    /**
     * @access public
     * @return void
     */
    public function init()
    {
	$config = Zend_Registry::get( 'config' );
	$this->_session = new Zend_Session_Namespace( $config->geral->appid );
    }

    /**
     * @access public
     * @return void
     */
    public function indexAction()
    {
    	$params = array();

    	$params['curso'] = $this->_session->curso;

    	if ( $this->getRequest()->isPost() ) {
    	    
            $post = $this->getRequest()->getPost();
            
    	    $params['filtro'] = $post['filtro'];

    	} else {

            $params['filtro'] = 1;

        }

        $mapper = new Model_Mapper_Curso();

        $this->view->data = $mapper->encontrosNotasFrequencias( $params );

    	$this->view->form = new Default_Form_Lancamento( array('action' => $this->_helper->url( 'index' )) );
    }

}