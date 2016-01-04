<?php

/**
 * @version $Id $
 */
class Default_Form_Auth extends Zend_Form
{
	/**
	 * @access public
	 * @return void
	 */
    public function init()
    {
    	//Atributos
		$this->setMethod( Zend_Form::METHOD_POST );

		$this->setAttrib( 'id', 'auth' );
		$this->setAttrib( 'data-ajax', 'false' );
		$this->setAttrib( 'onsubmit', 'return Cenbrap.submit(this, {callback: function(){$.mobile.changePage( baseUrl + "index" );}});' );
		
		//Decorator
		$this->setDecorators( array('FormElements', 'Form') );
		
		//Elementos
		$elements = array();
		
		$elements[] = $this->createElement( 'text', 'usuario' )
			->setLabel( 'Informe seu usuário:' )
			->setAttrib( 'placeholder', 'exemple@exemple.com' )
			->setRequired( true )
			->setDecorators( array('ViewHelper', 'Label') );
			
		$elements[] = $this->createElement( 'password', 'senha' )
			->setLabel( 'Informe sua senha:' )
			->setAttrib( 'placeholder', '******' )
			->setRequired( true )
			->setDecorators( array('ViewHelper', 'Label') );

		/*
		$elements[] = $this->createElement( 'checkbox', 'logado' )
			->setLabel( 'Me mantenha logado' )
			->setAttrib( 'checked', 'checked' )
			->setDecorators( array('ViewHelper', 'Label') );
		 */
			
		$elements[] = $this->createElement( 'submit', 'Entrar' )
			->setAttrib( 'data-theme', 'd' )
			->setAttrib( 'data-icon', 'check' )
			->setAttrib( 'data-shadow', 'false' )
			->setDecorators( array('ViewHelper') );
			
		$this->addElements( $elements );
    }
}