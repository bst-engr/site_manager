/**
 * Author: Basit Munir
 * Date Added: 29 Nov 2016
 * @return {[type]} [All Action related to save/edit portal settings, coloe settings, and markup settings will be managed in this controller
 */
(function() {
    'use strict';
    /**
     * [app Defined module as patchables]
     */
    var app = angular.module('savePortalsApp',[
        'portalModel',
        'portalColorModel',
        'MarkupModel',
        'QuoteModel',
        'portalAliasModel',
        'pusherServiceModel',
        'companyModel',
        'httpServiceModel',
        'ngSanitize',
        'textAngular',
        'color.picker',
        'ui.bootstrap',
        'ngFileUpload',
        'xeditable'
    ]);
    app.config(function($provide) {
        $provide.decorator('ColorPickerOptions', function($delegate) {
            var options = angular.copy($delegate);
            options.round = false;
            options.alpha = false;
            options.format = 'hex';
            return options;
        });
    });
    //
    app.run(function(editableOptions) {
      editableOptions.theme = 'bs3'; // bootstrap3 theme. Can be also 'bs2', 'default'
    });
    
    /**
     * Initializes controller for patch cables module.
     */
    app.controller('savePortalController', [
        '$scope','$timeout','$http', '$window', '$interval','pusherService','Upload', 'httpService', 'Portal', 'Color', 'Alias', 'Company', 'Markup', 'Quote', savePortalController
    ]);
    
    function savePortalController(scope, $timeout, $http, $window, $interval, pusherService, Upload, httpService, Portal, Color, Alias, Company, Markup, Quote  ) {
        
        scope.state = {
                step: 1, 
                readOnly: false,
                basicSettingCheck: false,
                fkCustomerID: '',
                customers: [],
                propertiesToSave: ['baseForm', 'baseErrors', 'state','table_search', 'markupList']
            };
        //
        // scope.$apply(function() { 
        //    // every changes goes here
        //    $('#message').val(quoteForm.message); 
        // });
        //Checking if any notification is pending
        if(httpService.getAndResetStorage('pusherNotification')) {
            var data = httpService.getAndResetStorage('pusherNotification', true);
            scope.state.pusherNotification = data.pusherNotification;
        }

        //Restoration of page state
        if(httpService.getLocalStorage('portalState')) {
            var data = httpService.getLocalStorage('portalState');
            for (var i=0; i < scope.state.propertiesToSave.length; i++) {
                var prop = scope.state.propertiesToSave[i];
                if(prop == 'baseForm') {
                    Portal.formFields = data[prop]
                }
                scope[prop] = data[prop];
            }
        }
     
        scope.portal = Portal;
        scope.aliasList = Alias.AliasList;
        scope.aliasFormulaList=Alias.formulaDetails;
        // assigning base form fields to controller object to make fields accessaible throught the application.
        scope.baseForm = Portal.formFields;
        scope.baseErrors = Portal.errors;

        scope.quoteForm = Quote.formFields;
        scope.quoteErrors = Quote.errors;
        
        httpService._token = scope.state._token;
        scope.markupList = [];
        scope.templates = [
                    {value: 'admin', text: 'admin'},
                    {value: 're-seller', text: 're-seller'},
                    {value: 'sales-rep', text: 'sales-rep'}
                ];
        scope.attachCv= [
                    {value: 'yes', text: 'Yes'},
                    {value: 'no', text: 'No'}
                ];

        //App Initliazer
        getCompanies();
     //get current alias list
        getMarkupList(scope.state.fkCustomerID, ''); // get markup list for customer
        getCustomerQuote (scope.state.fkCustomerID); //get quote details
        // write ajax call to get session customer ID and then run customer portal

        if(scope.state.step == 2 || scope.state.step == 3)
        getAliasList(scope.state.fkCustomerID); 

        //customerPortal(5020);

        /***************************************************
        *************** Scope Functions ********************
        ***************************************************/
        /**
         * [refreshForm description]
         * @param  {[type]} url [description]
         * @return {[type]}     [description]
         */
        scope.refreshForm = function (url) {
          httpService.resetLocalStorage('portalState');// resetting local storage.
          window.location = url;
        }
        /**
         * [saveBasicSettings description]
         * @return {[type]} [description]
         */
        scope.saveBasicSettings = function () {
            if(scope.state.fkCustomerID != '') {
              scope.state.basicSettingCheck = false;
              Portal.formFields.fkCustomerID = scope.state.fkCustomerID;
              Portal.errors = scope.baseErrors = {};
              Portal.saveBasicSettings().then(
                  function (res) { //success
                      console.log(res);
                      if(typeof res.data === 'object') {
                          scope.baseErrors = res.data;
                          console.log(scope.baseErrors);
                      } else {
                          scope.state.pusherNotification = 'Basic Settings has been saved.';
                          Portal.formFields.id = res.data;
                          scope.state.step = 2;
                          httpService.setLocalStorage('portalState', scope, scope.state.propertiesToSave);
                          getAliasList(scope.state.fkCustomerID);
                          getCustomerQuote(scope.state.fkCustomerID);
                      }
                  },
                  function (err) { // error
                      console.log(err);
                  }
              );
            } else {
              scope.state.basicSettingCheck = 'Please Select customer to proceed.';
            }
        };

        /**
         * [saveAliasSettings description]
         * @return {[type]} [description]
         */
        scope.saveAliasSettings = function () {
            scope.state.pusherNotification = 'Alias and Part Formula Settings has been saved.';
           // Alias.saveAliasSettings(scope.state.fkCustomerID);
            scope.state.step = 3;
            httpService.setLocalStorage('portalState', scope, scope.state.propertiesToSave);
            Alias.saveAliasSettings(scope.state.fkCustomerID).then (
               
              function (response) {  
                
                scope.state.step = 3;
                httpService.setLocalStorage('portalState', scope, scope.state.propertiesToSave);
                scope.aliasFormulaList=response.data;
                Alias.formulaDetails=response.data;
               }

              );// then ends here 
        };

        /**
         * [saveQuoteSettings description]
         * @return {[type]} [description]
         */
        scope.saveQuoteSettings = function () {

            Quote.formFields.fkCustomerID = scope.state.fkCustomerID;
            Quote.errors = scope.quoteErrors = {};
            Quote.saveQuote().then(
                function (res) { //success
                    console.log(res);
                    if(typeof res.data === 'object') {
                        scope.quoteErrors = res.data;
                        console.log(scope.quoteErrors);
                    } else {
                        httpService.resetLocalStorage('portalState');// resetting local storage.
                        scope.state.pusherNotification = 'Congratulations! Customer '+scope.state.fkCustomerID+'\'s Portal is ready to Go. ';
                        httpService.setLocalStorage('pusherNotification', scope.state, ['pusherNotification']);
                        //alert("data has been saved");
                        window.location = httpService.getUrl('portal/settings');
                    }
                },
                function (err) { // error
                    console.log(err);
                }
            );
        }

        /**
         * [saveColorSettings description]
         * @return {[type]} [description]
         */
        scope.saveColorSettings = function () {
            Color.saveColorSettings();
        };

        /**
         * [customAutocomplete description]
         * @return {[type]} [description]
         */
        scope.customAutocomplete = function () {
            $( "#table_search" ).autocomplete({
                source: scope.state.customers,
                select: function( event, ui ) {
                    event.preventDefault();
                    httpService.resetLocalStorage('portalState');// resetting local storage.
                    scope.table_search = ui.item.label; //setting model name
                    scope.state.fkCustomerID = ui.item.value; //setting customer id
                    customerPortal(ui.item.value); //checking and fetching if customer exists
                   // getAliasList(ui.item.value); //request to fetch alias list for selected customer
                    getMarkupList(ui.item.value, scope.baseForm.site_url); //fetch markup list for selected customer
                    getCustomerQuote (ui.item.value); //get quote details
                }
            });
        };

        /**
         * [saveCurrentAlias description]
         * @param  {[type]} data [description]
         * @param  {[type]} row  [description]
         * @return {[type]}      [description]
         */
        scope.saveCurrentAlias = function (data, row,rowform) {
            //console.log(data);
            Alias.editAlias(row.aliasPart,row.aliasDescription,scope.state.fkCustomerID,Portal.formFields.site_name,data.aliasPart,data.aliasDescription,rowform).then( 
               
                function (response) { //success call back
                  
                   console.log(data);
                  scope.aliasList= Alias.updateAliasList(scope.aliasList,data);
                  rowform.$hide();

                }
            ); // then ends here 
        };

        /**
         * [getPreviousState function called on back button click event, it sets flag for previous screen and send requests to store current state]
         * @return {[type]} [description]
         */
        scope.getPreviousState = function () {
            scope.state.step = scope.state.step - 1;
            httpService.setLocalStorage('portalState', scope, scope.state.propertiesToSave);
        };

        /**
         * [uploadPic description]
         * @param  {[type]} file [description]
         * @return {[type]}      [description]
         */
        scope.uploadPic = function(file) {
            if(file) {
                file.upload = Upload.upload({
                  url: httpService.getUrl('portal/upload_logo'),
                  data: {file: file},
                });

                file.upload.then(function (response) {
                  $timeout(function () {
                    scope.baseForm.site_logo = response.data;
                    file.result = response.data;
                  });
                }, function (response) {
                  if (response.status > 0)
                    scope.errorMsg = response.status + ': ' + response.data;
                }, function (evt) {
                  // Math.min is to fix IE which reports 200% sometimes
                  file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
                });
            }
        }

        /**
         * [addMarkupRow description]
         */
        scope.addMarkupRow = function () {
            if(scope.state.fkCustomerID ) { // if customer has already been selected
              if(scope.markupList[scope.markupList.length-1].domain != '' ){ //if new row has already been added
                scope.state.markupConfError = false;
                scope.markupList.push(Markup.newRow);
              } else{ //if already clicked the add row button
                scope.state.markupConfError = "Please save last entry before adding another one."
              }
            }  else{ // if customer is not selected then just show a message
              scope.state.markupConfError = "Select a customer to proceed";
            }         
        };

        /**
         * [removeMarkup description]
         * @param  {[type]} index [description]
         * @param  {[type]} id    [description]
         * @return {[type]}       [description]
         */
        scope.removeMarkup = function(index, obj) {
          if(obj.id === null) { // if new row is being delete which never been saved in DB
            scope.state.markupConfError = false;
            scope.markupList= Markup.deleteMarkupList(scope.markupList, obj);
            return;            
          } else if(confirm("Are you sure to delete this entry?")) { // if entry exists in DB then confirm before deletion
            Markup.removeMarkup(obj).then(
              function ( res ){ //success callback
                scope.state.pusherNotification = "Markup Entry has been Removed for "+ obj.domain;
                scope.markupList= Markup.deleteMarkupList(scope.markupList, obj);
              },
              function ( err ) { //error call back
                console.log(err);
              }
            );
          }
        }
        /**
         * saveMarkup function used to save markup editing made on inline editing module
         * @param  {object} markupform form which is being edit
         * @param  {object} currentRow object of current row.
         * @return {[type]}            
         */
        scope.saveMarkup = function (markupform, currentRow) {
            Markup.formFields = markupform.$data; //assign form values to markup form property
            Markup.formFields.fkCustomerID = scope.state.fkCustomerID; 
            Markup.formFields.id= currentRow.id || null; //assigning row id to prepared form
            Markup.resetErrors(markupform);//resetting errors array;

            Markup.saveMarkupList().then( //save function called
                function (res) { //success
                    if(typeof res.data === 'object') { //if erros are returned then display it
                      Markup.setErrors(markupform, res.data);                      
                    } else {
                        if(currentRow.id != res.data ) { //if new entry has been saved then
                            Markup.formFields.id=res.data; //reassign empty property with new id
                            scope.markupList.splice(scope.markupList.length-1, 1); //remove empty row object from list
                            scope.markupList.push(Markup.formFields); //assigning new value to markup list
                        } else {
                            scope.markupList = Markup.updateMarkupList(scope.markupList, Markup.formFields); //call to update existing record
                        }
                        markupform.$hide(); //disable editing mode of xeditable.
                        //updating local storage for future reference
                        httpService.setLocalStorage('portalState', scope, scope.state.propertiesToSave); 
                    }
                },
                function (err) { // error
                    console.log(err);
                }
            );
        };

        /**
         * [reloadCustomer description]
         * @return {[type]} [description]
         */
        scope.reloadCustomer = function (id) {
          
          if(id) {
            httpService.resetLocalStorage('portalState');// resetting local storage.
            scope.state.fkCustomerID = id; //setting customer id
            customerPortal(id); //checking and fetching if customer exists
           // getAliasList(ui.item.value); //request to fetch alias list for selected customer
            scope.state.readOnly = true;
            getMarkupList(id, scope.baseForm.site_url); //fetch markup list for selected customer
            scope.table_search = scope.baseForm.site_name; //setting model name
          }
        };

        /**
         * Function Definations
         */
        function getCompanies (customer) {
            Company.getCompanies().then( 
                function (response) { //success call back
                  scope.state.customers = response.data;
                  console.log('customer received');
                }, 
                function (err) { //error call back
                  console.log(err);
                }
              );
        }

        /**
         * [setSession description]
         */
        function setSession () {
            Company.getCurrentSession().then( 
                function (response) { //success call back
                  //scope.state.fkCustomerID= response.data;
                  if(response.data!="NULL")
                    customerPortal(response.data);
                  console.log('customer session received');
                }, 
                function (err) { //error call back
                  console.log(err);
                }
              );
        }

        /**
         * [getAliasList description]
         * @param  {[type]} customer [description]
         * @return {[type]}          [description]
         */
        function getAliasList (customer) {
            var customer = customer || '';
            Alias.getDefaultAlias(customer, scope.baseForm.site_name).then (
                function (res) { //success
                    scope.aliasList = res.data;
                    getAliasFormula (customer);
                },
                function (err) { // error
                }
            );
        }

        function getAliasFormula (customer) {
            var customer = customer || '';
            Alias.getAliasFormula(customer).then (
                function (res) { //success
                  
                    console.log(res);
                    scope.aliasFormulaList= res.data;
                    Alias.formulaDetails=res.data;

                },
                function (err) { // error
                }
            );
        }

        /**
         * [customerPortal description]
         * @param  {[type]} customerId [description]
         * @return {[type]}            [description]
         */
        function customerPortal(customerId) {
            Portal.getPortalDetails(customerId).then(
                function (res) { //success
                    scope.baseForm = res.data;
                    Portal.formFields = res.data;
                },
                function (err) { //error
                    console.log(err);
                }
            );
        }

        /**
         * [getMarkupList description]
         * @param  {[type]} customerID [description]
         * @param  {[type]} site       [description]
         * @return {[type]}            [description]
         */
        function getMarkupList (customerID, site) {
            console.log(customerID+ site);
            Markup.getCustomerMarkups(customerID, site).then(
                function (res) { //success
                    console.log(res.data !== 'null');
                    if(res.data !== 'null') {
                        scope.markupList = res.data;
                    }
                },
                function (err) { //error
                    console.log(err);
                }
            );
        }

        /**
         * [getCustomerQuote description]
         * @return {[type]} [description]
         */
        function getCustomerQuote (customer) {
            Quote.getCustomerQuote(customer).then(
                function (res) { //success
                    console.log(res.data !== 'null');
                    if(res.data !== 'null') {
                        scope.quoteForm = res.data;
                        Quote.formFields = res.data;
                    }
                },
                function (err) { //error
                    console.log(err);
                }
            );
        }
        
    }   
})();
