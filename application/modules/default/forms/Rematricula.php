<?php 

/**
 * 
 */ 
class Default_Form_Rematricula extends Zend_Form
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
		$this->setAttrib( 'onsubmit', 'return Cenbrap.submit(this);' );
		
		//Decorator
		$this->setDecorators( array('FormElements', 'Form') );
		
		//Elementos
		$nome = $this->createElement( 'text', 'nome' )
			->setLabel( 'Nome:' )
			->setRequired( true )
			->setDecorators( array('ViewHelper', 'Label') );

		$this->addElement( $nome );

		$email = $this->createElement( 'text', 'email' )
			->setLabel( 'E-mail:' )
			->setRequired( true )
			->setDecorators(
				array(
					'ViewHelper',
					'Label',
					array('HtmlTag', array('tag' => 'div', 'class' => 'ui-block-a')),
				)
			);

		$conf_email = $this->createElement( 'text', 'conf_email' )
			->setLabel( 'Conf. E-mail:' )
			->setRequired( true )
			->setDecorators( 
				array(
					'ViewHelper',
					'Label',
					array('HtmlTag', array('tag' => 'div', 'class' => 'ui-block-b')),
				)
			);

		$this->addDisplayGroup(
			array($email, $conf_email), 
            'grid1', 
            array('class' => 'ui-grid-a')
		);
        
        $grid1 = $this->getDisplayGroup( 'grid1' );
        $grid1->setDecorators( array('FormElements', 'Fieldset') );

		$email_recado = $this->createElement( 'text', 'email_recado' )
			->setLabel( 'E-mail para recado:' )
			->setRequired( true )
			->setDecorators( array('ViewHelper', 'Label') );

		$this->addElement( $email_recado );

		$optEstado = array(
			'AC' => 'AC',
			'AL' => 'AL',
			'AM' => 'AM',
			'AP' => 'AP',
			'BA' => 'BA',
			'CE' => 'CE',
			'DF' => 'DF',
			'ES' => 'ES',
			'GO' => 'GO',
			'MA' => 'MA',
			'MT' => 'MT',
			'MS' => 'MS',
			'MG' => 'MG',
			'PA' => 'PA',
			'PB' => 'PB',
			'PR' => 'PR',
			'PE' => 'PE',
			'PI' => 'PI',
			'RJ' => 'RJ',
			'RN' => 'RN',
			'RS' => 'RS',
			'RO' => 'RO',
			'RR' => 'RR',
			'SC' => 'SC',
			'SP' => 'SP',
			'SE' => 'SE',
			'TO' => 'TO'
		);

		$estado = $this->createElement( 'select', 'estado' )
			->setLabel( 'Estado:' )
			->addMultiOptions( $optEstado )
			->setRequired( true )
			->setDecorators( 
				array(
					'ViewHelper',
					'Label',
					array('HtmlTag', array('tag' => 'div', 'class' => 'ui-block-a')),
				)
			);

		$cidade = $this->createElement( 'text', 'cidade' )
			->setLabel( 'Cidade:' )
			->setRequired( true )
			->setDecorators( 
				array(
					'ViewHelper',
					'Label',
					array('HtmlTag', array('tag' => 'div', 'class' => 'ui-block-b')),
				)
			);

		$this->addDisplayGroup(
			array($estado, $cidade), 
            'grid2', 
            array('class' => 'ui-grid-a')
		);
        
        $grid2 = $this->getDisplayGroup('grid2');
        $grid2->setDecorators(array('FormElements', 'Fieldset'));

		$bairro = $this->createElement( 'text', 'bairro' )
			->setLabel( 'Bairro:' )
			->setRequired( true )
			->setDecorators( 
				array(
					'ViewHelper',
					'Label',
					array('HtmlTag', array('tag' => 'div', 'class' => 'ui-block-a')),
				)
			);

		$cep = $this->createElement( 'text', 'cep' )
			->setLabel( 'CEP:' )
			->setRequired( true )
			->setDecorators( 
				array(
					'ViewHelper',
					'Label',
					array('HtmlTag', array('tag' => 'div', 'class' => 'ui-block-b')),
				)
			);

		$this->addDisplayGroup(
			array($bairro, $cep), 
            'grid3', 
            array('class' => 'ui-grid-a')
		);
        
        $grid3 = $this->getDisplayGroup('grid3');
        $grid3->setDecorators(array('FormElements', 'Fieldset'));

		$endereco = $this->createElement( 'text', 'endereco' )
			->setLabel( 'Endereço:' )
			->setRequired( true )
			->setDecorators( array('ViewHelper', 'Label') );

		$this->addElement( $endereco );

		$ddd = $this->createElement( 'text', 'ddd' )
			->setLabel( 'DDD:' )
			->setRequired( true )
			->setDecorators( 
				array(
					'ViewHelper',
					'Label',
					array('HtmlTag', array('tag' => 'div', 'class' => 'ui-block-a')),
				)
			);

		$telefone = $this->createElement( 'text', 'telefone' )
			->setLabel( 'Telefone:' )
			->setRequired( true )
			->setDecorators( 
				array(
					'ViewHelper',
					'Label',
					array('HtmlTag', array('tag' => 'div', 'class' => 'ui-block-b')),
				)
			);

		$celular = $this->createElement( 'text', 'celular' )
			->setLabel( 'Celular:' )
			->setRequired( true )
			->setDecorators( 
				array(
					'ViewHelper',
					'Label',
					array('HtmlTag', array('tag' => 'div', 'class' => 'ui-block-c')),
				)
			);

		$this->addDisplayGroup(
			array( $ddd, $telefone, $celular ), 
            'grid4', 
            array( 'class' => 'ui-grid-b' )
		);
        
        $grid4 = $this->getDisplayGroup('grid4');
        $grid4->setDecorators(array('FormElements', 'Fieldset'));

		$enviar = $this->createElement( 'submit', 'Enviar' )
			->setAttrib( 'data-icon', 'check' )
			->setAttrib( 'data-shadow', 'false' )
			->setDecorators( array('ViewHelper') );

		$this->addElement( $enviar );
	}
}