<?php

class Model_Mapper_Usuario extends App_Model_Mapper_Abstract
{

    /**
     * 
     * @access public
     * @return array
     */
    public function alteraSenha()
    {
	try {

	    $auth = Zend_Auth::getInstance();
	    
	    $parameters = array(
		'usuario'   => $auth->getIdentity()->codigo,
		'senha'	    => trim( $this->_data['senha'] ),
		'novasenha' => trim( $this->_data['novasenha'] )
	    );
	    
	    // Cria hash de comunicacao
	    $parameters['hash'] = App_Util_Cenbrap::getHash( $parameters, array_keys( $parameters ) );
	    
	    // Faz requisição para API
	    $response = App_Util_Cenbrap::request( 'AlteraSenha', $parameters );
	    
	    if ( empty( $response['status'] ) )
		throw new Exception( 'Erro ao alterar senha do usuário' );
	   
	    return array( 'status' => true );

	} catch ( Exception $e ) {

	    return array( 'status' => false, 'msg' => $e->getMessage() );
	}
    }
    
    /**
     * 
     * @access public
     * @return array
     */
    public function recuperaDados()
    {
	try {

	    $auth = Zend_Auth::getInstance();
	    
	    $parameters = array(
		'usuario'   => $auth->getIdentity()->codigo,
		//'curso'	    => trim( $this->_data['curso'] )
	    );
	    
	    // Cria hash de comunicacao
	    $parameters['hash'] = App_Util_Cenbrap::getHash( $parameters, array_keys( $parameters ) );
	    
	    // Faz requisição para API
	    $response = App_Util_Cenbrap::request( 'RecuperaDados', $parameters );
	    
	    if ( empty( $response['status'] ) )
		throw new Exception( 'Erro ao recuperar dados do usuário' );
	    
	    foreach ( $response['dados'] as $key => $value )
		if ( empty( $value ) )
		    $response['dados'][$key] = null;
	   
	    return $response['dados'];

	} catch ( Exception $e ) {

	    return array( 'status' => false, 'msg' => $e->getMessage() );
	}
    }
    
    /**
     * 
     * @access public
     * @return array
     */
    public function atualizacaoDados()
    {
	try {

	    $auth = Zend_Auth::getInstance();
	    
	    $parameters = array(
		'usuario'	    => $auth->getIdentity()->codigo,
		'curso'		    => $this->_data['curso'],
		'nome'		    => $this->_data['nome'],
		'email'		    => $this->_data['email'],
		'email_recado'	    => $this->_data['email_apoio'],
		'rg'		    => $this->_data['rg'],
		'rg_emissao'	    => $this->_data['rg_emissor'],
		'senha'		    => $this->_data['senha'],
		'data_nascimento'   => $this->_data['data_nascimento'],
		'endereco'	    => $this->_data['endereco'],
		'bairro'	    => $this->_data['bairro'],
		'cidade'	    => $this->_data['cidade'],
		'estado'	    => $this->_data['estado'],
		'cep'		    => $this->_data['cep'],
		'ddd'		    => $this->_data['ddd'],
		'ddd_celular'	    => $this->_data['ddd_celular'],
		'telefone'	    => $this->_data['telefone'],
		'celular'	    => $this->_data['celular'],
		'formacao'	    => $this->_data['formacao'],
		'graduacao'	    => $this->_data['graduacao'],
		'instituicao'	    => $this->_data['instituicao'],
		'formacao_data'	    => $this->_data['formacao_data'],
		'profissao'	    => $this->_data['profissao'],
		'local_trabalho'    => $this->_data['local_trabalho']
	    );
	    
	    // Cria hash de comunicacao
	    $parameters['hash'] = App_Util_Cenbrap::getHash( $parameters, array( 'usuario', 'curso', 'nome' ) );
	    
	    // Faz requisição para API
	    $response = App_Util_Cenbrap::request( 'AtualizacaoDados', $parameters );
	    
	    if ( empty( $response['status'] ) )
		throw new Exception( 'Erro ao atualizar dados do usuário' );
	   
	    return true;

	} catch ( Exception $e ) {

	    $this->_message->addMessage( utf8_decode( $e->getMessage() ), App_Message::ERROR );
	    return false;
	}
    }
}