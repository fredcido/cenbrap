<?php

/**
 * 
 */
class App_View_Helper_SelectPhoneType extends Zend_View_Helper_Abstract
{
    /**
     *
     * @var array
     */
    protected $_options;

    /**
     * 
     * @access 	public
     * @param 	number 	$bytes
     * @return 	number
     */
    public function selectPhoneType( $name, $attribs = array(), $value = null )
    {
	return $this->view->formSelect( $name, $value, $attribs, $this->_getTypeOptions() );
    }
    
    /**
     *
     * @return array
     */
    protected function _getTypeOptions()
    {
	if ( null == $this->_options ) {
	    
	    $dbTipoTelefone = new Model_DbTable_TipoTelefone();
	    
	    $tiposTelefone = $dbTipoTelefone->fetchAll();
	    
	    $this->_options = array();
	    foreach ( $tiposTelefone as $tipoTelefone )
		$this->_options[$tipoTelefone->id] = $tipoTelefone->descricao;
	}
	
	return $this->_options;
    }
}