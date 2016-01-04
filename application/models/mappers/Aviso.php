<?php

class Model_Mapper_Aviso extends App_Model_Mapper_Abstract
{

    /**
     * 
     */
    public function listAvisos( $curso )
    {
	try {

	    $auth = Zend_Auth::getInstance();
	    
	    $parameters = array(
		'usuario'   => $auth->getIdentity()->codigo,
		'curso'	    => $curso
	    );
	    
	    // Cria hash de comunicacao
	    $parameters['hash'] = App_Util_Cenbrap::getHash( $parameters, array( 'usuario', 'curso' ) );
	    
	    // Faz requisição para API
	    $response = App_Util_Cenbrap::request( 'MuralAvisos', $parameters );
	    
	    if ( empty( $response['status'] ) )
		throw new Exception( 'Erro ao listar mural de avisos' );
	    
	    $avisos = array();
	    $date = new Zend_Date();
	    foreach ( $response['avisos'] as $aviso ) {
			if ( !empty($aviso['data']) ) {
				$date->setDate( $aviso['data'], 'dd/MM/yyyy' );
				$avisos[ $date->toString( 'yyyy-MM-dd' ) ][] = $aviso;
			}
	    }
	    	    
	    ksort( $avisos );
	    
	    $avisos = array_reverse( $avisos );
	    
	    return $avisos;

	} catch ( Exception $e ) {

	    $this->_message->addMessage( $e->getMessage(), App_Message::WARNING );
	    return array();
	}
    }
    
    /**
     * 
     */
    public function detalhaAviso()
    {
	try {

	    $auth = Zend_Auth::getInstance();
	    
	    $parameters = array(
		'usuario'   => $auth->getIdentity()->codigo,
		'curso'	    => $this->_data['curso'],
		'aviso'	    => $this->_data['id']
	    );
	    
	    // Cria hash de comunicacao
	    $parameters['hash'] = App_Util_Cenbrap::getHash( $parameters, array( 'usuario', 'curso', 'aviso' ) );
	    
	    // Faz requisição para API
	    $response = App_Util_Cenbrap::request( 'DetalhaAviso', $parameters );
	    
	    if ( empty( $response['status'] ) )
		throw new Exception( 'Erro ao detalhar aviso' );
	     
	    return $response['avisos'];

	} catch ( Exception $e ) {

	    $this->_message->addMessage( $e->getMessage(), App_Message::WARNING );
	    return array();
	}
    }
}