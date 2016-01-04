<?php

/**
 * 
 */
class Default_RecoveryController extends Zend_Controller_Action
{
	/**
	 * 
	 * @var Default_Form_Recovery
	 */ 
	protected $_form;

	/**
	 * 
	 * @access public
	 * @return void
	 */
	public function init()
	{
		$this->_helper->layout->disableLayout();

		$this->_form = new Default_Form_Recovery( array('action' => $this->_helper->url('send')) );
	}
	
	/**
	 * 
	 * @access public
	 * @return void
	 */
	public function indexAction()
	{
		$this->view->form = $this->_form;
	}	
	
	/**
	 * 
	 * @access public
	 * @return void
	 */
	public function sendAction()
	{
		$request = $this->getRequest();

		if ( $request->isPost() && $this->_form->isValid($request->getPost()) ) {

			$mapper = new Model_Mapper_Auth();
			$mapper->setData( $this->_form->getValues() );

			$result = array(
			    'valid'	=> $mapper->recovery(),
			    'message'	=> $mapper->getMessage()->toArray()
			);

		} else {

			$config = Zend_Registry::get('config');

			$message = new App_Message();
			$message->addMessage( $config->messages->warning, App_Message::WARNING );

			$result = array(
			    'valid'	=> false,
			    'message'	=> $message->toArray(),
			    'error'	=> $this->_form->getMessages()
			);

		}

		$this->_helper->json( $result );
	}
}