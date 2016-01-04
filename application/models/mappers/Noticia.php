<?php

class Model_Mapper_Noticia extends App_Model_Mapper_Abstract
{

    /**
     * 
     */
    public function listNews()
    {
		try {

			$auth = Zend_Auth::getInstance();

			$parameters = array( 'usuario' 	=> $auth->getIdentity()->codigo );
			$parameters['hash']	= App_Util_Cenbrap::getHash( $parameters, array('usuario') );

			$response = App_Util_Cenbrap::request( 'Noticias', $parameters );

			if ( empty($response['status']) )
				throw new Exception( $response['message'] );
		   
		    return $response['noticia'];

		} catch ( Exception $e ) {

		    return array();
		}
    }
}