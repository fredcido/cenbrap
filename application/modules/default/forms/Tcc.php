<?php 

/**
 * @version $Id $
 */
class Default_Form_Tcc extends Zend_Form
{
	/**
	 * @access public
	 * @return void
	 */ 
	public function init()
	{
		//Atributos
		$this->setMethod( Zend_Form::METHOD_POST );

		$this->setAttrib( 'id', 'tcc' );
		
		//Decorator
		$this->setDecorators( array('FormElements', 'Form') );
		
		//Elementos
		$elements = array();
		
		$elements[] = $this->createElement( 'file', 'arquivo' )
			->setLabel( 'Arquivo:' )
			->setRequired( true )
			->setDecorators( array('ViewHelper', 'Label') );
			
		$elements[] = $this->createElement( 'submit', 'Enviar' )
			->setAttrib( 'data-icon', 'check' )
			->setAttrib( 'data-shadow', 'false' )
			->setDecorators( array('ViewHelper') );
			
		$this->addElements( $elements );
	}
}