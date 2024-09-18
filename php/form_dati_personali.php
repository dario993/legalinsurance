<?php

    error_reporting(E_ALL ^ E_DEPRECATED ^ E_NOTICE ^ E_WARNING);
    ini_set('display_errors','On');
    
    session_start();
    
    include_once 'common.php'; 
   
    //header('Content-Type: html');
    
    
?>

<div class="col-sm-12 col-lg-7">

<form id="formAnagrafica" class="form-horizontal" role="form" >
    
    <?php 
     $nPersone = $_REQUEST['n_persone'];
     for ($p=1; $p <= $nPersone; $p++ ){

         $stringAnno = 'anno'.$p;
         $stringFranchigia = 'franchigia'.$p;
         $stringInfortunio = 'radioInfortunio' . $p;
     ?>

    <div id="dati-anagrafici" class="panel">
        <div class="panel-heading"><h4 class="titolo-div"><?php echo $lang['I_SUOI_DATI'];
            if($nPersone > 1){
                echo ' - '.$lang['PERSONA'] . ' n°'.  $p;
            }?>
        </h4></div>
        
        <div class="panel-body"> <!-- panel body dati anagrfici -->
            <!-- Multiple Radios (inline) -->
            <div id="sesso" class="form-group">
                <label class="col-md-4 control-label" for="radioSesso<?php echo $p?>"><?php echo $lang['SESSO']; ?></label>
                <div class="btn-group col-md-8" data-toggle="buttons">
                    <label class="btn btn-default">
                        <input type="radio" name="radioSesso<?php echo $p?>"  value="<?php echo $lang['UOMO'] ?>" class="form-control validate[required]" >
                   <?php echo $lang['UOMO'] ?></label>
                   <label class="btn btn-default">
                       <input type="radio" name="radioSesso<?php echo $p?>"  value="<?php echo $lang['DONNA'] ?>" class="form-control validate[required]" data-validation-engine="validate[required]">
                   <?php echo $lang['DONNA'] ?></label>
               </div>                                
            </div>

             <!-- Text input-->
            <div class="form-group has-feedback">
              <label class="col-md-4 control-label" for="nome"><?php echo $lang['NOME']; ?></label>  
              <div class="col-md-8">
                  <input name="nome<?php echo $p?>" type="text" placeholder="" class="form-control input-md validate[required]" data-validation-engine="validate[required]">
                  <div class="help-block with-errors"></div>
              </div>

            </div>

            <!-- Text input-->
            <div class="form-group has-feedback">
              <label class="col-md-4 control-label" for="cognome"><?php echo $lang['COGNOME']; ?></label>  
              <div class="col-md-8">
                  <input name="cognome<?php echo $p?>" type="text" placeholder="" class="form-control input-md validate[required]" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="form-group" id='form-group-nascita<?php echo $p?>' >
                  <label class="col-md-4 control-label" for="nascita"><?php echo $lang['NASCITA'] ?></label>  
                  <div class="col-md-8" style="padding:0">
                    <div class="col-xs-4">
                        <input  name="nascita-d<?php echo $p?>" type="text" placeholder="DD" class="form-control input-md  nascitaN validate[required]" maxlength="2" min="1" max="31" data-validation-engine="validate[required]">
                    </div>
                    <div class="col-xs-4">
                        <input  name="nascita-m<?php echo $p?>" type="text" placeholder="MM" class="form-control input-md  nascitaN validate[required]" maxlength="2" min="1" max="12" data-validation-engine="validate[required]">
                    </div>
                    <div class="col-xs-4">
                        <input  name="nascita-y<?php echo $p?>" type="text" placeholder="<?php echo $_REQUEST[$stringAnno] ?>" class="form-control input-md  nascitaN" data-validation-engine="validate[required]" disabled>
                    </div>
                  </div>
                </div>

               <!-- Text input-->
               <div class="form-group" id="">
                   <label class="col-md-4 control-label" for="franchigia"><?php echo $lang['FRANCHIGIA'] ?></label>
                   <div class="col-md-8">
                       <input name="franchigia<?php echo $p?>" type="text" placeholder="<?PHP echo $_REQUEST[$stringFranchigia]?>" class="form-control input-md" disabled>
                   </div>      
               </div>

               <div class="form-group" id="">
                  <label class="col-md-4 control-label" for="nazionalita"><?php echo $lang['nazionalita']?></label>  
                  <div class="col-md-8">
                      <input name="nazionalita<?php echo $p?>" type="text" placeholder="" class="form-control input-md validate[required]">
                  </div>
                </div>
        </div> <!-- panel-body dati anagrafici -->
           
    </div><!-- panel-default dati anagrafici -->  
       
    <div class="panel-group" id="accordion<?php echo $p?>">
        <div class="panel panel-complementari">
          <div class="panel-heading">
            <h3 class="panel-title">
              <a class="accordion-toggle" data-toggle="collapse"  href="#collapseOne<?php echo $p?>">
                <?php echo $lang['Assicurazione complementare ospedaliera'] ?>
              </a>
            </h3>
          </div>
          <div id="collapseOne<?php echo $p?>" class="panel-collapse collapse in">
            <div class="panel-body">
                <!-- collapse ASSICURAZIONE OSPEDALIERA -->
                
                <!-- SCELTA OSPEDALE-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="selectOspedale"><?php echo $lang['SCELTA_DELL_OSPEDALE']; ?></label>  
                    <div class="col-md-8">
                    <select class="form-control input-md selectpicker"  name="selectOspedale<?php echo $p?>" title="<?php echo $lang['SELEZIONA']; ?>">
                         <option data-hidden="true" value=""><?php echo $lang['SELEZIONA'] ?></option>
                         <option value="<?php echo $lang['reparto_comune_in_tutta_la_svizzera']; ?>"><?php echo $lang['reparto_comune_in_tutta_la_svizzera']; ?></option>
                         <option value="<?php echo $lang['reparto_semiprivato']; ?>"><?php echo $lang['reparto_semiprivato']; ?></option>
                         <option value="<?php echo $lang['reparto_privato']; ?>"><?php echo $lang['reparto_privato']; ?></option>
                         <option value="<?php echo $lang['reparto_privato_in_tutto_il_mondo']; ?>"><?php echo $lang['reparto_privato_in_tutto_il_mondo']; ?></option>
                         <option value="<?php echo $lang['scelta_flessibile_del_reparto']; ?>"><?php echo $lang['scelta_flessibile_del_reparto']; ?></option>
                    </select>                                            
                    </div>
                </div>
                
                 <!-- FRANCHIGIA  X OSPEDALE-->
                <div class="form-group">
                <label class="col-md-4 control-label" for="quota_assicurato"><?php echo $lang['QUOTA_ASSICURATO']; ?></label>  
                <div class="col-md-8 bs-select">
                    <select class="form-control input-md selectpicker"  name="quota_assicurato<?php echo $p?>" title="<?php echo $lang['SELEZIONA']; ?>">
                        <option data-hidden="true" value=""><?php echo $lang['SELEZIONA'] ?></option>
                        <option value="00">CHF 0</option>
                        <option value="1000">CHF 1000</option>
                        <option value="2000">CHF 2000</option>
                        <option value="3000">CHF 3000</option>
                        <option value="4000">CHF 4000</option>
                        <option value="5000">CHF 5000</option>
                        <option value="7000">CHF 7000</option>
                        <option value="8000">CHF 8000</option>
                        <option value="14000">CHF 14000</option>
                    </select>                                            
                </div>
                </div>

            </div>
          </div>
        </div>
        <div class="panel panel-complementari">
          <div class="panel-heading">
            <h3 class="panel-title">
              <a class="accordion-toggle" data-toggle="collapse"  href="#collapseTwo<?php echo $p?>">
                <?php echo $lang['Assicurazione complementare ambulatoriale'] ?>
              </a>
            </h3>
          </div>
          <div id="collapseTwo<?php echo $p?>" class="panel-collapse collapse in">
            <div class="panel-body">
                <div class="form-group">
                    <div class="col-sm-6">
                        <div class="checkbox">
                        <input id="medicina_alternativa<?php echo $p?>" type="checkbox" value="<?php echo $lang['SI']?>" name="medicina_alternativa<?php echo $p?>">
                        <label for="medicina_alternativa<?php echo $p?>"><?php echo $lang['medicina_alternativa']; ?></label>
                        <a tabindex="0"
                        class="pull-right" 
                        data-html="true" 
                        data-placement="bottom"
                        data-toggle="popover" 
                        data-trigger="focus" 
                        data-container="body"
                        title="<b><?php echo $lang['medicina_alternativa']; ?></b>" 
                        data-content="<p><?php echo $lang['medicina_alternativa_tooltip'] ?></p>"><i class="glyphicon glyphicon-info-sign"></i></a>
                    </div>
                    
                    </div>
                    <div class="col-sm-6">
                        <div class="checkbox">
                             <input id="sostegno_medico<?php echo $p?>" type="checkbox" value="<?php echo $lang['SI']?>" name="sostegno_medico<?php echo $p?>" class="">
                             <label for="sostegno_medico<?php echo $p?>" ><?php echo  $lang['sostegno_medico']?></label>
                             <a tabindex="0"
                            class="pull-right" 
                            data-html="true" 
                            data-placement="bottom"
                            data-toggle="popover" 
                            data-trigger="focus" 
                            data-container="body"
                            title="<b><?php echo $lang['sostegno_medico'] ?></b>" 
                            data-content="<p><?php echo $lang['sostegno_medico_tooltip'] ?></p>"><i class="glyphicon glyphicon-info-sign"></i></a>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-6">
                        <div class="checkbox">
                              <input id="prevenzione_medica<?php echo $p?>" type="checkbox" value="<?php echo $lang['SI']?>" name="prevenzione_medica<?php echo $p?>" class="">
                              <label for="prevenzione_medica<?php echo $p?>" ><?php echo $lang['prevenzione_medica']; ?></label>
                               <a tabindex="0"
                            class="pull-right" 
                            data-html="true" 
                            data-placement="bottom"
                            data-toggle="popover" 
                            data-trigger="focus" 
                            data-container="body"
                            title="<b><?php echo $lang['prevenzione_medica'] ?></b>" 
                            data-content="<p><?php echo $lang['prevenzione_medica_tooltip'] ?></p>"><i class="glyphicon glyphicon-info-sign"></i></a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="checkbox">
                             <input id="aiuto_domestico<?php echo $p?>" type="checkbox" value="<?php echo $lang['SI']?>" name="aiuto_domestico<?php echo $p?>" class="">
                             <label for="aiuto_domestico<?php echo $p?>" ><?php echo  $lang['aiuto_domestico']?></label>
                             <a tabindex="0" class="pull-right" data-html="true" data-placement="bottom" data-toggle="popover" data-trigger="focus" data-container="body" 
                                title="<b><?php echo $lang['aiuto_domestico'] ?></b>" 
                                data-content="<p><?php echo $lang['aiuto_domestico_tooltip'] ?></p>"><i class="glyphicon glyphicon-info-sign"></i></a>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-6">
                        <div class="checkbox">
                             <input id="mezzi_ausiliari<?php echo $p?>" type="checkbox" value="<?php echo $lang['SI']?>" name="mezzi_ausiliari<?php echo $p?>" class="">
                             <label for="mezzi_ausiliari<?php echo $p?>" ><?php echo $lang['mezzi_ausiliari']; ?></label>
                             <a tabindex="0" class="pull-right" data-html="true" data-placement="bottom" data-toggle="popover" data-trigger="focus" data-container="body" 
                                title="<b><?php echo $lang['mezzi_ausiliari'] ?></b>" 
                                data-content="<p><?php echo $lang['mezzi_ausiliari_tooltip'] ?></p>"><i class="glyphicon glyphicon-info-sign"></i></a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="checkbox">
                             <input id="vaccini<?php echo $p?>" type="checkbox" value="<?php echo $lang['SI']?>" name="vaccini<?php echo $p?>" class="">
                             <label for="vaccini<?php echo $p?>" ><?php echo  $lang['vaccini']?></label>
                             <a tabindex="0" class="pull-right" data-html="true" data-placement="bottom" data-toggle="popover" data-trigger="focus" data-container="body" 
                                title="<b><?php echo $lang['vaccini'] ?></b>" 
                                data-content="<p><?php echo $lang['vaccini_tooltip'] ?></p>"><i class="glyphicon glyphicon-info-sign"></i></a>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-6">
                        <div class="checkbox">
                             <input id="soggiorni_curativi<?php echo $p?>" type="checkbox" value="<?php echo $lang['SI']?>" name="soggiorni_curativi<?php echo $p?>" class="">
                             <label for="soggiorni_curativi<?php echo $p?>" ><?php echo $lang['soggiorni_curativi']; ?></label>
                             <a tabindex="0" class="pull-right" data-html="true" data-placement="bottom" data-toggle="popover" data-trigger="focus" data-container="body" 
                                title="<b><?php echo $lang['soggiorni_curativi'] ?></b>" 
                                data-content="<p><?php echo $lang['soggiorni_curativi_tooltip'] ?></p>"><i class="glyphicon glyphicon-info-sign"></i></a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="checkbox">
                             <input id="medicamenti<?php echo $p?>" type="checkbox" value="<?php echo $lang['SI']?>" name="medicamenti<?php echo $p?>" class="">
                             <label for="medicamenti<?php echo $p?>" ><?php echo  $lang['medicamenti']?></label>
                             <a tabindex="0" class="pull-right" data-html="true" data-placement="bottom" data-toggle="popover" data-trigger="focus" data-container="body" 
                                title="<b><?php echo $lang['medicamenti'] ?></b>" 
                                data-content="<p><?php echo $lang['medicamenti_tooltip'] ?></p>"><i class="glyphicon glyphicon-info-sign"></i></a>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-6">
                        <div class="checkbox">
                             <input id="maternita<?php echo $p?>" type="checkbox" value="<?php echo $lang['SI']?>" name="maternita<?php echo $p?>" class="">
                             <label for="maternita<?php echo $p?>" ><?php echo $lang['maternita']; ?></label>
                             <a tabindex="0" class="pull-right" data-html="true" data-placement="bottom" data-toggle="popover" data-trigger="focus" data-container="body" 
                                title="<b><?php echo $lang['maternita'] ?></b>" 
                                data-content="<p><?php echo $lang['maternita_tooltip'] ?></p>"><i class="glyphicon glyphicon-info-sign"></i></a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="checkbox">
                             <input id="emergenza_estero<?php echo $p?>" type="checkbox" value="<?php echo $lang['SI']?>" name="emergenza_estero<?php echo $p?>" class="">
                             <label for="emergenza_estero<?php echo $p?>" ><?php echo  $lang['emergenza_estero']?></label>
                             <a tabindex="0" class="pull-right" data-html="true" data-placement="bottom" data-toggle="popover" data-trigger="focus" data-container="body" 
                                title="<b><?php echo $lang['emergenza_estero'] ?></b>" 
                                data-content="<p><?php echo $lang['emergenza_estero_tooltip'] ?></p>"><i class="glyphicon glyphicon-info-sign"></i></a>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-6">
                        <div class="checkbox">
                             <input id="psicoterapia<?php echo $p?>" type="checkbox" value="<?php echo $lang['SI']?>" name="psicoterapia<?php echo $p?>" class="">
                             <label for="psicoterapia<?php echo $p?>" ><?php echo $lang['psicoterapia']; ?></label>
                             <a tabindex="0" class="pull-right" data-html="true" data-placement="bottom" data-toggle="popover" data-trigger="focus" data-container="body" 
                                title="<b><?php echo $lang['psicoterapia'] ?></b>" 
                                data-content="<p><?php echo $lang['psicoterapia_tooltip'] ?></p>"><i class="glyphicon glyphicon-info-sign"></i></a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="checkbox">
                             <input id="lenti<?php echo $p?>" type="checkbox" value="<?php echo $lang['SI']?>" name="lenti<?php echo $p?>" class="">
                             <label for="lenti<?php echo $p?>" ><?php echo  $lang['lenti']?></label>
                             <a tabindex="0" class="pull-right" data-html="true" data-placement="bottom" data-toggle="popover" data-trigger="focus" data-container="body" 
                                title="<b><?php echo $lang['lenti'] ?></b>" 
                                data-content="<p><?php echo $lang['lenti_tooltip'] ?></p>"><i class="glyphicon glyphicon-info-sign"></i></a>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-6">
                        <div class="checkbox">
                             <input id="spitex<?php echo $p?>" type="checkbox" value="<?php echo $lang['SI']?>" name="spitex<?php echo $p?>" class="">
                             <label for="spitex<?php echo $p?>" ><?php echo $lang['spitex']; ?></label>
                             <a tabindex="0" class="pull-right" data-html="true" data-placement="bottom" data-toggle="popover" data-trigger="focus" data-container="body" 
                                title="<b><?php echo $lang['spitex'] ?></b>" 
                                data-content="<p><?php echo $lang['spitex_tooltip'] ?></p>"><i class="glyphicon glyphicon-info-sign"></i></a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="checkbox">
                             <input id="ricerca_e_salvataggio<?php echo $p?>" type="checkbox" value="<?php echo $lang['SI']?>" name="ricerca_e_salvataggio<?php echo $p?>" class="">
                             <label for="ricerca_e_salvataggio<?php echo $p?>" ><?php echo  $lang['ricerca_e_salvataggio']?></label>
                             <a tabindex="0" class="pull-right" data-html="true" data-placement="bottom" data-toggle="popover" data-trigger="focus" data-container="body" 
                                title="<b><?php echo $lang['ricerca_e_salvataggio'] ?></b>" 
                                data-content="<p><?php echo $lang['ricerca_e_salvataggio_tooltip'] ?></p>"><i class="glyphicon glyphicon-info-sign"></i></a>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-6">
                        <div class="checkbox">
                             <input id="trasporto<?php echo $p?>" type="checkbox" value="<?php echo $lang['SI']?>" name="trasporto<?php echo $p?>" class="">
                             <label for="trasporto<?php echo $p?>" ><?php echo $lang['trasporto']; ?></label>
                             <a tabindex="0" class="pull-right" data-html="true" data-placement="bottom" data-toggle="popover" data-trigger="focus" data-container="body" 
                                title="<b><?php echo $lang['trasporto'] ?></b>" 
                                data-content="<p><?php echo $lang['trasporto_tooltip'] ?></p>"><i class="glyphicon glyphicon-info-sign"></i></a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="checkbox">
                             <input id="trattamenti_odontoiatrici<?php echo $p?>" type="checkbox" value="<?php echo $lang['SI']?>" name="trattamenti_odontoiatrici<?php echo $p?>" class="">
                             <label for="trattamenti_odontoiatrici<?php echo $p?>" ><?php echo  $lang['trattamenti_odontoiatrici']?></label>
                             <a tabindex="0" class="pull-right" data-html="true" data-placement="bottom" data-toggle="popover" data-trigger="focus" data-container="body" 
                                title="<b><?php echo $lang['trattamenti_odontoiatrici'] ?></b>" 
                                data-content="<p><?php echo $lang['trattamenti_odontoiatrici_tooltip'] ?></p>"><i class="glyphicon glyphicon-info-sign"></i></a>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-6">
                        <div class="checkbox">
                             <input id="correzioni_odontoiatriche<?php echo $p?>" type="checkbox" value="<?php echo $lang['SI']?>" name="correzioni_odontoiatriche<?php echo $p?>" class="">
                             <label for="correzioni_odontoiatriche<?php echo $p?>" ><?php echo $lang['correzioni_odontoiatriche']; ?></label>
                             <a tabindex="0" class="pull-right" data-html="true" data-placement="bottom" data-toggle="popover" data-trigger="focus" data-container="body" 
                                title="<b><?php echo $lang['correzioni_odontoiatriche'] ?></b>" 
                                data-content="<p><?php echo $lang['correzioni_odontoiatriche_tooltip'] ?></p>"><i class="glyphicon glyphicon-info-sign"></i></a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                         
                    </div>
                </div>
            </div>
          </div>
        </div>
     </div>
        
    <hr>
    
             <?php } ?>
    
    
    <div id="dati-contatto" class="panel">
        <div class="panel-heading"><h4 class="titolo-div"><?php echo $lang['DATI_CONTATTO']; ?></h4></div>

        <div class="panel-body">
            <!-- Text input-->
            <div class="form-group">
              <label class="col-md-4 control-label" for="via"><?php echo $lang['VIA'].", n°"; ?></label>  
              <div class="col-md-8">
                  <input id="via" name="via" type="text" placeholder="" class="form-control input-md validate[required]" data-validation-engine="validate[required]">
              </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
              <label class="col-md-4 control-label" for="plz_anagrafica">PLZ</label>  
              <div class="col-md-8">
                  <input id="plz_anagrafica" name="plz_anagrafica" type="text" placeholder="<?php echo $_REQUEST['plz']?>" class="form-control input-md" disabled>
              </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
              <label class="col-md-4 control-label" for="paese_anagrafia"><?php echo $lang['LUOGO']; ?></label>  
              <div class="col-md-8">
                  <input id="paese_anagrafia" name="paese_anagrafia" type="text" placeholder="<?php echo $_REQUEST['paese']?>" class="form-control input-md" disabled>
              </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
              <label class="col-md-4 control-label" for="tel"><?php echo $lang['TEL'] ?></label>  
              <div class="col-md-8">
                  <input id="tel" name="tel" type="text" placeholder="" class="form-control input-md validate[required]" data-validation-engine="validate[required]">
                  <div class="help-block with-errors"></div>
              </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
              <label class="col-md-4 control-label" for="email">E-mail</label>  
              <div class="col-md-8">
                  <input id="email" name="email" type="text" placeholder="" class="form-control input-md validate[required]" data-validation-engine="validate[required,custom[email]]">
              </div>
            </div>

            <div class="form-group has-feedback">
                <label class="col-md-4 control-label" for='selectLingua'><?php echo $lang['lingua_dell_offerta'] ?></label>
                <div class="col-md-8">
                    <select id="selectLingua" class="form-control selectpicker validate[required]"  name="selectLingua" title="<?php echo $lang['SELEZIONA'] ?>" >
                        <option data-hidden="true" value=""><?php echo $lang['SELEZIONA'] ?></option>
                        <option value="<?php echo $lang['ITALIANO'] ?>"><?php echo $lang['ITALIANO'] ?></option>
                        <option value="<?php echo $lang['TEDESCO'] ?>"><?php echo $lang['TEDESCO']   ?></option>
                        <option value="<?php echo $lang['INGLESE'] ?>"><?php echo $lang['INGLESE']   ?></option>
                        <option value="<?php echo $lang['FRANCESE'] ?>"><?php echo $lang['FRANCESE'] ?></option>
                    </select>                                            
                </div>
            </div>
            
             <!-- Text input-->
           <div class="form-group">
                <label class="col-md-4 control-label" for="comunicazione"><?php echo $lang['comunicazione']; ?></label>  
                <div class="col-md-8">
                    <textarea class="form-control" rows="5" id="comunicazione" name="comunicazione"></textarea>                                          
                </div>
           </div>
           
           <div class="form-group" style="margin-top: 20px">
               <div class="col-sm-4"></div>
                <div class="col-sm-8">
                   <button id="btnInvia" type="button" class="btn btn-default pull-right" style="min-width: 130px;"><?php echo $lang['INVIA']; ?></button>
                </div>
           </div>
        </div>
        
    </div><!-- fine panel dati di contatto -->
    
    <hr>
    
</form>
</div>