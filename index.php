<!doctype html>
<html lang="it">
  <head>

<?php 
    $level = "./";
    include_once ('php/common.php'); 
    include_once ('php/define.php');    
?>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <link href="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.css" rel="stylesheet">
    
    <link href="css/datepicker/bootstrap-datepicker3.css" type="text/css" rel="stylesheet">
    <link href="font/lato/latofonts.css" rel="stylesheet" type="text/css">
    <link href="css/style.css" rel="stylesheet" media="all">
    <link href="css/validationEngine/validationEngine.jquery.css" rel="stylesheet" media="all">    
    <title>Legalinsurance</title>
  </head>
  <body>
<div class="container">
    <div class="row" style="margin-bottom: 30px">
            <div class="stepwizard col-xs-offset-3 col-sm-12 col-lg-offset-1 col-lg-8">
                <div class="stepwizard-row setup-panel">
                <div class="stepwizard-step">
                    <a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
                
                </div>
                <div class="stepwizard-step">
                    <a href="#step-2" type="button" class="btn btn-default btn-circle disabled" >2</a>
                
                </div>
                <div class="stepwizard-step">
                    <a href="#step-3" type="button" class="btn btn-default btn-circle disabled">3</a>
                    
                </div>
                </div>
            </div>    
        </div>
            
        
        <!-- STEP 1 -->
            <div class="row setup-content" id="step-1">
                <div class="col-12">
                    <form id="formInsurance" class="form-horizontal" role = "form" method="post">
                           <div class="form-group">
                                <h3 for="inputNascita">Data di nascita</h3>
                                <input type="text" class="form-control" id="inputNascita" maxlength="10" name="inputNascita" data-validation-engine="validate[required]" aria-describedby="nascitaHelp">
                                <small id="nascitaHelp" class="form-text text-muted">Inserisci nel formato corretto gg/mm/aaaa</small>
                            </div>

                            <div class="form-group">
                                <h3 for="selectAssicurazione">Precedente assicurazione</h3>
                                <select id="selectAssicurazione" class="form-control">
                                    
                                </select>
                            </div>

                           
                            <div class="form-group" style="margin-bottom:30px">
                                <h3>Assicurazione Desiderata</h3>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="checkboxTipoAssicurazionePrivato" value="private">
                                    <label class="form-check-label" for="checkboxTipoAssicurazionePrivato">Privato</label>
                                </div>
                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="checkboxTipoAssicurazioneTraffico" value="traffic">
                                    <label class="form-check-label" for="checkboxTipoAssicurazioneTraffico">Traffico</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <h3>Persona(e) da assicurare</h3>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="radio_single_family" id="radioSingle" value="single">
                                    <label class="form-check-label" for="inlineRadio1">Individuale</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="radio_single_family" id="radioFamily" value="family">
                                    <label class="form-check-label" for="inlineRadio2">Famiglia</label>
                                </div>
                            </div>  
                        
                            <div class="form-group">
                                <div class="col-sm-4">                                
                                </div>
                                <div class="col-sm-8" style="margin-top: 20px">
                                    <button id="btnCalcola" type="button" class="btn btn-primary pull-right nextBtn" style="min-width: 130px;"><?php echo $lang['CALCOLA']; ?></button>
                                </div>   
                            </div>
                    </form>
                </div>
            </div>
        
        <p id="SELEZIONA" style="display: none;"><?php echo $lang['SELEZIONA'];?></p>
        
        
        
        <!-- STEP 2 -->
        <div class="row setup-content"id="step-2">
           
                <div class="col-12">
                    <h3 class="control-label" id="titleTable"></h3>  
                </div> 

                <form id="table-form">
                    <div class="col-12">
                        <table 
                        class="table table-hover"
                        id="table"
                        data-toggle="table"
                        data-ajax="ajaxRequest"
                        data-sort-name="premium"
                        data-sort-order="asc"
                        data-unique-id="id"
                        data-id-field="id"
                        >
                        <thead>
                          <tr>
                            <th data-field="insurance_company" data-sortable="false">Assicurazione</th>
                            <th data-field="product_name" data-sortable="false">Prodotto</th>
                            <th data-field="copertura" data-sortable="false">Copertura</th>
                            <th data-field="risparmio" data-sortable="false" data-formatter = "priceFormatter">Risparmio</th>
                            <th data-field="premium" data-sortable="true">Premio</th>
                            <th data-field="id" data-formatter="buttonFormatter"></th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                </form> 
            
        </div>
        
        <!-- STEP 3 -->
        <div class="row setup-content" id="step-3">    
            <div class="col">
                <form id="dati-personali">
                    <div id="dati-contatto" class="panel">
                    <div class="panel-heading">
                        <div class='col-12'>
                            <h2 class="titolo-div">Richiedi subito un'offerta dettagliata</h2>
                            <h6>Riceverete un'offerta dettagliata gratuita e non vincolante con i premi per il 2023</h6>
                        </div>
                    </div>

                    <div class="panel-body">
                        <!-- Text input-->
                        <div class="form-group">
                          <label class="col-md-6 control-label" for="inizio">Inizio dell'assicurazione</label>  
                          <div class="col-md-6">
                              <input id="inizio" name="inizio" type="text" placeholder="gg/mm/aaa" class="form-control input-md validate[required]" data-validation-engine="validate[required]" required="">
                          </div>
                        </div>
                        
                        <hr>
                        
                        <div class="col">
                            <div class="form-row">
                               <div class="col-md-6 mb-3">
                                 <label for="nome">Nome</label>
                                 <input type="text" class="form-control validate[required]" id="nome" value="" data-validation-engine="validate[required]" required>

                               </div>
                               <div class="col-md-6 mb-3">
                                 <label for="cognome">Cognome</label>
                                 <input type="text" class="form-control" id="cognome" value="" required>
                                 <div id="cognome" class="invalid-feedback">
                                   Campo richiesto!
                                 </div>
                               </div>
                            </div>


                            <!-- Text input-->
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                   <label for="plz_anagrafica">PLZ</label>  
                                   <input id="plz_anagrafica" name="plz_anagrafica" type="text" class="form-control input-md" data-validation-engine="validate[required]" required="" >
                              </div>
                              <div class="col-md-6 mb-3">
                                    <label class="col-md-4" for="paese_anagrafica"><?php echo $lang['LUOGO']; ?></label>  
                                    <input id="paese_anagrafica" name="paese_anagrafica" type="text"  class="form-control input-md"   required="">
                                    <div id="paese_anagrafica" class="invalid-feedback">
                                        Campo richiesto!
                                    </div>
                              </div>

                            </div>


                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="tel">Telefono</label>  
                                    <input id="tel" name="tel" type="text" placeholder="" class="form-control input-md validate[required]" data-validation-engine="validate[required]">
                                </div>


                                <div class="col-md-6 mb-3">
                                    <label  for="email">E-mail</label>  
                                    <input id="email" name="email" type="text" placeholder="" class="form-control input-md validate[required]" data-validation-engine="validate[required,custom[email]]">
                                </div>
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
                         
                         
                         <div  class="form-group">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="checkboxTerminiCondizioni" value="private">
                                <label class="form-check-label" for="checkboxTerminiCondizioni">
                                <?php     
                                   echo $lang['informativa']; ?> 
                                    <a href='https://www.onezone.ch/datenschutz'> <b><?php echo $lang['termini e condizioni']  ?> </b></a>
                                      </label>
                            </div>
                         </div>

                       <div class="form-group" style="margin-top: 20px">
                           <div class="col-sm-4"></div>
                            <div class="col-sm-8">
                                 <button class="btn btn-primary" type="submit">INVIA</button>
                            </div>
                       </div>
                    </div>

                </div><!-- fine panel dati di contatto -->
                </form>
            </div>
        </div>
    </div>
</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      
    
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.js"></script>
    <script src="js/bootstrap-datepicker.js" type="text/javascript"></script>
    <!-- <script type="text/javascript" charset="utf-8" src="//cdn.datatables.net/1.10.10/js/jquery.dataTables.js"></script> -->
    <script src="js/validation-engine/languages/jquery.validationEngine-it.js" type="text/javascript"></script>
    <script src="js/validation-engine/jquery.validationEngine.js" type="text/javascript"></script>
   
    <script src="index_1.js" type="text/javascript"></script>

  </body>
</html>