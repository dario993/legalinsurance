/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var plzPrecedente = 0;
var stepPrecedente = '';
var lang = [];
var currenCurrency="";
var stato = true;
var table;
var dataTable;


var formStatus = {
    flagError : "false",
    act: '',
    lang : 'it',
    inputNascita : '',
    idSelectAssicurazione : '', 
    textSelectAssicurazione : '',
    isPrivato : 'true',
    isTraffico : 'false',
    isSingleFamily : 'single',
    idSelezionato : '',
    inizioAssicurazione : '',
    nome : '',
    cognome : '',
    plz : '',
    paese: '',
    telefono : '',
    email : '',
    linguaOfferta: '',
    note: ''
};


var formdata;

$(function (){
    //$('.selectpicker').selectpicker();
    //$('.datepicker').datepicker();
    //$('[data-toggle="popover"]').popover(); 
    
    initEventi();
    setLang();
    
      
    
    
     
});


$(document).ready(function(e){
    
    formStatus.lang = $('#lang').val();
    
    var navListItems = $('div.setup-panel div a'),
          allWells = $('.setup-content'),
          allNextBtn = $('.nextBtn');
    allWells.hide();
    
    
    get = parseGetVars();   
    if (get.length>0){
        //inserire valori da barra degli indirzzi
    }
    

    navListItems.click(function (e) {
      e.preventDefault();
      var $target = $($(this).attr('href')),
              $item = $(this);

      if (!$item.hasClass('disabled')) {
          if($target.attr("id") === 'step-1'){
              $('div.setup-panel div a:eq(1)').addClass('disabled');
              $('div.setup-panel div a:eq(2)').addClass('disabled');
          }
          else if($target.attr("id") === 'step-2' && stepPrecedente === 'step-3' ){
              $('div.setup-panel div a:eq(2)').addClass('disabled');
          }
          navListItems.removeClass('btn-primary').addClass('btn-default');
          $item.addClass('btn-primary');
          allWells.hide();
          $target.show();
          $target.find('input:eq(0)').focus();
          stepPrecedente = $target.attr("id");
      }
      
    });
    
    allNextBtn.click(function(e){
        var curStep = $(this).closest(".setup-content"),
          curStepBtn = curStep.attr("id"),
          nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
          curInputs = curStep.find("input[type='text'],input[type='url']"),
          isValid = true; 
          
          
        if (isValid)
          nextStepWizard.removeClass('disabled').trigger('click');
    });
    
    

    $('div.setup-panel div a.btn-primary').trigger('click');
     
});





function fillSelect(){
    
}

  
     

function scrollTo(item){
        $('html, body').animate({
            scrollTop: item.offset().top
        }, 1000);
    }


function resetErrors() {
    $('form input, form select').removeClass('inputTxtError');
    $('label.error').remove();
}

function initEventi(){
    refreshListSelectAssicurazione();
    
    //$("#formInsurance").validationEngine();
     
    
    $('#btnCalcola').on('click', function(e){
        e.preventDefault();
        
        var isValid = formStatus.flagError;
        if(!isValid){
            return;
        }
         
        //getTableRisparmio();
         $('#table').bootstrapTable('refresh');
        return false;
    });
    
    
    $('#inputNascita').change(function(){
        formStatus.inputNascita =  $('#inputNascita').val();
    });

    
    $('#selectAssicurazione').change(function (){
        formStatus.idSelectAssicurazione = jQuery('#selectAssicurazione option:selected').val(); 
       formStatus.textSelectAssicurazione = jQuery('#selectAssicurazione option:selected').text();
    });
    
    
    $('#checkboxTipoAssicurazionePrivato').change(function (){
        formStatus.isPrivato = $(this).prop('checked'); // check if the radio is checked
    });
     
    $('#checkboxTipoAssicurazioneTraffico').change(function (){
        formStatus.isTraffico = $(this).prop('checked'); // check if the radio is checked
    });

    $('[name=radio_single_family]').change(function (){
        formStatus.isSingleFamily = $('[name=radio_single_family]:checked').val(); // check if the radio is checked
     });
     
      var $table = $('#table');
     var $button = $('#button');

    $(function() {
      $button.click(function () {
        $table.bootstrapTable('refresh');
      });
    });
  
    $('#table-form').submit(function (e){
        e.preventDefault();
        var id = e.originalEvent.submitter.value;
        console.log("id: "+id);
        formStatus.idSelezionato = id;
        
    });
    
    $('#dati-personali').submit(function (e){
        e.preventDefault();
         //if invalid do nothing
         if(!$("#dati-personali").validationEngine('validate')){
            console.log("campi mancanti");
            return false;
          }
          
          console.log("ok form completo");
          
          formStatus.inizioAssicurazione = jQuery('#inizio').val();
          formStatus.nome = jQuery('#nome').val();
          formStatus.cognome = jQuery('#cognome').val();
          formStatus.plz = jQuery('#plz_anagrafica').val();
          formStatus.paese = jQuery('#paese_anagrafica').val();
          formStatus.telefono = jQuery('#tel').val();
          formStatus.email = jQuery('#email').val();
          formStatus.linguaOfferta = jQuery('#selectLingua').val();
          formStatus.note = jQuery('#comunicazione').val();
          
          inviaMail();
           
    });
    
    
     $(document).on('click', '.nextBtn', function(e){
          var curStep = $(document).closest(".setup-content"),
          curStepBtn = 'step-2',
          nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
          curInputs = curStep.find("input[type='text'],input[type='url']"),
          isValid = true;
          
          $('#step-3').html(); 
          $('[data-toggle="popover"]').popover(); 
      

      if (isValid)
          nextStepWizard.removeClass('disabled').trigger('click');
    });
    
}



function inviaMail(){
    console.log(formStatus);
    
    formStatus.act = "getSelectDataById";
    
    jQuery.ajax({
        type: "POST",
        data: formStatus,
        url:  "php/api.php",
        datatype: 'json',
        success: function (json) {
            console.log(json);
    },
        error: function (er) {
            console.log(er);
        }
    });
}



function getTableRisparmio(){
    formStatus.act = "getTableRisparmio";
    
    
    $.ajax({
        url: "php/api.php",
        type: "post",
        data: formStatus,
        datatype: 'json',
        success: function(json){              
           console.log(json);
           if(json.error_code === 0){
               showTableRisparmio(json);
           } 
            
        },
        error: function(e){
            console.log(e.responseText);
        }             
    });
    
    
}



function ajaxRequest(params) {
    
    formStatus.act = "getTableRisparmio";
    
    $.ajax({
        type: "POST",
        data: formStatus,
        url: "php/api.php",
        datatype: 'json',
        success: function (json) {
            console.log(json);
            var datatable = json.table;
    
            var data=[];
            

            for(var i=0; i< datatable.length; i++){

                if(json.old_premio !== "undefined"){
                    $risparmio = parseFloat( json.old_premio - datatable[i].premium).toFixed(2);
                }

                data.push({
                    'insurance_company' : datatable[i].insurance_company,
                    'product_name' : datatable[i].product_name,
                    'copertura' : datatable[i].domestic_guarantee,
                    'risparmio' : $risparmio,
                    'premium' : 'CHF ' + datatable[i].premium,
                    'id': datatable[i].id
                });

            }
            params.success({
                "rows": data,
                "total": data.length
            },null,{});
        },
        error: function (er) {
            params.error(er);
        }
    });
}


function priceFormatter(value){
    var color = '#3f92da';
    
    if (value < 0){
      color = '#ef403d !important';
    }
    
    
    return '<div style="color: ' + color + '">'+
      value + '</div>';
        
}


function buttonFormatter(value){
    var button='<button id="id-'+value+'" value='+value+' type="subtim" class="btn-offerta btn btn-outline-warning nextBtn" >Offerta</button>';
    
    return button;
}


function showTableRisparmio(json){
    
   // var table = $('#table');
    
    var datatable = json.table;
    
    var data=[];
    
    //svuoto tabella
   // table.empty();
    
    for(var i=0; i< datatable.length; i++){
        
        data.push({
            'insurance_company' : datatable[i].insurance_company,
            'product_name' : datatable[i].product_name,
            'premium' : 'CHF ' + datatable[i].premium
        });
        
    }
    
    $('#table').bootstrapTable('refresh', {data : data});
    
}


function nextBtn(){
    var curStep = $(this).closest(".setup-content"),
          curStepBtn = curStep.attr("id"),
          nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
          curInputs = curStep.find("input[type='text'],input[type='url']"),
          isValid = true;

      

    if (isValid)
          nextStepWizard.removeClass('disabled').trigger('click');
}

  
 


 //new function
 function refreshListSelectAssicurazione(){            
    formStatus.act = "getListAssicurazioni";
    var lista;
    $.ajax({
        url: "php/api.php",
        type: "post",
        data: formStatus,
        datatype: 'json',
        success: function(json){              
           
           console.log(json);
           lista = json.listAssicurazioni;
           
           setListOptionsItemsKeyValue($('#selectAssicurazione'), lista);
        },
        error: function(e){
            console.log(e.responseText);
        }             
    }); 

}


function ricalcolaAnno(annoPrecedente, anno) {
    if (anno === annoPrecedente) {
            return false;
    }
    if (anno.length !== 4) {
            return false;
    }
return true;
}

  

function  setListOptionsItems(select, array){
    var listitems = '<option value=-1>' +  lang.SELEZIONA + '</option>';
    //clear the current content of the select 
    //iterate over the data and append a select option
    if(array.length >100){
        return;
    }
    $.each(array, function(key, val){
                listitems += '<option value=' + val + '>' + val + '</option>';                    
    });
    select.html(listitems);
    select.selectpicker('refresh');
    select.selectpicker('deselectAll');        
    select.selectpicker('refresh');
return;
}

function  setListOptionsItemsKeyValue(select, array){
    select.removeAttr('disabled');
    var listitems = '<option data-hidden=true>' + lang.SELEZIONA + '</option>';
    //clear the current content of the select 
    //iterate over the data and append a select option
    if(array.length > 100){
        return;
    }
    $.each(array, function(key, val){
        if(select.val() == val.id){
            listitems += '<option selected value=' + val.id + '>' + val.value + '</option>'; 
        }
        else{
            listitems += '<option value=' + val.id + '>' + val.value + '</option>'; 
        }
    });
    select.html(listitems);
    select.selectpicker('refresh');
    select.selectpicker('deselectAll');        
    select.selectpicker('refresh');
return;
}

function disableSelect(select){
    var listitems = '<option value=-1>' + lang.NESSUN_MODELLO_DISPONIBILE + '</option>';
    select.html(listitems);
    select.prop('disabled', 'disabled');
    select.selectpicker('refresh');
}


function setLang(){
    //lang['NESSUN_MODELLO_DISPONIBILE'] =  $('#NESSUN_MODELLO_DISPONIBILE').text();
    lang['SELEZIONA'] =  $('#SELEZIONA').text();

    
}


function checkUndefinedRow(row,  i, _premio){
    var premio = '-';
    if(typeof row[i][_premio] === "undefined"){
                premio = '-';
            }
            else{
                premio = row[i][_premio];
            }
    return premio;
}

function displayTable(json){
    //if(!checkError(json)) return;
    //if(!checkError(json))return;
    if(json.risparmio == 'true'){
        $('#errorLabelRisparmio').hide();
        $('#divtableSenzaRisparmio').hide();
        $('#divtableConRisparmio').show();
        table = $('#tableConRisparmio').DataTable( {
                destroy: true,
                searching: false,
                pageLength: -1,
                data: json.table,
                order: [ 4, 'desc' ],
                columns: [
                    { data: 'nome' },
                    { data: 'it' },
                    { data: 'premio' },
                    { data: 'anno'},
                    { data: 'risparmio'},
                    { data: 'button' }
                ]                
            });
    }
    else{
        if(formStatus.premio_cassa_attuale != -1){
            $('#errorLabelRisparmio').show();
        }
        $('#divtableSenzaRisparmio').show();
        $('#divtableConRisparmio').hide();
        table = $('#tableSenzaRisparmio').DataTable( {
                destroy: true,
                searching: false,
                pageLength: -1,
                data: json.table,
                order: [ 2, 'asc' ],
                columns: [
                    { data: 'nome' },
                    { data: 'it' },
                    { data: 'premio' },
                    { data: 'anno' },
                    { data: 'button' }
                ]                
            });

    }
}

function checkError(json){
    
    if(jQuery.isEmptyObject(json.error)){
       return ; 
    }
    
    var stato = json.error.stato;
    var view = json.error.view;
    
    if(stato === 'undefined' || stato == null){
        return ;
    }
    
      
    if(stato == 40){
        setError( $('#divPlz'), $('#errorLabelPLZ'), view);              
    }
    if(stato == 45){
        setError( $('#divPlz'), $('#errorLabelPaese'), view);
    }
    if(stato == 51){
        setError( $('#div-anno-nascita1'), $('#errorLabelAnno1'), view);
    }
    if(stato == 52){
        setError( $('#div-anno-nascita2'), $('#errorLabelAnno2'), view);
    }
    if(stato == 53){
        setError( $('#div-anno-nascita3'), $('#errorLabelAnno3'), view);
    }
    if(stato == 54){
        setError( $('#div-anno-nascita4'), $('#errorLabelAnno4'), view);
    }
    
    if(stato == 55){
        setError( $('#divAnnoDiNascita'), $('#errorLabelFrachigia'), view);
    }
    if(stato == 70){
        setError( $('#divModelli'), $('#errorLabelModelli'), view);
    }
    
    
    formStatus.flagError = true;
    return ;
}

function hideError(){
    setError( $('#divPlz'), $('#errorLabelPLZ'), false);
    setError( $('#divPlz'), $('#errorLabelPaese'), false);
    setError( $('#div-anno-nascita1'), $('#errorLabelAnno1'), false);
    setError( $('#div-anno-nascita2'), $('#errorLabelAnno2'), false);
    setError( $('#div-anno-nascita3'), $('#errorLabelAnno3'), false);
    setError( $('#div-anno-nascita4'), $('#errorLabelAnno4'), false);
    setError( $('#divAnnoDiNascita'), $('#errorLabelFrachigia'), false);
    setError( $('#divModelli'), $('#errorLabelModelli'), false);
    $('#errorLabelRisparmio').hide();
}

function setError(divInput, divLabel,  stato){
    if(stato==true){
        divInput.addClass('has-error');
        divLabel.show();    
    }         
    else{
        divInput.removeClass('has-error');
        divLabel.hide(); 
    }
}


function showMessageConf( options ){

    $("#confirm_form_message").remove();
    
    var html ="<div class=\"modal\" id=\"confirm_form_message\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"\" aria-hidden=\"true\" >\
        <div class=\"modal-dialog\">\
          <div class=\"modal-content\">\
            <div class=\"modal-header\">\
              <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>\
              <h4 class=\"modal-title\" >"+options.title+"</h4>\
            </div>\
            <div class=\"modal-body\">\
              <p>"+options.message+"</p>\
            </div>\
            <div class=\"modal-footer\">\
                  <a href=\"#\" id=\"confirm_form_message_confirm\" class=\"btn danger\">"+options.confirm+"</a>\
            </div>\
          </div>\
        </div>\
        </div>";
    $('body').append($(html));
    $('#confirm_form_message').modal('show');
    $('#confirm_form_message_confirm').click(function(e) {
        e.preventDefault();
        options.callback();
        $('#confirm_form_message').modal('hide');
        setTimeout(function(){$('#confirm_form_message').remove();},500);
    });	
}


function showMessage(title,text, overlap) {
    var n = new Date().getTime(); 
    var html = "<div id=\"myModal_"+n+"\" class=\"modal fade \" >\
                    <div class=\"modal-dialog\" role=\"document\">\
                        <div class=\"modal-content\">\
                            <div class=\"modal-header\">\
                                <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>\
                                <h4 class=\"modal-title\">"+title+"</h4>\
                            </div>\
                            <div class=\"modal-body\">"+text+"\
                            </div>\
                            <div class=\"modal-footer\">\
                                <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Chiudi</button>\
                            </div>\
                        </div>\
                    </div>\
                </div>";
    var divAlert = $(html);
    $('body').append(divAlert);
    if (overlap) {
        overlapBootstrapDialogModalBackdrop('#myModal_' + n);
    }
    $('#myModal_'+n).modal({show: true});    
    return '#myModal_'+n;
}

function overlapBootstrapDialogModalBackdrop(bootstrapDialogSelector) {
    var previousZIndex = "";    
    $(bootstrapDialogSelector).on('show', function() {
        // Il setTimeout serve perchè il backdrop del dialog non è ancora stato inserito nel DOM.
        setTimeout(function() {
            var $lastBackdrop = $('.modal-backdrop.fade.in').last();
            previousZIndex = $lastBackdrop.css('z-index');
            $lastBackdrop.css('z-index', 9999);
            $(bootstrapDialogSelector).insertAfter($lastBackdrop);
        }, 0);
    });
    $(bootstrapDialogSelector).on('hidden', function() {
    //    var $lastBackdrop = $('.modal-backdrop.fade.in').last();
    //    $lastBackdrop.css('z-index', previousZIndex);
    });
}


function getFormData($form){
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};
    
    $.map(unindexed_array, function(n, i){
        indexed_array[n['name']] = n['value'];
    });
    
    

    return indexed_array;
}


function parseGetVars() {
  // creo una array
  var args = new Array("uno");
  // individuo la query (cioè tutto quello che sta a destra del ?)
  // per farlo uso il metodo substring della proprietà search
  // dell'oggetto location
  var query = window.location.search.substring(1);
  // se c'è una querystring procedo alla sua analisi
  if (query)
  {
        // divido la querystring in blocchi sulla base del carattere &
        // (il carattere & è usato per concatenare i diversi parametri della URL)
        var strList = query.split('&');
        // faccio un ciclo per leggere i blocchi individuati nella querystring
        for(str in strList)
        {
          // divido ogni blocco mediante il simbolo uguale
          // (uguale è usato per l'assegnazione del valore)
          var parts = strList[str].split('=');
          // inserisco nella array args l'accoppiata nome = valore di ciascun
          // parametro presente nella querystring
          args[unescape(parts[0])] = unescape(parts[1]);
        }
  }
  return args;
}
