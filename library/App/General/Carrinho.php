<?php

class App_General_Carrinho
{
    /**
     *
     * @var App_General_Carrinho
     */
    protected static $_instance;
    
    /**
     *
     * @var Zend_carrinho_Namespace
     */
    protected $_carrinho;
    
    /**
     *
     * @var int
     */
    protected $_time = 1200;
    
    /**
     *
     * @var Zend_Config
     */
    protected $_config;
    
    /**
     * 
     */
    private function __construct()
    {
	$this->_config = Zend_Registry::get( 'config' );
	
	$this->_carrinho = new Zend_Session_Namespace( $this->_getIdSession() );
	$this->_carrinho->setExpirationSeconds( $this->_time );
	
	if ( !isset( $this->_carrinho->produtos ) )
	    $this->_carrinho->produtos = array();
    }
    
    /**
     *
     * @return string
     */
    protected function _getIdSession()
    {
	return $this->_config->geral->appid . '_carrinho';
    }
    
    /**
     * 
     */
    public static function init()
    {
	if ( null === self::$_instance )
	    self::$_instance = new self();
    }
    
    /**
     *
     * @param Zend_Db_Table_Row $produto
     * @param type $qtde
     * @param type $opcao 
     */
    protected function addProduto( $produto, $qtde, $opcao )
    {
	if ( empty( $this->_carrinho->produtos[ $produto->id] ) )
	    $this->_carrinho->produtos[ $produto->id ] = array( 'produto' => $produto );
	
	if ( $produto->opcao == 1 ) {
	    
	    if ( empty( $this->_carrinho->produtos[ $produto->id]['opcoes'][ $opcao->id ] ) ) {
		
		$this->_carrinho->produtos[ $produto->id]['opcoes'][ $opcao->id ] = array(
		    'opcao' => $opcao,
		    'qtde'  => $qtde
		);
	    } else
		$this->_carrinho->produtos[ $produto->id ]['opcoes'][ $opcao->id ]['qtde'] += $qtde;
	    
	} else {
	    
	    // Verifica se ja existe qtde do produto
	    if ( empty( $this->_carrinho->produtos[ $produto->id]['qtde'] ) )
		$this->_carrinho->produtos[ $produto->id]['qtde'] = $qtde;
	    else
		$this->_carrinho->produtos[ $produto->id ]['qtde'] += $qtde;
	}
	
    }
    
    /**
     *
     * @param Zend_Db_Table_Row $produto 
     */
    protected function removeProduto( $produto )
    {
	unset( $this->_carrinho->produtos[ $produto->id ] );
    }
    
    /**
     *
     * @return float 
     */
    protected function getTotalCarrinho()
    {
	$total = 0;
	foreach ( $this->_carrinho->produtos as $produto ) {
	    
	    if ( $produto['produto']->opcao == 0 )
		$total += $produto['qtde'] * $produto['produto']->valor;
	    else {
		foreach ( $produto['opcoes'] as $opcao )
		    $total += $opcao['qtde'] * $opcao['opcao']->valor;
	    }
	}
	
	return $total;
    }
    
    /**
     *
     * @return array
     */
    protected function getItensCarrinho()
    {
	$itens = array();
	foreach ( $this->_carrinho->produtos as $produto ) {
	    
	    if ( $produto['produto']->opcao == 0 ) {
	    
		$itens[] = array(
		    'label' => $this->renderLabelProduto( $produto ),
		    'valor' => $this->renderValueProduto( $produto ),
		    'qtde'  => $produto['qtde']
		);
	    
	    } else {
		
		foreach ( $produto['opcoes'] as $opcao ) {
		    
		    $itens[] = array(
			'label' => $this->renderLabelOpcao( $produto, $opcao ),
			'valor' => $this->renderValorOpcao( $opcao ),
			'qtde'	=> $opcao['qtde']
		    );
		}
	    }
	}
	
	return $itens;
    }
    
    /**
     *
     * @return array
     */
    protected function getCartItens()
    {
	return $this->_carrinho->produtos;
    }
    
    /**
     *
     * @param Zend_Db_Table_Row $produto
     * @return string 
     */
    protected function renderLabelProduto( $produto )
    {
	return $produto['qtde'] . ' - ' . $produto['produto']->nome;
    }
    
    /**
     *
     * @param Zend_Db_Table_Row $produto
     * @return float 
     */
    protected function renderValueProduto( $produto )
    {
	$currency = new Zend_Currency();
	return $currency->toCurrency( (float)( $produto['qtde'] * $produto['produto']->valor ) );
    }
    
    /**
     *
     * @param Zend_Db_Table_Row $produto
     * @param Zend_Db_Table_Row $opcao
     * @return string 
     */
    protected function renderLabelOpcao( $produto, $opcao )
    {
	return $opcao['qtde'] . ' - ' . $produto['produto']->nome . ' ' . $opcao['opcao']->descricao;
    }
    
    /**
     *
     * @param Zend_Db_Table_Row $opcao
     * @return float 
     */
    protected function renderValorOpcao( $opcao )
    {
	$currency = new Zend_Currency();
	return $currency->toCurrency( (float)( $opcao['qtde'] * $opcao['opcao']->valor ) );
    }
    
    /**
     *
     * @param array $entrega 
     */
    protected function setEntrega( $entrega )
    {
	$this->_carrinho->entrega = $entrega;
    }
    
    /**
     *
     * @return array
     */
    protected function getEntrega()
    {
	return $this->_carrinho->entrega;
    }
    
    /**
     * 
     */
    protected function clearEntrega()
    {
	unset( $this->_carrinho->entrega );
    }
    
    /**
     *
     * @param int $pedido 
     */
    protected function setPedidoId( $pedido )
    {
	$this->_carrinho->pedido = $pedido;
    }
    
    /**
     *
     * @return int
     */
    protected function getPedidoId()
    {
	return $this->_carrinho->pedido;
    }
    
    /**
     * 
     */
    protected function clearPedidoId()
    {
	unset( $this->_carrinho->pedido );
    }
    
    /**
     * 
     */
    protected function clearAll()
    {
	$this->_carrinho->unsetAll();
    }
    
    /**
     *
     * @param Zend_Db_Table_Row $produto
     * @param int $qtde
     * @param Zend_Db_Table_Row $opcao 
     */
    public static function add( $produto, $qtde, $opcao )
    {
	self::init();
	self::$_instance->addProduto( $produto, $qtde, $opcao );
    }
    
    /**
     *
     * @param Zend_Db_Table_Row $produto 
     */
    public static function remove( $produto )
    {
	self::init();
	self::$_instance->removeProduto( $produto );
    }
    
    /**
     *
     * @return float
     */
    public static function getTotal()
    {
	self::init();
	return self::$_instance->getTotalCarrinho();
    }
    
    /**
     *
     * @return array
     */
    public static function getItens()
    {
	self::init();
	return self::$_instance->getItensCarrinho();
    }
    
    /**
     * 
     */
    public static function clear()
    {
	self::init();
	self::$_instance->clearAll();
    }
    
    /**
     *
     * @return array
     */
    public static function getNormalItens()
    {
	self::init();
	return self::$_instance->getCartItens();
    }
    
    /**
     *
     * @param array $address 
     */
    public static function setAddress( $address )
    {
	self::init();
	self::$_instance->setEntrega( $address );
    }
    
    /**
     *
     * @return array
     */
    public static function getAddress()
    {
	self::init();
	return self::$_instance->getEntrega();
    }
    
    /**
     * 
     */
    public static function clearAddress()
    {
	self::init();
	self::$_instance->clearEntrega();
    }
    /**
     *
     * @param int $pedido 
     */
    public static function setPedido( $pedido )
    {
	self::init();
	self::$_instance->setPedidoId( $pedido );
    }
    
    /**
     *
     * @return int
     */
    public static function getPedido()
    {
	self::init();
	return self::$_instance->getPedidoId();
    }
    
    /**
     * 
     */
    public static function clearPedido()
    {
	self::init();
	self::$_instance->clearPedidoId();
    }
    
    /**
     *
     * @return boolean
     */
    public static function hasPedido()
    {
	return !empty( self::$_instance->carrinho->pedido );
    }
}