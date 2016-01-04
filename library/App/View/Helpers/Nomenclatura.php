<?php

class Zend_View_Helper_Nomenclatura extends Zend_View_Helper_Abstract
{
    /**
     *
     * @return Zend_View_Helper_Nomenclatura 
     */
    public function nomenclatura()
    {
	return $this;
    }
    
    /**
     *
     * @param string $tipo
     * @return string 
     */
    public function statusPedido( $statusPedido )
    {
	$tipo = '';
	switch ( $statusPedido ) {
	    case 'C':
		$tipo = 'Cancelado';
		break;
	    case 'E':
		$tipo = 'Entregue';
		break;
	    default:
		$tipo = 'Pendente';
	}
	
	return $tipo;
    }
    
    /**
     *
     * @param string $tipo
     * @return string 
     */
    public function statusPagamento( $statusPagamento )
    {
	$tipo = '';
	switch( $statusPagamento ) {
	
	    case 'CM':
		$tipo = 'Cartão Master';
		break;
	    case 'CV':
		$tipo = 'Cartão Visa';
		break;
	    case 'V':
		$tipo = 'Á Vista';		
		break;
	    default:
		$tipo = 'Pag Seguro';
	    
	}
	
	return $tipo;
    }
    
    /**
     *
     * @param string $tipo
     * @return string 
     */
    public function statusPedidoView( $statusPedido )
    {
	$tipo = '';
	switch ( $statusPedido ) {
	    case 'C':
		$tipo = "<img src='" . $this->view->baseUrl( 'public/images/admin/icons/fugue/status-busy.png' ) . "' border='nome' title='Cancelado'> ";
		break;
	    case 'E':
		$tipo = "<img src='" . $this->view->baseUrl( 'public/images/admin/icons/fugue/status.png' ) . "' border='nome' title='Entregue'> ";
		break;
	    default:
		$tipo = "<img src='" . $this->view->baseUrl( 'public/images/admin/icons/fugue/status-away.png' ) . "' border='nome' title='Pendente' > ";
	}
	
	return $tipo;
    }
}