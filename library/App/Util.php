<?php
    class App_Util{
        static function formatDateToBd($date){
            try{
                if(strstr($date, "/")){
                    $date_tmp = explode("/", $date);
                    
                    return $date_tmp[2] . "-" . $date_tmp[1] . "-" . $date_tmp[0];
                }
            }catch(Exception $e){
                throw new Exception("Falha ao converter data para o Banco de Dados: " . $e->getMessage());
            }
        }
        
        static function formatPhoneToBd($phone){
            try{
                $phone = str_replace(" ", "", $phone);
                $phone = str_replace("(", "", $phone);
                $phone = str_replace(")", "", $phone);
                $phone = str_replace("-", "", $phone);
                $phone = str_replace("+", "", $phone);
                
                return $phone;
            }catch(Exception $e){
                throw new Exception("Falha ao converter data para o Banco de Dados: " . $e->getMessage());
            }
        }
    }
?>
