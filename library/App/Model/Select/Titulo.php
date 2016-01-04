<?php

/**
 * 
 */
class App_Model_Select_Titulo 
{
    /**
     * Colunas padrao da consulta padrao de titulo
     * 
     * @var array
     */
    protected $_columns = array();
    
    /**
     * 
     * @access public
     * @param int $usuario
     * @param array $columns
     * @return void
     */
    public function __construct( $usuario = null, array $columns = null )
    {
        if ( is_null($columns) ) 
            $this->_setDefaultColumns( $usuario );    
        else
            $this->_columns = $columns;
    }

    /**
     * 
     * @access public
     * @param array $columns
     * @return void
     */    
    public function addColumn( array $columns )
    {
        foreach ( $columns as $alias => $column ) {
        
            if ( is_numeric($alias) )  
                array_push( $this->_columns, $column );
            else 
                $this->_columns[$alias] = $column;
            
        }
	
	return $this;
    }
    
    /**
     * 
     * @access public
     * @param bool $isGroup
     * @return Zend_Db_Select
     */
    public function get( $isGroup = true )
    {
        $dbTitulo       = App_Model_DbTable_Factory::get( 'Titulo' );
        $dbCopiaFilme   = App_Model_DbTable_Factory::get( 'CopiaFilme' );
        $dbLojasSite    = App_Model_DbTable_Factory::get( 'LojasSite' );
        
        $select = $dbTitulo->select()
            ->setIntegrityCheck( false )
            ->from( 
                $dbTitulo->__toString(), 
                $this->_columns 
            )
            ->join(
                $dbCopiaFilme->__toString(),
                'copiafilme.titulo = titulo.codigo',
                array()
            )
            ->join(
                $dbLojasSite->__toString(),
                'lojas_site.codigo_loja = copiafilme.loja',
                array()
            )
			//->where( 'copiafilme.status = ?', '' )
			->where( 'lojas_site.status = ?', 1 );
            
        if ( $isGroup )
            $select->group( 'titulo.codigo' );
        
        return $select;
    }
    
    /**
     * 
     * @access protected 
     * @param int $usuario
     * @return void
     */
    protected function _setDefaultColumns( $usuario )
    {
        $this->addColumn( array('codigo', 'nome', 'capa') );
        
        $this->_addColumnAvaliacao( $usuario );
        $this->_addColumnDesejo();
        $this->_addColumnParental();
    }
    
    /**
     * Coluna de avaliacao 
     * 
     * @access protected
     * @access int $usuario
     * @return void
     */
    protected function _addColumnAvaliacao( $usuario )
    {
        $subSelect = App_Model_Select_Avaliacao::get( 'titulo.codigo', $usuario );
        
        $this->addColumn( 
            array( 
                'nota' => new Zend_Db_Expr( '(' . $subSelect . ')' ),
            ) 
        );
    }

    /**
     * Coluna de desejo
     * 
     * @access protected
     * @return void
     */
    protected function _addColumnDesejo()
    {
        if ( Zend_Auth::getInstance()->hasIdentity() ) {
                
            $dbDesejo = App_Model_DbTable_Factory::get( 'Desejo' );
                
            $subSelect = $dbDesejo->select()
                ->from(
                    $dbDesejo->__toString(),
                    array( new Zend_Db_Expr('COUNT(1)') )
                )
                ->where( 'desejo.codigo_titulo = titulo.codigo' )
                ->where( 'desejo.codigo_usuario = ?', Zend_Auth::getInstance()->getIdentity()->codigo );
                    
            $this->addColumn(
                array(
                    'desejo' => new Zend_Db_Expr( '(' . $subSelect . ')' )
                )
            );
                
        } else {
                
            $this->addColumn(
                array(
                    'desejo' => new Zend_Db_Expr( '(SELECT 0)' )
                )
            );
                 
        }
    }
    
    /**
     * 
     * @access protected
     * @return void
     */
    protected function _addColumnParental()
    {
        $dbGenero = App_Model_DbTable_Factory::get( 'Genero' );
        
        $subSelect = $dbGenero->select()
            ->from(
                $dbGenero->__toString(),
                array( 'parental' )
            )  
            ->where( 'genero.codigo = titulo.genero' );
        
        $config = Zend_Registry::get( 'config' );
        
        $session = new Zend_Session_Namespace( $config->geral->appid );
        
        if ( $session->parental_control ) {
            
            $this->addColumn( 
                array(
                    'parental' => new Zend_Db_Expr( '(SELECT 0)' ) 
                ) 
            );
            
        } else {
            
            $this->addColumn(
                array(
                    'parental' => new Zend_Db_Expr( '(' . $subSelect . ')' )
                )
            );
            
        }
        
    }
    
    /**
     * 
     * @access public
     * @return string
     */
    public function __toString()
    {
        return $this->get()->__toString();
    }
}