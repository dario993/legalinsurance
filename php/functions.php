<?php

define('ROOT_PATH',dirname(dirname(__FILE__)) );

ini_set("mail.add_x_header", TRUE);

            
            
    
    function getListAssicurazioni(){
        global $dbo,$ret,$flagError;
        if($flagError == 'true') return;
        
        $query = "SELECT * FROM ".$GLOBALS['data'] ." group by id_insurance";
        $dbo->query($query);
        $rows = $dbo->resultset();
        
        foreach($rows as $row){
            $listAssicurazioni[] = array('id' => $row['id_insurance'], 'value' => $row['insurance_company']);
        }  
       
        return array('listAssicurazioni' => $listAssicurazioni);
          
    }
    
    
    function getTableRisparmio(){
        global $dbo,$ret,$flagError;
        if($flagError == 'true') return;
        
        
        $inputNascita = $_REQUEST['inputNascita'];
        $isPrivato = $_REQUEST['isPrivato'];
        $isTraffico = $_REQUEST['isTraffico'];
        $isSingleFamily = $_REQUEST['isSingleFamily'];
        $idSelectAssicurazione = $_REQUEST['idSelectAssicurazione'];

        if(empty($inputNascita)){
            return;
        }

        
        $query_risparmio = "SELECT * FROM `data` " ." WHERE `is_private` = '". $isPrivato 
                ."' and `is_traffic` = '".$isTraffico
                ."' and `family_single` = '". $isSingleFamily  
                ."' and `id_insurance` = '".$idSelectAssicurazione ."' order by `premium`";
 
        $dbo->query($query_risparmio);
        $rows_risparmio = $dbo->resultset();
        
        $old_premio = 0;
        if(!empty($rows_risparmio)){
            $old_premio= $rows_risparmio[0]['premium'];
        }
        
        $query =
                 "SELECT * FROM `data` "
                ." WHERE `is_private` = '". $isPrivato 
                ."' and `is_traffic` = '".$isTraffico
                ."' and `family_single` = '". $isSingleFamily ."'";

                
        $dbo->query($query);
        $rows = $dbo->resultset();
        
        if(!empty($rows)){
            $result['table'] = $rows;
            $result['old_premio'] = $old_premio;
            $result['error_code'] = 0;
            
        }
        else{
            $result['error_code'] = 1;
            $result['error_text'] = "Errore function getTableRisparmio: ";
        }
        return $result;
         
        
    }   
    
            
    
    
    
    function setError($stato, $view){
        global $ret;
        $ret['error'] = array("stato" => $stato, "view" => $view );
    }
    
    
    
    
     
    function getSelectDataById(){
        global $dbo,$ret,$flagError;
        if($flagError == 'true') return;
        
       
        $idOffertaSelezionata = $_REQUEST['idSelezionato'];
        $nome= $_REQUEST['nome'];
        $cognome = $_REQUEST['cognome'];
        $inizioAssicurazione = $_REQUEST['inizioAssicurazione'];
        $nascita = $_REQUEST['inputNascita'];
        $isPrivato=$_REQUEST['isPrivato'];
        $isSingleFamily=$_REQUEST['isSignleFamily'];
        $isTraffico=$_REQUEST['isTraffico'];
        $linguaOfferta=$_REQUEST['linguaOfferta'];
        $note = $_REQUEST['note'];
        $paese = $_REQUEST['paese'];
        $plz = $_REQUEST['plz'];
        $telefono = $_REQUEST['telefono'];
        
        

        if(empty($idOffertaSelezionata)){
            return;
        }

        
        $query = "SELECT * FROM `data` WHERE  id = $idOffertaSelezionata";
 
        $dbo->query($query);
        $row_id = $dbo->single();
         
        $insurance_company= $row_id['insurance_company'];
        $premium = $row_id['premium'];
        
        
        $subject="Insurance Quote";  
        $corpo="";
        include 'mail.php';

      $from= "mail@onezone.ch";
      $to = "dario.sgamba@gmail.com";

      // Set the headers
      $headers = "From: $from\r\n";
     // $headers .= "Reply-To: $from\r\n";
      $headers .= "MIME-Version: 1.0\r\n";
      $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

      // Send the email
      if (mail($to, $subject, $corpo, $headers)) {
        return true;
      } else {
        return false;
      }
        
        return $row_id;
    }
    
      
     
    
    
     