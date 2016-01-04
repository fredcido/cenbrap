<?php

class Model_Mapper_Auth extends App_Model_Mapper_Abstract
{

    /**
     * Verifica autenticacao do usuario
     * 
     * @access public
     * @return boolean
     */
    public function login()
    {
	$valid = false;

	try {

	    $auth = Zend_Auth::getInstance();
	    
	    $parameters = array(
		'login'	=> $this->_data['usuario'],
		'senha'	=> $this->_data['senha'],
		'hash'	=> App_Util_Cenbrap::getHash( $this->_data, array( 'usuario', 'senha' ) )
	    );
	    
	    
	    // Faz requisição para API
	    $response = App_Util_Cenbrap::request( 'Login', $parameters );
	    
	    if ( empty( $response['status'] ) )
		throw new Exception( 'E-mail ou senha inválidos' );
	    
	    $path = Zend_Controller_Front::getInstance()->getBaseUrl();
	    $path2 = $path . '/auth/';
	    
	    setcookie( 'email_cenbrap', $this->_data['usuario'], 0, $path );
	    setcookie( 'email_cenbrap', $this->_data['usuario'], 0, $path2 );
	    
	    $auth->getStorage()->write( (object)$response['aluno'] );

	   return true;

	} catch ( Exception $e ) {

	    $this->_message->addMessage( utf8_decode( 'Usuário inválido' ), App_Message::WARNING );

	    $auth->getStorage()->clear();
	    $auth->clearIdentity();
	}

	return $valid;
    }

    /**
     * Ativa opcao para recuperar senha e solicita confirmacao do usuario
     * 
     * @access public
     * @return boolean
     */
    public function recovery()
    {
	try {

	    $parameters = array(
		'email'	=> trim( $this->_data['usuario'] )
	    );
	    
	    // Cria hash de comunicacao
	    $parameters['hash'] = App_Util_Cenbrap::getHash( $parameters, array_keys( $parameters ) );
	    
	    // Faz requisição para API
	    //$response = App_Util_Cenbrap::request( 'RecuperaSenha', $parameters );

	    if ( empty( $response['status'] ) )
		throw new Exception( 'Erro ao recuperar senha' );
	   
	    return true;

	} catch ( Exception $e ) {

	    $this->_message->addMessage( $e->getMessage(), App_Message::ERROR );
	    return false;
	}
    }
}