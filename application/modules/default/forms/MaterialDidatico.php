<?php

/**
 * @version $Id $
 */
class Default_Form_MaterialDidatico extends Zend_Form
{
	/**
	 * @access public
	 * @return void
	 */ 
	public function init()
	{
		//Atributos
		$this->setMethod( Zend_Form::METHOD_POST );

		//Decorator
		$this->setDecorators( array('FormElements', 'Form') );

		//Elementos
		$elements = array();

		$options = array();
		
		$elements[] = $this->createElement( 'select', 'disciplina' )
			->setLabel( 'Disciplina:' )
			->addMultiOptions( $options )
			->setRequired( true )
			->setDecorators( array('ViewHelper', 'Label') );
			
		$elements[] = $this->createElement( 'submit', 'Buscar' )
			->setAttrib( 'data-icon', 'check' )
			->setAttrib( 'data-shadow', 'false' )
			->setDecorators( array('ViewHelper') );
			
		$this->addElements( $elements );
	}
}