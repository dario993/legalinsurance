<?php

    error_reporting(E_ALL ^ E_DEPRECATED ^ E_NOTICE ^ E_WARNING);
    ini_set('display_errors','On');
    
    session_start();
    
    include_once 'common.php'; 
    require_once 'functions.php';
    include_once 'Database.php'; 
   
    header('Content-Type: application/json');
    
    try {
        $dbo = new Database();
    } catch(PDOException $e){
        return json_encode(array('err'=>"$act: ".$e->getMessage()));
    }
    
    $flagError;
    $act = $_REQUEST['act'];
    if (!empty($act)){
        try {
            echo json_encode($act());    
        } catch (PDOException $e){
            echo json_encode(array('err'=>"$act: ".$e->getMessage()));
        }
        $dbo->close();
        return;
    }
    else 
        echo json_encode(array('err'=>'azione sconosciuta.'));
    
    $dbo->close();
    
?>