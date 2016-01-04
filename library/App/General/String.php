<?php

/**
 * 
 */
class App_General_String
{

    /**
     * Retorna um hash aleatorio
     * 
     * @access public
     * @static
     * @return string
     */
    public static function randomHash()
    {
	return md5( uniqid( time() ) );
    }

    /**
     * Retorna nome amigavel
     * 
     * @access 	public
     * @static
     * @param 	string $value
     * @return 	string
     */
    public static function friendName( $value )
    {
	$strComCaracter = array("\"", '\'', 'r$', '$', '&', '%', '#', '@', ',', '.', '|', '_', '-', '+', '/', '*', ':', ';', '!', '?', '(', ')', '{', '}', '[', ']');
	$strSemCaracter = array('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

	$strComComum = array(' a ', ' e ', ' o ', ' da ', ' de ', ' do ', ' em ');
	$strSemComum = array(' ', ' ', ' ', ' ', ' ', ' ', ' ');

	$value = htmlentities( strtolower( $value ), ENT_NOQUOTES, 'UTF-8' );
	$value = preg_replace( '/&(.)(acute|cedil|circ|ring|tilde|uml);/', '$1', $value );
	$value = str_replace( $strComCaracter, $strSemCaracter, $value );
	$value = str_replace( $strComComum, $strSemComum, $value );
	$value = preg_replace( '/( +)/', '-', trim( $value ) );

	return $value;
    }

    public static function toAscii( $str, $replace = array(), $delimiter = '-' )
    {
	if ( !empty( $replace ) )
	    $str = str_replace( (array)$replace, ' ', $str );

	$clean = iconv( 'UTF-8', 'ASCII//TRANSLIT', $str );
	$clean = preg_replace( "/[^a-zA-Z0-9\/_|+ -]/", '', $clean );
	$clean = strtolower( trim( $clean, '-' ) );
	$clean = preg_replace( "/[\/_|+ -]+/", $delimiter, $clean );

	return $clean;
    }

}