<?php 

/**
 * @version $Id $
 */
class Default_Form_Lancamento extends Zend_Form
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

		$options = array(
			'0' => 'Todos',
			'1' => 'Anteriores',
			'2' => 'Futuros'
		);
		
		$elements[] = $this->createElement( 'select', 'filtro' )
			->setLabel( 'Visualizar:' )
			->addMultiOptions( $options )
			->setRequired( true )
			->setDecorators( array('ViewHelper', 'Label') );
			
		$elements[] = $this->createElement( 'submit', 'Enviar' )
			->setAttrib( 'data-icon', 'check' )
			->setAttrib( 'data-shadow', 'false' )
			->setDecorators( array('ViewHelper') );
			
		$this->addElements( $elements );
	}
}