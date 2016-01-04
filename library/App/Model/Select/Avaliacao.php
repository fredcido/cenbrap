<?php

/**
 * 
 */
class App_Model_Select_Avaliacao 
{
    /**
     * 
     * @access private
     * @return void
     */
    private function __construct()
    {
    }
    
    /**
     * 
     * @access public
     * @param mixed $field
     * @param int $usuario
     * @return Zend_Db_Select
     */
    public static function get( $field, $usuario = null )
    {
        $dbAvaliacao = App_Model_DbTable_Factory::get( 'Avaliacao' );
        
        $subSelect = $dbAvaliacao->select()
            ->from(
                $dbAvaliacao->__toString(),
                array(
                    'voto' => new Zend_Db_Expr('COUNT(1) * 5'),
                    'nota' => new Zend_Db_Expr('COALESCE(SUM(nota), 0) * 100')
                )
            )
            ->where( 'avaliacao.codigo_titulo = ' . $field );
            
        if ( !empty($usuario) )
            $subSelect->where('avaliacao.codigo_usuario = ?', $usuario);
            
        $select = $dbAvaliacao->select()
            ->setIntegrityCheck( false )
            ->from(
                array( 'nota' => new Zend_Db_Expr('(' . $subSelect . ')') ),
                array( 
                    'nota' => new Zend_Db_Expr('CASE WHEN voto = 0 THEN 0 ELSE ROUND(((nota / voto) / 100.0)::numeric(3, 2) * 5) END') 
                )
            );
            
        return $select;
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
    
    /**
     * 
     * @access public
     * @return void
     */
    public function __clone()
    {
        trigger_error( 'Clone is not allowed.', E_USER_ERROR );
    }
}