<?php 

/**
 * @version $Id $
 */
class Default_MaterialDidaticoController extends Zend_Controller_Action
{
	/**
	 * @access public
	 * @return void
	 */ 
	public function init()
	{
	    $config 	= Zend_Registry::get( 'config' );
	    $this->_session = new Zend_Session_Namespace( $config->geral->appid );
	}

	/**
	 * @access public
	 * @return void
	 */ 
	public function indexAction()
	{
	    $mapperCurso = new Model_Mapper_Curso();
	    $disciplinas = $mapperCurso->listDisciplinas( $this->_session->curso );
	    
	    $opt = array();
	    foreach ( $disciplinas as $disciplina )
		$opt[$disciplina['codigo']] = $disciplina['descricao'];
	    
	    $form = new Default_Form_MaterialDidatico( array('action' => $this->_helper->url('send')) );
	    $form->getElement( 'disciplina' )->addMultiOptions( $opt );
	    
	    $this->view->form = $form;
	}

	/**
	 * @access public
	 * @return void
	 */ 
	public function sendAction()
	{
	    if ( !$this->getRequest()->isPost() )
		$this->_helper->redirector->goToSimple( 'index' );
		
	    $post = $this->getRequest()->getPost();

	    $mapperCurso = new Model_Mapper_Curso();
	    $post['curso'] = $this->_session->curso;

	    $this->view->data = $mapperCurso->setData( $post )->materialDidatico();
	}
}