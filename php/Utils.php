<?php

class Utils{
    
    
public static function getBaseUrl() {

        $host = $_SERVER['HTTP_HOST'];
        
        if (empty($host)){
            $baseUrl = 'http://versicherungs-broker.ch/pramienrechner';
        }
        
        else if ($host=='web.local'){
            $baseUrl = 'http://web.local/calcolo_cassa_malattia';
        }
        else if ($host=='localhost'){
            $baseUrl = 'http://localhost/calcolo_cassa_malattia';
        }
        else if ($host=='95.240.124.80'){
            $baseUrl = 'http://95.240.124.80/calcolo_cassa_malattia';
        }
        else if ($host=='192.168.1.6'){
            $baseUrl = 'http://192.168.1.6/calcolo_cassa_malattia';
        }
        
        else {
            $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 'https' ? 'https://' : 'http://';
            $host = $_SERVER['HTTP_HOST'];
//            $baseUrl = $protocol . $host."/bluelinks";
            $baseUrl = $protocol . $host . "/pramienrechner";
        }
        
        return $baseUrl;

    }
    
}