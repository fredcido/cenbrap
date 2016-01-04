<?php

class Model_Mapper_Curso extends App_Model_Mapper_Abstract
{

	/**
	 * @var string
	 */
	const DOC_ENTREGUE = 'ENTREGUE';

    /**
     * 
     * @access public
     * @return array
     */
    public function listCursos()
    {
	try {

	    $auth = Zend_Auth::getInstance();
	    
	    $parameters = array(
		'usuario'   => $auth->getIdentity()->codigo
	    );
	    
	    // Cria hash de comunicacao
	    $parameters['hash'] = App_Util_Cenbrap::getHash( $parameters, array( 'usuario' ) );
	    
	    // Faz requisição para API
	    $response = App_Util_Cenbrap::request( 'ListUsuarios', $parameters );
	    
	    if ( empty( $response['status'] ) )
		throw new Exception( 'Erro ao listar cursos' );
	    
	    $cursos = array();
	    $nomeCursos = array();

	    foreach ( $response['curso'] as $key => $curso ) {

			if ( is_array($curso) ) {

				$cursos[ trim( $curso['descricao'] ) ] = $curso;
				$nomeCursos[ $curso['codigo'] ] = trim( $curso['descricao'] );

			} 

	    }

	    if ( empty($cursos) && !empty($response['curso']) ) {

	    	$cursos[ trim($response['curso']['descricao']) ] = $response['curso'];
	    	$nomeCursos[ $response['curso']['codigo'] ] = trim( $response['curso']['descricao'] );

	    }
	    
	    ksort( $cursos );
	    
	    // Salva cursos na sessao
	    $config 	= Zend_Registry::get( 'config' );
	    $session = new Zend_Session_Namespace( $config->geral->appid );
	    $session->cursos = $nomeCursos;
	    
	    return $cursos;

	} catch ( Exception $e ) {

	    $this->_message->addMessage( $e->getMessage(), App_Message::WARNING );
	    return array();
	}
    }
    
    /**
     * 
     * @access public
     * @return array
     */
    public function listDisciplinas( $curso )
    {
	try {

	    $auth = Zend_Auth::getInstance();
	    
	    $parameters = array(
		'usuario'   => $auth->getIdentity()->codigo,
		'curso'	    => $curso
	    );
	    
	    // Cria hash de comunicacao
	    $parameters['hash'] = App_Util_Cenbrap::getHash( $parameters, array_keys( $parameters ) );
	    
	    // Faz requisição para API
	    $response = App_Util_Cenbrap::request( 'ListDisciplinas', $parameters );
	    
	    if ( empty( $response['status'] ) )
		throw new Exception( 'Erro ao listar disciplinas' );
	    
	    $disciplinas = array();
	    foreach ( $response['disciplinas'] as $disciplina ) {
		
		$nome = trim( $disciplina['descricao'] );
		
		if ( strtoupper( $nome ) == 'A DEFINIR' )
		    continue;
		
		$disciplinas[ $nome ] = $disciplina;
	    }
	    
	    ksort( $disciplinas );
	    	    
	    return $disciplinas;

	} catch ( Exception $e ) {

	    $this->_message->addMessage( $e->getMessage(), App_Message::WARNING );
	    return array();
	}
    }
    
    /**
     * 
     * @access public
     * @return array
     */
    public function materialDidatico()
    {
	try {

	    $auth = Zend_Auth::getInstance();
	    
	    $parameters = array(
		'usuario'	=> $auth->getIdentity()->codigo,
		'curso'		=> $this->_data['curso'],
		'disciplina'	=> $this->_data['disciplina']
	    );
	    
	    // Cria hash de comunicacao
	    $parameters['hash'] = App_Util_Cenbrap::getHash( $parameters, array_keys( $parameters ) );
	
	    // Faz requisição para API
	    $response = App_Util_Cenbrap::request( 'MaterialDidatico', $parameters );
	    
	    if ( empty( $response['status'] ) )
		throw new Exception( 'Erro ao listar material didático' );
	    
	    $materiais = array();
	    $date = new Zend_Date();
	    foreach ( $response['material'] as $material ) {
		
		$date->setDate( $material['data'], 'dd/MM/yyyy' );
		$materiais[ $date->toString( 'yyyy-MM-dd' ) ][] = $material;
	    }
	    
	    ksort( $materiais );
	    $materiais = array_reverse( $materiais );
	    	    
	    return $materiais;

	} catch ( Exception $e ) {
	    
	    $this->_message->addMessage( $e->getMessage(), App_Message::WARNING );
	    return array();
	}
    }
    
    /**
     * 
     * @access public
     * @return array
     */
    public function encontrosNotasFrequencias( $filters = array() )
    {
	try {

	    $auth = Zend_Auth::getInstance();
	    
	    // Se nao tiver filtro
	    if ( empty( $filters['filtro'] ) )
		$filters['filtro'] = 0;
	    
	    $parameters = array(
		'usuario'	=> $auth->getIdentity()->codigo,
		'curso'		=> $filters['curso'],
		'filtro'	=> $filters['filtro']
	    );
	    
	    // Cria hash de comunicacao
	    $parameters['hash'] = App_Util_Cenbrap::getHash( $parameters, array_keys( $parameters ) );

	    // Faz requisição para API
	    $response = App_Util_Cenbrap::request( 'EncontrosNotasFrequencias', $parameters );

	    if ( empty( $response['status'] ) )
		throw new Exception( 'Erro ao listar encontros/notas/frequencias' );
	    
	    return $response['encontros'];

	} catch ( Exception $e ) {

	    $this->_message->addMessage( $e->getMessage(), App_Message::WARNING );
	    return array();
	    
	}
    }
    
    /**
     * 
     * @access public
     * @return array
     */
    public function listPendencias( $curso )
    {
	try {

	    $auth = Zend_Auth::getInstance();
	    
	    $parameters = array(
		'usuario'	=> $auth->getIdentity()->codigo,
		'curso'		=> $curso
	    );
	    
	    // Cria hash de comunicacao
	    $parameters['hash'] = App_Util_Cenbrap::getHash( $parameters, array_keys( $parameters ) );
	    
	    // Faz requisição para API
	    $response = App_Util_Cenbrap::request( 'Pendencias', $parameters );
	    
	    if ( empty( $response['status'] ) )
		throw new Exception( 'Erro ao listar pendências' );

		//Documentos pendentes
		$documentos = array();

		foreach ( $response['documentos'] as $documento ) {
			if ( self::DOC_ENTREGUE !== strtoupper($documento['situacao']) ) 
				array_push( $documentos, str_replace('>>', '', $documento['titulo']) );
		}
	    
	    //Disciplinas pendentes
	    $pendencias = array();
	    foreach ( $response['pendencias'] as $pendencia ) {
		
		if ( empty(  $pendencia['disponibilidade'] ) )
		    continue;
		
		if ( !empty( $pendencia['disponibilidade']['data_ini'] ) )
		    $pendencia['disponibilidade'] = array( $pendencia['disponibilidade'] );	

		$pendencias[$pendencia['disciplina']['codigo']] = $pendencia;
	    }
	    	    
	    return array( 'pendencias' => $pendencias, 'documentos' => $documentos );

	} catch ( Exception $e ) {

	    return array();
	}
    }
    
    /**
     * 
     * @access public
     * @return array
     */
    public function agendarEncontro()
    {
	try {

	    $auth = Zend_Auth::getInstance();
	    
	    $parameters = array(
		'usuario'	=> $auth->getIdentity()->codigo,
		'curso'		=> $this->_data['curso'],
		'disciplina'	=> $this->_data['disciplina'],
		'encontro'	=> $this->_data['encontro'],
		'email'		=> $this->_data['email'],
		'telefone'	=> $this->_data['telefone']
	    );
	    
	    // Cria hash de comunicacao
	    $parameters['hash'] = App_Util_Cenbrap::getHash( $parameters, array_keys( $parameters ) );
	    
	    // Faz requisição para API
	    $response = App_Util_Cenbrap::request( 'AgendarEncontro', $parameters );
	    
	    if ( empty( $response['status'] ) )
		throw new Exception( 'Erro ao agendar encontro' );
	    
	    if ( !empty( $response['message'] ) )
		$message = utf8_decode( $response['message'] );
	    else
		$message = 'Encontro agendado com sucesso';
	    
	    $this->_message->addMessage( $message, App_Message::SUCCESS );
	    return true;

	} catch ( Exception $e ) {

	    $this->_message->addMessage( utf8_decode( $e->getMessage() ), App_Message::ERROR );
	    return false;
	}
    }
    
    /**
     * 
     * @access public
     * @return array
     */
    public function rematricula()
    {
	try {

	    $auth = Zend_Auth::getInstance();
	    
	    $parameters = array(
		'usuario'	    => $auth->getIdentity()->codigo,
		'curso'		    => $this->_data['curso'],
		'nome'		    => $this->_data['nome'],
		'email'		    => $this->_data['email'],
		'email_recado'	    => $this->_data['email_recado'],
		'endereco'	    => $this->_data['endereco'],
		'bairro'	    => $this->_data['bairro'],
		'cidade'	    => $this->_data['cidade'],
		'estado'	    => $this->_data['estado'],
		'cep'		    => $this->_data['cep'],
		'ddd_contato'	    => $this->_data['ddd'],
		'telefone_contato'  => $this->_data['telefone'],
		'celular_contato'   => $this->_data['celular']
	    );
	    
	    // Cria hash de comunicacao
	    $parameters['hash'] = App_Util_Cenbrap::getHash( $parameters, array( 'usuario', 'curso' ) );
	    
	    // Faz requisição para API
	    $response = App_Util_Cenbrap::request( 'Rematricula', $parameters );
	    
	    if ( empty( $response['status'] ) )
		throw new Exception( 'Erro ao fazer rematricula' );
	    
	    $this->_message->addMessage( utf8_decode( $response['message'] ), App_Message::SUCCESS );
	    return true;

	} catch ( Exception $e ) {

	    $this->_message->addMessage( utf8_decode( $e->getMessage() ), App_Message::ERROR );
	    return false;
	}
    }
    
    /**
     * 
     * @access public
     * @return array
     */
    public function vagasEmprego()
    {
	try {

	    $auth = Zend_Auth::getInstance();
	    
	    $parameters = array(
		'usuario'	=> $auth->getIdentity()->codigo,
		'curso'		=> $this->_data['curso']
	    );
	    
	    // Cria hash de comunicacao
	    $parameters['hash'] = App_Util_Cenbrap::getHash( $parameters, array_keys( $parameters ) );
	    
	    // Faz requisição para API
	    $response = App_Util_Cenbrap::request( 'VagasEmprego', $parameters );
	    
	    if ( empty( $response['status'] ) )
		throw new Exception( 'Erro ao listar vagas de emprego' );
	    
	    $vagas = array();
	    $date = new Zend_Date();
	    foreach ( $response['avisos'] as $vaga ) {
		
		$date->setDate( $vaga['data'], 'dd/MM/yyyy' );
		$vagas[ $date->toString( 'yyyy-MM-dd' ) ][] = $vaga;
	    }
	    
	    ksort( $vagas );
	    $vagas = array_reverse( $vagas );
	    	    
	    return $vagas;

	} catch ( Exception $e ) {

	    return array();
	}
    }
    
    /**
     * 
     * @access public
     * @return array
     */
    public function menu()
    {
	try {

	    $auth = Zend_Auth::getInstance();
	    
	    $parameters = array(
		'usuario'	=> $auth->getIdentity()->codigo,
		'curso'		=> $this->_data['id']
	    );
	    
	    // Cria hash de comunicacao
	    $parameters['hash'] = App_Util_Cenbrap::getHash( $parameters, array_keys( $parameters ) );
	    
	    // Faz requisição para API
	    $response = App_Util_Cenbrap::request( 'Menu', $parameters );
	    
	    if ( empty( $response['status'] ) )
		throw new Exception( 'Erro ao listar verificar menu' );
	    	    
	    return $response['menu'];

	} catch ( Exception $e ) {

	    $this->_message->addMessage( $e->getMessage(), App_Message::ERROR );
	    return false;
	}
    }
    
    /**
     * 
     * @access public
     * @return array
     */
    public function legislacao()
    {
	try {

	    $auth = Zend_Auth::getInstance();
	    
	    $parameters = array(
		'usuario'	=> $auth->getIdentity()->codigo,
		'curso'		=> $this->_data['curso']
	    );
	    
	    // Cria hash de comunicacao
	    $parameters['hash'] = App_Util_Cenbrap::getHash( $parameters, array_keys( $parameters ) );
	    
	    // Faz requisição para API
	    $response = App_Util_Cenbrap::request( 'Legislacao', $parameters );
	    
	    if ( empty( $response['status'] ) )
		throw new Exception( 'Erro ao listar legislação' );
	    	    
	    return $response['legislacao'];

	} catch ( Exception $e ) {

	    return array();
	}
    }
}