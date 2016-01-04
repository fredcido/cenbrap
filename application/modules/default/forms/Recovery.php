<?php

/**
 * 
 */
class Default_Form_Recovery extends Zend_Form
{
	/**
	 * 
	 * @see Zend_Form::init()
	 */
    public function init()
    {
    	//Atributos
		$this->setMethod( Zend_Form::METHOD_POST );

		$this->setAttrib( 'data-ajax', 'false' );
		
		//Decorator
		$this->setDecorators( array('FormElements', 'Form') );
		
		//Elementos
		$elements = array();
		
		$elements[] = $this->createElement( 'text', 'usuario' )
			->setLabel( 'Informe seu usuário:' )
			->setAttrib( 'placeholder', 'exemple@exemple.com' )
			->setRequired( true )
			->setDecorators( array('ViewHelper', 'Label') );
			
		$elements[] = $this->createElement( 'submit', 'Enviar' )
			->setAttrib( 'data-theme', 'd' )
			->setAttrib( 'data-icon', 'check' )
			->setAttrib( 'data-shadow', 'false' )
			->setDecorators( array('ViewHelper') );
			
		$this->addElements( $elements );
    }
}