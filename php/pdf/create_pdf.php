<?php
//questo file e la cartella font si trovano nella stessa director
//include '/common.php';

error_reporting(E_ALL ^ E_DEPRECATED ^ E_NOTICE ^ E_WARNING);
ini_set('display_errors','On');


define('FPDF_FONTPATH','font/');

define('ROOT_PATH',dirname(dirname(__FILE__)) );

require_once(ROOT_PATH."/common.php");
require_once(ROOT_PATH."/define.php");
require_once(ROOT_PATH."/Utils.php");
require_once(ROOT_PATH.'/Database.php');
require_once(ROOT_PATH.'/functions.php');
require_once(ROOT_PATH.'/pdf/fpdf.php');

require (ROOT_PATH.'/phpmailer/class.phpmailer.php');


class PDF extends FPDF
{
    // Page header
    function Header()
    {
        //Logo
        $this->Image('logo-prm.png',10,6,100);
        $this->Ln(7);
        $this->SetFont('Arial','I',10);
        $this->Cell(0, 5, 'contact@versicherungs-broker.ch', '', 1);
        $this->Cell(0, 5, '056 552 04 50', '', 1);
        
        $this->Ln(10);
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,''.$this->PageNo().'/{nb}',0,0,'C');
    }
}

try {

    $dbo = new Database();


    $premioMese = $_REQUEST['dataRow']['premio_tot'];
    $dataPremio = $_REQUEST['dataRow'];
    
    $rowPremioAttuale = null;
    if($_REQUEST['codCassaAttuale'] != '-1' && $_REQUEST['premio_cassa_attuale'] != "-1"){
        
            $row = explode(",", $_REQUEST['premio_cassa_attuale']);
            $premioAttuale = $row[1];
            $idPremioCassaAttuale = $row[0];
            
                
            $rowPremioAttuale = getPremio($idPremioCassaAttuale);

            $text_cassa_attuale = $rowPremioAttuale['nome_display'];        
            $tipo_tariffa = $rowPremioAttuale['tipo_tariffa'] . " - ". $rowPremioAttuale['nome_tariffa']." (".$rowPremioAttuale['id_tariffa'].")";        
            
            $risparmio = number_format(floatval($dataPremio['risparmio']) * 12.00, 2);

    }
    
    
    $p = new PDF();

    //inizzializzo
    $p->AliasNbPages();

    //aggiungo una pagina
    $p->AddPage();
    $p->SetTextColor(0);
    $p->SetFillColor(210);
    $p->SetFont('Arial', 'B', 15);
    
    $p->Cell(100, 10, utf8_decode($dataPremio['nome']) . ": ".$lang['RICHIESTA_OFFERTA'], '', 1);
    
    $p->Ln(1);
    
    $p->SetFont('Arial', '', 12);
    $p->Cell(100, 10, utf8_decode($lang['RIEPILOGO_OFFERTA']), '',1);
    $p->Ln(2);
    
    
    if($rowPremioAttuale != null){
        
        $p->SetFont('Arial', '', 10);
        $p->Cell(65, 7, utf8_decode($dataPremio['nome']), '', 0);
        $p->Cell(65, 7, utf8_decode($lang['premio_attuale']), '', 0);
        $p->Cell(65, 7, $lang['POTENZIALE_DI_RISPARMIO'], '', 1);

        $p->SetFont('Arial', 'B', 11);
        $p->Cell(65, 7, 'CHF '.$dataPremio['premio_tot'] ." / ".$lang['MESE'], '', 0);
        $p->Cell(65, 7, 'CHF '.number_format(floatval($premioAttuale), 2)." / ".$lang['MESE'], '', 0);
        $p->Cell(65, 7, 'CHF '.$risparmio." / ".$lang['ANNO'], '', 1);
    }
    
    else{   
        $p->SetFont('Arial', '', 10);
        $p->Cell(65, 7, utf8_decode($dataPremio['nome']), '', 1);

        $p->SetFont('Arial', 'B', 11);
        $p->Cell(65, 7, 'CHF '.$dataPremio['premio_tot'] ." / ".$lang['MESE'], '', 1);
    }
    
    
    
    $p->SetFont('Arial', '',9);
    $p->Ln(5);
    $p->SetFont('Arial', '',15);
    $p->SetDrawColor(200);

    //dati persona/e
    $nPersone = $_REQUEST['n_persone'];
    
    
    for($i=1; $i <= $nPersone; $i++){
        
        $strSesso = 'radioSesso'.$i;
        $strNome = 'nome'.$i;
        $strCognome = 'cognome'.$i;
        $strNascitaD = 'nascita-d'.$i;
        $strNascitaM = 'nascita-m'.$i;
        $strNascitaY = 'anno'.$i;
        $strFranchgia = 'franchigia'.$i;
        $strInfortunio = 'radioInfortunio'.$i;
        $strNazionalita = 'nazionalita'.$i;
        $strSelectOspedale = 'selectOspedale'.$i;
        $strQuotaAssicurato = 'quota_assicurato'.$i;
        
        $strMedicinaAlternativa = 'medicina_alternativa'.$i;
        $strSostegnoMedico = 'sostegno_medico'.$i;
        $strPrevenzioneMedica = 'prevenzione_medica'.$i;
        $strAiutoDomestico = 'aiuto_domestico'.$i;
        $strMezziAusiliari = 'mezzi_ausiliari'.$i;
        $strVaccini = 'vaccini'.$i;
        $strSoggiorniCurativi = 'soggiorni_curativi'.$i;
        $strMedicamenti = 'medicamenti'.$i;
        $strMaternita = 'maternita'.$i;
        $strEmergenzaEstero = 'emergenza_estero'.$i;
        $strPsicoterapia = 'psicoterapia'.$i;
        $strLenti = 'lenti'.$i;
        $strSpitex = 'spitex'.$i;
        $strRicercaSalvataggio  = 'ricerca_e_salvataggio'.$i;
        $strTrasporto = 'trasporto'.$i;
        $strTrattamentiOdontoiatrici = 'trattamenti_odontoiatrici'.$i;
        $strCorrezioniOdontoiatrici = 'correzioni_odontoiatriche'.$i;
        
        
        
        $p->SetFont('Arial', '',15);
        if($nPersone > 1){
            $p->Cell(190, 8, utf8_decode($_POST[$strCognome] ." " . $_POST[$strNome]), 1, 1, '', true);
        }
        else{
            $p->Cell(190, 8, utf8_decode($_POST[$strCognome] ." " . $_POST[$strNome]), 1, 1, '', true);
        }
        
        $p->SetFont('Arial', '',10);
        $p->SetDrawColor(225);
        $p->Cell(80, 7, $lang['SESSO'], 'LTB', 0, '');
        $p->Cell(0, 7, utf8_decode($_POST[$strSesso]), 'TRB', 1, '');
        
        $p->Cell(80, 7, $lang['NOME'], 'LTB', 0, '');
        $p->Cell(0, 7, utf8_decode($_POST[$strNome]), 'TRB', 1, '');

        $p->Cell(80, 7, $lang['COGNOME'], 'LTB', 0, '');
        $p->Cell(0, 7, utf8_decode($_POST[$strCognome]), 'TRB', 1, '');

        $p->Cell(80, 7, $lang['NASCITA'], 'LTB', 0, '');
        $p->Cell(0, 7, utf8_decode($_POST[$strNascitaD]."/".$_POST[$strNascitaM]."/".$_POST[$strNascitaY]), 'TRB', 1, '');

        $p->Cell(80, 7, utf8_decode($lang['nazionalita']), 'LTB', 0, '');
        $p->Cell(0, 7, utf8_decode($_POST[$strNazionalita]), 'TRB', 1, '');

        //ASSICURAZIONE DI BASE
        $p->Ln(5);
        $p->SetDrawColor(200);
        $p->Cell(190, 8, utf8_decode($lang['ASSICURAZIONE_DI_BASE'] ), 1, 1, '', true);
        
        $p->SetDrawColor(225);
        $p->Cell(80, 7, $lang['FRANCHIGIA'], 'LTB', 0, '');
        $p->Cell(0, 7, utf8_decode($_POST[$strFranchgia]), 'TRB', 1, '');
        
        $p->Cell(80, 7, $lang['INFORTUNIO'], 'LTB', 0, '');
        $p->Cell(0, 7, utf8_decode($_POST[$strInfortunio]), 'TRB', 1, '');
        
        $p->Cell(80, 7, utf8_decode($lang['cassa_malati']), 'LTB', 0, '');
        $p->Cell(0, 7, utf8_decode($dataPremio['nome']), 'TRB', 1, '');

        $p->Cell(80, 7, utf8_decode($lang['tipo_tariffa']), 'LTB', 0, '');
        $p->Cell(0, 7, utf8_decode($dataPremio['tipo_tariffa']." - ". $dataPremio[$_REQUEST['lang']])." (".$dataPremio['id_tariffa'].")", 'TRB', 1, '');

        
        
        //assicurazione COMPLEMENTARE OSPEDALIERA
        $p->Ln(5);
        $p->SetDrawColor(200);
        $p->Cell(190, 8, utf8_decode($lang['Assicurazione complementare ospedaliera'] ), 1, 1, '', true);
        
        $p->SetDrawColor(225);
        $p->Cell(80, 7, utf8_decode($lang['SCELTA_DELL_OSPEDALE']), 'LTB', 0, '');
        $p->Cell(0, 7, utf8_decode($_POST[$strSelectOspedale]), 'TRB', 1, '');
        
        $p->Cell(80, 7, utf8_decode($lang['FRANCHIGIA']), 'LTB', 0, '');
        $p->Cell(0, 7, utf8_decode($_POST[$strQuotaAssicurato]), 'TRB', 1, '');

        $p->Ln(5);
        $p->SetDrawColor(200);
        $p->Cell(190, 8, utf8_decode($lang["Assicurazione complementare ambulatoriale"]), 1, 1, '', true);
        
        $p->Cell(60, 7, utf8_decode($lang['medicina_alternativa']), 'LTB', 0, '');
        $p->Cell(20, 7, isset($_REQUEST[$strMedicinaAlternativa]) ? $_REQUEST[$strMedicinaAlternativa] : $lang['NO'], 'TB', 0, '');
        $p->Cell(80, 7, utf8_decode($lang['sostegno_medico']), 'TB', 0, '');
        $p->Cell(0, 7, isset($_REQUEST[$strSostegnoMedico]) ? $_REQUEST[$strSostegnoMedico] : $lang['NO'], 'TBR', 1, '');
        
        $p->Cell(60, 7, utf8_decode($lang['prevenzione_medica']), 'LTB', 0, '');
        $p->Cell(20, 7, isset($_REQUEST[$strPrevenzioneMedica]) ? $_REQUEST[$strPrevenzioneMedica] : $lang['NO'], 'TB', 0, '');
        $p->Cell(80, 7, utf8_decode($lang['aiuto_domestico']), 'TB', 0, '');
        $p->Cell(0, 7, isset($_REQUEST[$strAiutoDomestico]) ? $_REQUEST[$strAiutoDomestico] : $lang['NO'], 'TBR', 1, '');
        
        $p->Cell(60, 7, utf8_decode($lang['mezzi_ausiliari']), 'LTB', 0, '');
        $p->Cell(20, 7, isset($_REQUEST[$strMezziAusiliari]) ? $_REQUEST[$strMezziAusiliari] : $lang['NO'], 'TB', 0, '');
        $p->Cell(80, 7, utf8_decode($lang['vaccini']), 'TB', 0, '');
        $p->Cell(0, 7, isset($_REQUEST[$strVaccini]) ? $_REQUEST[$strVaccini] : $lang['NO'], 'TBR', 1, '');
        
        $p->Cell(60, 7, utf8_decode($lang['soggiorni_curativi']), 'LTB', 0, '');
        $p->Cell(20, 7, isset($_REQUEST[$strSoggiorniCurativi]) ? $_REQUEST[$strSoggiorniCurativi] : $lang['NO'], 'TB', 0, '');
        $p->Cell(80, 7, utf8_decode($lang['medicamenti']), 'TB', 0, '');
        $p->Cell(0, 7, isset($_REQUEST[$strMedicamenti]) ? $_REQUEST[$strMedicamenti] : $lang['NO'], 'TBR', 1, '');
        
        $p->Cell(60, 7, utf8_decode($lang['maternita']), 'LTB', 0, '');
        $p->Cell(20, 7, isset($_REQUEST[$strMaternita]) ? $_REQUEST[$strMaternita] : $lang['NO'], 'TB', 0, '');
        $p->Cell(80, 7, utf8_decode($lang['emergenza_estero']), 'TB', 0, '');
        $p->Cell(0, 7, isset($_REQUEST[$strEmergenzaEstero]) ? $_REQUEST[$strEmergenzaEstero] : $lang['NO'], 'TBR', 1, '');
        
        $p->Cell(60, 7, utf8_decode($lang['psicoterapia']), 'LTB', 0, '');
        $p->Cell(20, 7, isset($_REQUEST[$strPsicoterapia]) ? $_REQUEST[$strPsicoterapia] : $lang['NO'], 'TB', 0, '');
        $p->Cell(80, 7, utf8_decode($lang['lenti']), 'TB', 0, '');
        $p->Cell(0, 7, isset($_REQUEST[$strLenti]) ? $_REQUEST[$strLenti] : $lang['NO'], 'TBR', 1, '');
        
        $p->Cell(60, 7, utf8_decode($lang['spitex']), 'LTB', 0, '');
        $p->Cell(20, 7, isset($_REQUEST[$strSpitex]) ? $_REQUEST[$strSpitex] : $lang['NO'], 'TB', 0, '');
        $p->Cell(80, 7, utf8_decode($lang['ricerca_e_salvataggio']), 'TB', 0, '');
        $p->Cell(0, 7, isset($_REQUEST[$strRicercaSalvataggio]) ? $_REQUEST[$strRicercaSalvataggio] : $lang['NO'], 'TBR', 1, '');
        
        $p->Cell(60, 7, utf8_decode($lang['trasporto']), 'LTB', 0, '');
        $p->Cell(20, 7, isset($_REQUEST[$strTrasporto]) ? $_REQUEST[$strTrasporto] : $lang['NO'], 'TB', 0, '');
        $p->Cell(80, 7, utf8_decode($lang['trattamenti_odontoiatrici']), 'TB', 0, '');
        $p->Cell(0, 7, isset($_REQUEST[$strTrattamentiOdontoiatrici]) ? $_REQUEST[$strTrattamentiOdontoiatrici] : $lang['NO'], 'TBR', 1, '');
        
        $p->Cell(60, 7, utf8_decode($lang['correzioni_odontoiatriche']), 'LTB', 0, '');
        $p->Cell(0, 7, isset($_REQUEST[$strCorrezioniOdontoiatrici]) ? $_REQUEST[$strCorrezioniOdontoiatrici] : $lang['NO'], 'TBR', 1, '');
        
        $p->AddPage();
        
    }
    
    $p->SetFont('Arial', '',15);
    $p->SetDrawColor(200);
    $p->Cell(190, 8, utf8_decode($lang['DATI_CONTATTO']), 1, 1, '', true);
    
    $p->SetFont('Arial', '',10);
    $p->SetDrawColor(225);
    $p->Cell(80, 7, utf8_decode($lang['VIA']), 'LTB', 0, '');
    $p->Cell(0, 7, utf8_decode($_REQUEST['via']), 'TRB', 1, '');
    
    $p->Cell(80, 7, 'PLZ', 'LTB', 0, '');
    $p->Cell(0, 7, utf8_decode($_REQUEST['plz']), 'TRB', 1, '');
    
    $p->Cell(80, 7, utf8_decode($lang['LUOGO']), 'LTB', 0, '');
    $p->Cell(0, 7, utf8_decode($_REQUEST['paese']), 'TRB', 1, '');
    
    if($_REQUEST['codCassaAttuale'] == '-2'){
        $p->Cell(80, 7, $lang['CASSA_ATTUALE'], 'LTB', 0, '');
        $p->Cell(0, 7, $lang['Nuovo in svizzera'], 'TRB', 1, '');
    }
    
    if($_REQUEST['codCassaAttuale'] == '-3'){
        $p->Cell(80, 7, $lang['CASSA_ATTUALE'], 'LTB', 0, '');
        $p->Cell(0, 7, $lang['Iscrizione prima della nascita'], 'TRB', 1, '');
    }
    
    
    
    
    $p->Cell(80, 7, utf8_decode($lang['TEL']), 'LTB', 0, '');
    $p->Cell(0, 7, utf8_decode($_REQUEST['tel']), 'TRB', 1, '');
    
    $p->Cell(80, 7, 'E-mail', 'LTB', 0, '');
    $p->Cell(0, 7, utf8_decode($_REQUEST['email']), 'TRB', 1, '');
    
    $p->Cell(80, 7, utf8_decode($lang['lingua_dell_offerta']), 'LTB', 0, '');
    $p->Cell(0, 7, utf8_decode($_REQUEST['selectLingua']), 'TRB', 1, '');
    
        
    $p->Cell(100, 7, utf8_decode($lang['comunicazione']), 0, 0, '');
    $p->MultiCell(0, 7, utf8_decode($_REQUEST['comunicazione']), 0, 1, '');
    
    
    
    
   
    
    if($rowPremioAttuale != null){
        
        $p->Ln(5);
        $p->SetFont('Arial', '',15);
        $p->Cell(190, 8, utf8_decode($lang['DATI_CASSA_ATTUALE']), 1, 1, '', true);
    
        $p->SetFont('Arial', '', 10);
        $p->Cell(80, 7, utf8_decode($lang['CASSA_ATTUALE']), 'LTB', 0, '');
        $p->Cell(0, 7, utf8_decode($text_cassa_attuale), 'TRB', 1, '');

        $p->Cell(80, 7, utf8_decode($lang['tipo_tariffa']), 'LTB', 0, '');
        $p->Cell(0, 7, $tipo_tariffa, 'TRB', 1, '');

        $p->Cell(80, 7, utf8_decode($lang['premio_attuale']), 'LTB', 0, '');
        $p->Cell(0, 7, 'CHF '.number_format(floatval($premioAttuale), 2), 'TRB', 1, '');
    }
    /*
    //dati di contatto
    $p->Ln(5);
    $p->SetFont('Arial', '',15);
    $p->SetDrawColor(200);
    $p->Cell(190, 8, utf8_decode($lang['dati_premio_assicurativo']), 1, 1, '', true);

    
    
    
    //vecchio modello
    $p->AddPage();
    $p->Ln(20);
    $p->SetTextColor(0);
    $p->SetFillColor(200);
    $p->SetFont('Arial', '', 18);
    $p->Cell(100, 15, utf8_decode($lang['RICHIESTA_CONTATTO'])." ".$_REQUEST['nome']. " ". $_REQUEST['cognome']);
    $p->Ln(15);

    $p->SetFont('Arial', '',9);


    $p->Ln(5);
    $p->SetFont('Arial', '',15);
    $p->SetDrawColor(200);
    $p->Cell(190, 8, utf8_decode($lang['dati_premio_assicurativo']), 1, 1, '', true);

    $p->SetFont('Arial', '',10);
    $p->SetDrawColor(225);
    $p->Cell(80, 7, $lang['SESSO'], 'LTB', 0, '');
    $p->Cell(0, 7, utf8_decode($_POST['radioSesso']), 'TRB', 1, '');


    $p->Cell(80, 7, $lang['NOME'], 'LTB', 0, '');
    $p->Cell(0, 7, utf8_decode($_POST['nome']), 'TRB', 1, '');

    $p->Cell(80, 7, $lang['COGNOME'], 'LTB', 0, '');
    $p->Cell(0, 7, utf8_decode($_POST['cognome']), 'TRB', 1, '');

    $p->Cell(80, 7, $lang['VIA'], 'LTB', 0, '');
    $p->Cell(0, 7, utf8_decode($_POST['via']), 'TRB', 1, '');

    $p->Cell(80, 7, $lang['NASCITA'], 'LTB', 0, '');
    $p->Cell(0, 7, utf8_decode($_POST['nascita1-dd']."/".$_POST['nascita1-mm']."/".$_POST['anno1']), 'TRB', 1, '');

    $p->Cell(80, 7, $lang['FRANCHIGIA'], 'LTB', 0, '');
    $p->Cell(0, 7, utf8_decode($_POST['franchigia1']), 'TRB', 1, '');
    
    $p->Cell(80, 7, 'PLZ / Ort', 'LTB', 0, '');
    $p->Cell(0, 7, $_POST['plz']." ".utf8_decode($_POST['paese']), 'TRB', 1, '');


    if($_REQUEST['id_premio_cassa_attuale'] != "-1"){

            $premioCassaAttuale = getPremio($_REQUEST['id_premio_cassa_attuale']);

            if($premioCassaAttuale != null){

                $text_cassa_attuale = $premioCassaAttuale['nome_display'];        
                $tipo_tariffa = $premioCassaAttuale['tipo_tariffa'] . " ". $premioCassaAttuale['id_tariffa'];        
                $premioAttuale = $premioCassaAttuale['premio'];

                $p->Cell(80, 7, utf8_decode($lang['CASSA_ATTUALE']), 'LTB', 0, '');
                $p->Cell(0, 7, utf8_decode($text_cassa_attuale), 'TRB', 1, '');

                $p->Cell(80, 7, utf8_decode($lang['tipo_tariffa']), 'LTB', 0, '');
                $p->Cell(0, 7, $tipo_tariffa, 'TRB', 1, '');

                $p->Cell(80, 7, utf8_decode($lang['premio_attuale']), 'LTB', 0, '');
                $p->Cell(0, 7, $premioAttuale, 'TRB', 1, '');
            }
    }
    
    if($_REQUEST['codCassaAttuale'] == '-2'){
        $p->Cell(80, 7, $lang['CASSA_ATTUALE'], 'LTB', 0, '');
        $p->Cell(0, 7, $lang['Nuovo in svizzera'], 'TRB', 1, '');
    }
    
    if($_REQUEST['codCassaAttuale'] == '-3'){
        $p->Cell(80, 7, $lang['CASSA_ATTUALE'], 'LTB', 0, '');
        $p->Cell(0, 7, $lang['Iscrizione prima della nascita'], 'TRB', 1, '');
    }
        
    $p->Cell(80, 7, utf8_decode($lang['cassa_malati']), 'LTB', 0, '');
    $p->Cell(0, 7, utf8_decode($premio['nome_display']), 'TRB', 1, '');   
    
    $p->Cell(80, 7, utf8_decode($lang['tipo_tariffa']), 'LTB', 0, '');
    $p->Cell(0, 7, $premio['tipo_tariffa']." ".$premio['id_tariffa'], 'TRB', 1, '');    
    
    $p->Cell(80, 7, utf8_decode($lang['premio_calcolato']), 'LTB', 0, '');
    $p->Cell(0, 7, $premio['premio'], 'TRB', 1, '');

    
    $p->Cell(80, 7, utf8_decode($lang['permesso_soggiorno']), 'LTB', 0, '');
    $p->Cell(0, 7, $_POST['permesso_soggiorno'], 'TRB', 1, '');
    
    $p->Cell(80, 7, utf8_decode($lang['lingua_dell_offerta']), 'LTB', 0, '');
    $p->Cell(0, 7, $_POST['selectLingua'], 'TRB', 1, '');

    $p->Cell(80, 7, $lang['TEL'], 'LTB', 0, '');
    $p->Cell(0, 7, $_POST['tel'], 'TRB', 1, '');

    $p->Cell(80, 7, 'E-mail', 'LTB', 0, '');
    $p->Cell(0, 7, $_POST['email'], 'TRB', 1, '');

    $p->Cell(80, 7, utf8_decode($lang['medico_famiglia']), 'LTB', 0, '');
    $p->Cell(0, 7, utf8_decode($_POST['medico_famiglia']), 'TRB', 'L');


    if($_REQUEST['n_persone'] > 1 ){        
    $p->Ln(15);
    
    if($_REQUEST['n_persone'] >= 4){
        $p->AddPage();
        $p->Ln(40);
    }
    
    $p->SetFont('Arial', '',15);
    $p->SetDrawColor(200);
    $p->Cell(190, 8, utf8_decode($lang['Dati persone aggiuntive']), 1, 1, '', true);
    $p->SetFont('Arial', '',9);

    for($i=2; $i <= $_REQUEST['n_persone']; $i++){
            $nascita = "nascita".$i;
            $selectFranchigia = "selectFranchigia".$i;

            $p->SetFont('Arial', 'B',9);
            $p->Cell(80, 7, $i."a Persona", 'LTB', 0, '');        
            $p->Cell(0, 7, "", 'TRB', 1, '');

            $p->SetFont('Arial', '',9);
            $p->Cell(80, 7, $lang['NASCITA'], 'LTB', 0, '');
            $p->Cell(0, 7, $_POST[$nascita], 'TRB', 1, '');

            $p->Cell(80, 7, $lang['FRANCHIGIA'], 'LTB', 0, '');
            $p->Cell(0, 7, $_POST[$selectFranchigia], 'TRB', 1, '');
       }
    }

    $p->AddPage();
    
    $p->Ln(40);
    $p->SetFont('Arial', '',15);
    $p->SetDrawColor(200);
    $p->Cell(190, 8, utf8_decode($lang["Dati supplementari personali"]), 1, 1, '', true);

    $p->SetFont('Arial', '',10);
    $p->SetDrawColor(225);
    $p->Cell(125, 7, utf8_decode($lang['SCELTA_DELL_OSPEDALE']), 'LTB', 0, '');
    $p->Cell(0, 7,  utf8_decode($_POST['selectOspedale']), 'TRB', 1, '');


    $p->Cell(125, 7, utf8_decode($lang['QUOTA_ASSICURATO']), 'LTB', 0, '');
    $p->Cell(0, 7, $_REQUEST['quota_assicurato'], 'TRB', 1, '');

    $p->Cell(125, 7, utf8_decode($lang['trattamento_del_medico_primario']), 'LTB', 0, '');
    $p->Cell(0, 7, isset($_REQUEST['trattamento_medico']) ? $_REQUEST['trattamento_medico'] : $lang['NO'], 'TRB', 1, '');

    $p->Cell(125, 7, utf8_decode($lang['trattamenti_estero']), 'LTB', 0, '');
    $p->Cell(0, 7, isset($_REQUEST['trattamenti_estero']) ? $_REQUEST['trattamenti_estero'] : $lang['NO'], 'TRB', 1, '');

    $p->Cell(125, 7, utf8_decode($lang['assicurazione_dentale']), 'LTB', 0, '');
    $p->Cell(0, 7, isset($_REQUEST['assicurazione_dentale']) ? $_REQUEST['assicurazione_dentale'] : $lang['NO'], 'TRB', 1, '');

    $p->Cell(125, 7, utf8_decode($lang['esmi_checkup_vacc']), 'LTB', 0, '');
    $p->Cell(0, 7, isset($_REQUEST['esmi_checkup_vacc']) ? $_REQUEST['esmi_checkup_vacc'] : $lang['NO'], 'TRB', 1, '');
    
    $p->Cell(125, 7, utf8_decode($lang['metodi_alternativi']), 'LTB', 0, '');
    $p->Cell(0, 7, isset($_REQUEST['metodi_alternativi'])? $_REQUEST['metodi_alternativi'] : $lang['NO'], 'TRB', 1, '');
    
    $p->Cell(125, 7, utf8_decode($lang['viaggia_all_estero']), 'LTB', 0, '');
    $p->Cell(0, 7, isset($_REQUEST['viaggia_all_estero']) ? $_REQUEST['viaggia_all_estero'] : $lang['NO'], 'TRB', 1, '');

    $p->Cell(125, 7, utf8_decode($lang['desidera_aiuti']), 'LTB', 0, '');
    $p->Cell(0, 7, isset($_REQUEST['desidera_aiuti']) ? $_REQUEST['desidera_aiuti'] : $lang['NO'], 'TRB', 1, '');

    $p->Cell(125, 7, utf8_decode($lang['costi_salvataggio']), 'LTB', 0, '');
    $p->Cell(0, 7, isset($_REQUEST['costi_salvataggio']) ? $_REQUEST['costi_salvataggio'] : $lang['NO'],  'TRB', 1, '');
    
    $p->Cell(125, 7, utf8_decode($lang['medicinali_malattia']), 'LTB', 0, '');
    $p->Cell(0, 7, isset($_REQUEST['medicinali_malattia']) ? $_REQUEST['medicinali_malattia'] : $lang['NO'], 'TRB', 1, '');
    
    $p->Cell(125, 7, utf8_decode($lang['capitale_decesso']), 'LTB', 0, '');
    $p->Cell(0, 7, isset($_REQUEST['capitale_decesso']) ? $_REQUEST['capitale_decesso'] : $lang['NO'], 'TRB', 1, '');
    
    $p->Cell(125, 7, utf8_decode($lang['media_annua_bollette']), 'LTB', 0, '');
    $p->Cell(0, 7, utf8_decode($_REQUEST['media_annua_bollette']), 'TRB', 1, '');
    
    $p->Cell(125, 7, utf8_decode($lang['aspettative_del_sevizio']), 'LTB', 0, '');
    $p->MultiCell(0, 7, utf8_decode($_REQUEST['aspettative_del_sevizio']), 'TRB', 1, '');
    
    $p->Cell(90, 7, utf8_decode($lang['comunicazione']), 0, 0, '');
    $p->MultiCell(0, 7, utf8_decode($_REQUEST['comunicazione']), 0, 1, '');
    
     * 
     * 
     */
   
        // email di Claude
     //$to = "dario.sgamba@gmail.com"; 
     
     $subject = utf8_decode($lang['Richiesta nuova offerta']).": ".$_REQUEST['cognome1']." ".$_REQUEST['nome1']; 
     $message = "<p>" .  utf8_decode($lang['Nuova proposta nel file in allegato']) . "</p>";
     // a random hash will be necessary to send mixed content
     $separator = md5(time());
     // carriage return type (we use a PHP end of line constant)
     $eol = PHP_EOL;
     // attachment name
     $filename = utf8_decode($lang['proposta'])." ".$_REQUEST['cognome1']." ".$_REQUEST['nome1'].".pdf";
     // encode data (puts attachment in proper format)
     $pdfdoc = $p->Output("", "S");
     $attachment = chunk_split(base64_encode($pdfdoc));
     // main header (multipart mandatory)
     $headers  = "From: ".$from.$eol;
     $headers .= "MIME-Version: 1.0".$eol; 
     $headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"".$eol.$eol; 
     $headers .= "Content-Transfer-Encoding: 7bit".$eol;
     $headers .= "This is a MIME encoded message.".$eol.$eol;
     // message
     $headers .= "--".$separator.$eol;
     $headers .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
     $headers .= "Content-Transfer-Encoding: 7bit".$eol.$eol;
     $headers .= $message.$eol.$eol;
     // attachment
     $headers .= "--".$separator.$eol;
     $headers .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol; 
     $headers .= "Content-Transfer-Encoding: base64".$eol;
     $headers .= "Content-Disposition: attachment".$eol.$eol;
     $headers .= $attachment.$eol.$eol;
     $headers .= "--".$separator."--";

    
    //$risultato = mail($to, $subject, "", $headers);

    
    
    
    
    
   
    
    
    $email = new PHPMailer();
    $email->From      = $_REQUEST['email'];
    $email->FromName  = $_REQUEST['cognome1']." ".$_REQUEST['nome1'];
    $email->Subject   = $subject;
    $email->Body      = utf8_decode($lang['Nuova proposta nel file in allegato']);
    
    //$email->AddAddress( 'dario.sgamba@gmail.com' ); //MAIL DI DARIO
    $email->AddAddress( 'claude.grenacher@versicherungs-broker.ch' ); //MAIL DI CLAUDE
    $name = "Offertenanfrage Krankenkassenvergleich " . $_REQUEST['cognome1'] . ".pdf";
    
    $path = ROOT_PATH."/pdf/pdf/".$name;
    $url = Utils::getBaseUrl()."/php/pdf/pdf/".$name;
    $p->Output("pdf/".$name, 'F');

    $email->addAttachment( $path , $name);
    

    
    header('Content-Type: application/json');
    if($_REQUEST['action'] == "inviarichiesta"){
        if(!$email->Send()){
           echo json_encode(array('error' => utf8_decode($lang['MAIL_NON_INVIATA'])));
        }
        else {
            echo json_encode(array('inviata'=> "ok", 'url' => $url, 'name' => $name));
        }
        
        //chiudiamo la connessione
        //$messaggio->SmtpClose();
        unset($email);

    }

    
    
    if($_REQUEST['action'] == "viewpdf"){
        $name = date("YmdHis").".pdf";
        $risultato['name'] = $name;
        $risultato['url'] = Utils::getBaseUrl()."/php/pdf/pdf/".$name;

        $p->Output("pdf/".$name, 'F');

        echo json_encode($risultato);
    }
}
catch(PDOException $e){
        echo '<div class="alert">'.$e->getMessage().'</div>';
    }
    

?>