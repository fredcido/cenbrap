<?php 

class Default_Form_Pendencia extends Zend_Form
{
	/**
	 * @access public
	 * @return void
	 */
	public function init()
	{
		//Atributos
		$this->setMethod( Zend_Form::METHOD_POST );

		$this->setAttrib( 'data-ajax', 'false' );
		$this->setAttrib( 'onsubmit', 'return Cenbrap.submit(this, {callback: remarcarDisciplina});' );
		
		//Decorator
		$this->setDecorators( array('FormElements', 'Form') );
		
		//Elementos
		$elements = array();
		
		$elements[] = $this->createElement( 'hidden', 'curso' )->setDecorators( array('ViewHelper') );
		$elements[] = $this->createElement( 'hidden', 'disciplina' )->setDecorators( array('ViewHelper') );
		$elements[] = $this->createElement( 'hidden', 'encontro' )->setDecorators( array('ViewHelper') );
		
		$elements[] = $this->createElement( 'text', 'nome' )
			->setLabel( 'Nome:' )
			->setRequired( true )
			->setDecorators( array('ViewHelper', 'Label') );

		$elements[] = $this->createElement( 'text', 'email' )
			->setLabel( 'E-mail:' )
			->setRequired( true )
			->setDecorators( array('ViewHelper', 'Label') );

		$elements[] = $this->createElement( 'text', 'telefone' )
			->setLabel( 'Telefone:' )
			->setRequired( true )
			->setDecorators( array('ViewHelper', 'Label') );
			
		$elements[] = $this->createElement( 'submit', 'Enviar' )
			->setAttrib( 'data-icon', 'check' )
			->setAttrib( 'data-theme', 'd' )
			->setAttrib( 'data-shadow', 'false' )
			->setDecorators( array('ViewHelper') );
			
		$this->addElements( $elements );
	}
}