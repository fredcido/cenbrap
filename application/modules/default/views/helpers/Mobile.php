<?php 

/**
 * 
 */
class Zend_View_Helper_Mobile extends Zend_View_Helper_Abstract
{
	/**
	 * @access public
	 * @return Zend_View_Helper_Mobile
	 */ 
	public function mobile()
	{
		return $this;
	}

	/**
	 * @access public
	 * @return string
	 */ 
	public function getTitle()
	{
		$controller = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
		$action = Zend_Controller_Front::getInstance()->getRequest()->getActionName();

		switch ( $controller ) {

			case 'index':
				if ( 'index' === $action )
					$title = 'Cursos';
				else
					$title = $this->view->nome_curso;
				break;

			case 'aviso':
				$title = 'Avisos';
				break;

			case 'lancamento':
				$title = 'Encontros / Notas / Frequências';
				break;

			case 'pendencia':
				$title = 'Pendências';
				break;

			case 'material-didatico':
				$title = 'Material Didático';
				break;

			case 'noticia':
				$title = 'Notícias';
				break;

			case 'tcc':
				$title = 'Trabalho de Conclusão de Curso';
				break;

			case 'vaga':
				$title = 'Vagas';
				break;

			case 'rematricula':
				$title = 'Rematrícula';
				break;

			case 'perfil':
				$title = 'Atualize seus Dados';
				break;

			case 'boleto':
				$title = 'Boleto';
				break;

			default:
				$title = 'Cenbrap';

		}

		return $title;
	}

	/**
	 * @access public
	 * @return boolean
	 */
	public function hasShowNavebar()
	{
		$request = Zend_Controller_Front::getInstance()->getRequest();

		return ( 
			Zend_Auth::getInstance()->hasIdentity() 
			&& 
			'index' !== $request->getControllerName() 
			||
			(
				'index' === $request->getControllerName() 
				&&
				'index' !== $request->getActionName()
			)
		);
	}

	/**
	 * @access public
	 * @return string
	 */ 
	public function menu( $url )
	{
		$config = Zend_Registry::get( 'config' );

		$session = new Zend_Session_Namespace( $config->geral->appid );

		return $url . '/id/' . $session->curso;
	}

	/**
	 * @access public
	 * @param array $data
	 */
	public function statusPendencia( array $data )
	{
		$content = null;

		foreach ( $data as $item ) {

			if ( isset($item['status']) && 'AGENDAR' !== strtoupper($item['status']) ) {

				$doc = new DOMDocument();

				$doc->appendChild( $doc->createElement('p', $item['status']) );

				$content = $doc->saveHTML();

				break;

			}

		}

		return $content;
	}
}