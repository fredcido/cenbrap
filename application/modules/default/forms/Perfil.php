<?php

/**
 * 
 */
class Default_Form_Perfil extends Zend_Form
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

	$rg = $this->createElement( 'text', 'rg' )
		->setLabel( 'RG:' )
		->setRequired( true )
		->setDecorators(
			array(
			    'ViewHelper',
			    'Label',
			    array('HtmlTag', array('tag' => 'div', 'class' => 'ui-block-a')),
			)
		);

	$org_emissor = $this->createElement( 'text', 'rg_emissor' )
		->setLabel( 'Org. Emissor:' )
		->setRequired( true )
		->setDecorators(
			array(
			    'ViewHelper',
			    'Label',
			    array('HtmlTag', array('tag' => 'div', 'class' => 'ui-block-b'))
			)
		);

	$data_nascimento = $this->createElement( 'text', 'data_nascimento' )
		->setLabel( 'Dt Nascimento:' )
		->setRequired( true )
		->setDecorators(
			array(
			    'ViewHelper',
			    'Label',
			    array('HtmlTag', array('tag' => 'div', 'class' => 'ui-block-c')),
			)
		);

	$this->addDisplayGroup(
		array($rg, $org_emissor, $data_nascimento), 'grid1', array('class' => 'ui-grid-b')
	);

	$grid1 = $this->getDisplayGroup( 'grid1' );
	$grid1->setDecorators( array('FormElements', 'Fieldset') );

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
		array($estado, $cidade), 'grid2', array('class' => 'ui-grid-a')
	);

	$grid2 = $this->getDisplayGroup( 'grid2' );
	$grid2->setDecorators( array('FormElements', 'Fieldset') );

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
		array($bairro, $cep), 'grid3', array('class' => 'ui-grid-a')
	);

	$grid3 = $this->getDisplayGroup( 'grid3' );
	$grid3->setDecorators( array('FormElements', 'Fieldset') );

	$endereco = $this->createElement( 'text', 'endereco' )
		->setLabel( 'Endereço:' )
		->setRequired( true )
		->setDecorators( array('ViewHelper', 'Label') );

	$this->addElement( $endereco );

	$ddd_telefone = $this->createElement( 'text', 'ddd' )
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

	$this->addDisplayGroup(
		array($ddd_telefone, $telefone), 'grid4', array('class' => 'ui-grid-a')
	);

	$grid4 = $this->getDisplayGroup( 'grid4' );
	$grid4->setDecorators( array('FormElements', 'Fieldset') );

	$ddd_celular = $this->createElement( 'text', 'ddd_celular' )
		->setLabel( 'DDD:' )
		->setRequired( true )
		->setDecorators(
			array(
			    'ViewHelper',
			    'Label',
			    array('HtmlTag', array('tag' => 'div', 'class' => 'ui-block-a'))
			)
		);

	$celular = $this->createElement( 'text', 'celular' )
		->setLabel( 'Celular:' )
		->setRequired( true )
		->setDecorators(
			array(
			    'ViewHelper',
			    'Label',
			    array('HtmlTag', array('tag' => 'div', 'class' => 'ui-block-b'))
			)
		);

	$this->addDisplayGroup(
		array($ddd_celular, $celular), 'grid5', array('class' => 'ui-grid-a')
	);

	$grid5 = $this->getDisplayGroup( 'grid5' );
	$grid5->setDecorators( array('FormElements', 'Fieldset') );

	$optFormacao = array(
	    'Superior Incompleto' => 'Superior Incompleto',
	    'Superior Completo' => 'Superior Completo',
	    'Pós-Graduação Incompleta' => 'Pós-Graduação Incompleta',
	    'Pós-Graduação Completa' => 'Pós-Graduação Completa',
	    'Mestrado Incompleto' => 'Mestrado Incompleto',
	    'Mestrado Completo' => 'Mestrado Completo'
	);

	$formacao = $this->createElement( 'select', 'formacao' )
		->setLabel( 'Formação:' )
		->addMultiOptions( $optFormacao )
		->setRequired( true )
		->setDecorators(
			array(
			    'ViewHelper',
			    'Label',
			    array('HtmlTag', array('tag' => 'div', 'class' => 'ui-block-a'))
			)
		);

	$instituicao = $this->createElement( 'text', 'instituicao' )
		->setLabel( 'Instituição:' )
		->setDecorators(
			array(
			    'ViewHelper',
			    'Label',
			    array('HtmlTag', array('tag' => 'div', 'class' => 'ui-block-b'))
			)
		);

	$this->addDisplayGroup(
		array($formacao, $instituicao), 'grid6', array('class' => 'ui-grid-a')
	);

	$grid6 = $this->getDisplayGroup( 'grid6' );
	$grid6->setDecorators( array('FormElements', 'Fieldset') );

	$dt_graduacao = $this->createElement( 'text', 'graduacao' )
		->setLabel( 'Graduado em:' )
		->setDecorators(
			array(
			    'ViewHelper',
			    'Label',
			    array('HtmlTag', array('tag' => 'div', 'class' => 'ui-block-a')),
			)
		);

	$dt_colacao = $this->createElement( 'text', 'formacao_data' )
		->setLabel( 'Dt Colação:' )
		->setDecorators(
			array(
			    'ViewHelper',
			    'Label',
			    array('HtmlTag', array('tag' => 'div', 'class' => 'ui-block-b'))
			)
		);

	$this->addDisplayGroup(
		array($dt_graduacao, $dt_colacao), 'grid7', array('class' => 'ui-grid-a')
	);

	$grid7 = $this->getDisplayGroup( 'grid7' );
	$grid7->setDecorators( array('FormElements', 'Fieldset') );

	$profissao = $this->createElement( 'text', 'profissao' )
		->setLabel( 'Profissão:' )
		->setDecorators(
			    array(
				'ViewHelper',
				'Label',
				array('HtmlTag', array('tag' => 'div', 'class' => 'ui-block-a')),
			    )
		    );

	$local_trabalho = $this->createElement( 'text', 'local_trabalho' )
		->setLabel( 'Local de Trabalho:' )
		->setDecorators(
			array(
			    'ViewHelper',
			    'Label',
			    array('HtmlTag', array('tag' => 'div', 'class' => 'ui-block-b'))
			)
		);

	$this->addDisplayGroup(
		array($profissao, $local_trabalho), 'grid8', array('class' => 'ui-grid-a')
	);

	$grid8 = $this->getDisplayGroup( 'grid8' );
	$grid8->setDecorators( array('FormElements', 'Fieldset') );

	$email = $this->createElement( 'text', 'email' )
		->setLabel( 'E-mail:' )
		->setDecorators(
			array(
			    'ViewHelper',
			    'Label',
			    array('HtmlTag', array('tag' => 'div', 'class' => 'ui-block-a')),
			)
		);

	$email_recado = $this->createElement( 'text', 'email_apoio' )
		->setLabel( 'E-mail de recado:' )
		->setDecorators(
		array(
		    'ViewHelper',
		    'Label',
		    array('HtmlTag', array('tag' => 'div', 'class' => 'ui-block-b'))
		)
	);

	$this->addDisplayGroup(
		array($email, $email_recado), 'grid9', array('class' => 'ui-grid-a')
	);

	$grid9 = $this->getDisplayGroup( 'grid9' );
	$grid9->setDecorators( array('FormElements', 'Fieldset') );

	$senha = $this->createElement( 'password', 'senha' )
		->setLabel( 'Senha:' )
		->setDecorators(
			array(
			    'ViewHelper',
			    'Label',
			    array('HtmlTag', array('tag' => 'div', 'class' => 'ui-block-a')),
			)
		);

	$conf_senha = $this->createElement( 'text', 'conf_senha' )
		->setLabel( 'Confirmar senha:' )
		->setDecorators(
			array(
			    'ViewHelper',
			    'Label',
			    array('HtmlTag', array('tag' => 'div', 'class' => 'ui-block-b'))
			)
		);

	$this->addDisplayGroup(
		array($senha, $conf_senha), 'grid10', array('class' => 'ui-grid-a')
	);

	$grid10 = $this->getDisplayGroup( 'grid10' );
	$grid10->setDecorators( array('FormElements', 'Fieldset') );

	$enviar = $this->createElement( 'submit', 'Enviar' )
		->setAttrib( 'data-icon', 'check' )
		->setAttrib( 'data-shadow', 'false' )
		->setDecorators( array('ViewHelper') );

	$this->addElement( $enviar );
    }

}