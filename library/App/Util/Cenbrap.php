<?php

abstract class App_Util_Cenbrap
{

    const API_URL = 'http://dummy';

    /**
     *
     * @param string $method
     * @param array $parameters
     * @return string
     */
    public static function request( $method, array $parameters )
    {
	$data = array(
	    'metodo' => $method
	);

	// Unifica parametros
	$parameters += $data;

	$clientHttp = new Zend_Http_Client();
	$clientHttp->setUri( self::API_URL )
		->setMethod( Zend_Http_Client::GET )
		->setParameterGet( $parameters );

	$response = $clientHttp->request();
	
	if ( $response->isSuccessful() ) {

	    $body = $response->getBody();
	    
	    $body = preg_replace( '/(!\[CDATA\[")/i', '![CDATA[', $body );
	    $body = preg_replace( '/"]]>/i', ']]>', $body );

	    $body = html_entity_decode( $body, ENT_QUOTES, 'UTF-8' );

	    // Verifica se teve erro
	    self::_hasError( $body );

	    // Retorna o array
	    return self::xmlToArray( $body );
	    
	    // Retorna o array
	    //return json_decode( json_encode( (array)simplexml_load_string( $body ) ), 1 );
	} else
	    throw new Exception( 'Erro ao realizar requisição' );
    }

    /**
     *
     * @param string $response 
     */
    protected static function _hasError( $response )
    {
	$xml = simplexml_load_string( $response );

	if ( empty( $xml ) )
	    throw new Exception( 'Erro ao renderizar XML de retorno' );

	if ( empty( $xml->status ) )
	    throw new Exception( $xml->message );
    }

    /**
     *
     * @param arra $data
     * @param arra $keys
     * @return string 
     */
    public static function getHash( array $data, array $keys )
    {
	$values = array();
	foreach ( $data as $key => $value )
	    if ( ( $pos = array_search( $key, $keys ) ) !== false )
		$values[$pos] = trim( $value );

	$values[] = Zend_Date::now()->toString( 'ddMMyyyy' );

	return md5( implode( '', $values ) );
    }

    /**
     *
     * @param string $xmlstr
     * @return array
     */
    public static function xmlToArray( $xmlstr )
    {
	$doc = new DOMDocument();
	$doc->loadXML( $xmlstr );
	$root = $doc->documentElement;
	$output = self::_domNodeToArray( $root );
	$output['@root'] = $root->tagName;
	return $output;
    }

    /**
     *
     * @param DOMElement $node
     * @return array 
     */
    protected static function _domNodeToArray( $node )
    {
	$output = array();
	switch ( $node->nodeType ) {

	    case XML_CDATA_SECTION_NODE:
	    case XML_TEXT_NODE:
		$output = trim( $node->textContent );
		break;

	    case XML_ELEMENT_NODE:
		for ( $i = 0, $m = $node->childNodes->length; $i < $m; $i++ ) {
		    $child = $node->childNodes->item( $i );
		    $v = self::_domNodeToArray( $child );
		    if ( isset( $child->tagName ) ) {
			$t = $child->tagName;
			if ( !isset( $output[$t] ) ) {
			    $output[$t] = array();
			}
			$output[$t][] = $v;
		    } elseif ( $v || $v === '0' ) {
			$output = (string)$v;
		    }
		}
		if ( $node->attributes->length && !is_array( $output ) ) { //Has attributes but isn't an array
		    $output = array('@content' => $output); //Change output into an array.
		}
		if ( is_array( $output ) ) {
		    if ( $node->attributes->length ) {
			$a = array();
			foreach ( $node->attributes as $attrName => $attrNode ) {
			    $a[$attrName] = (string)$attrNode->value;
			}
			$output['@attributes'] = $a;
		    }
		    foreach ( $output as $t => $v ) {
			if ( is_array( $v ) && count( $v ) == 1 && $t != '@attributes' ) {
			    $output[$t] = $v[0];
			}
		    }
		}
		break;
	}
	return $output;
    }
}
