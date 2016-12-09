/**
 * Author: Basit Munir
 * Date Added: 28 Nov 2016
 * @return {[type]} [All Action related to portal settings, listing and other operations rquests holded here
 */
(function() {
    'use strict';
    /**
     * [app Defined module as patchables]
     */
    var app = angular.module('portalsApp',[
        'portalModel',
        'MarkupModel',
        'QuoteModel',
        'pusherServiceModel',
        'httpServiceModel',
        'ngSanitize',
        'ui.bootstrap',
    ]);
    
    /**
     * Initializes controller for patch cables module.
     */
    app.controller('portalsController', [
        '$scope','$http', '$window', '$interval','pusherService','httpService', 'Portal', 'Markup', 'Quote', portalsController
    ]);
    
    function portalsController(scope, $http, $window, $interval, pusherService, httpService, Portal, Markup, Quote) {
        
        scope.state ={
                step:1,
                customerEdit: true,
                fkCustomerID:'',
                pusherNotification:false, 
                propertiesToSave: ['baseForm', 'baseErrors', 'state','table_search', 'markupList']
        };
        scope.portal = Portal;
        scope.customers;
        scope.contactForm;
        scope.$watch('scope.customers',function(){
            console.log('scope.customers: changed');
            Portal.customers = scope.customers;
        },true);
        
        
        /**********Initializes Pusher**************/
        pusherSubscription();
        /*****************/
        //fetching out contact list;
         LoadCustomersList();

        /**
         * [deletePortal description]
         * @return {[type]} [description]
         */
        scope.deletePortal = function (id) {
            Portal.deleteRecord(id).then(
                function (res) { //success
                    scope.customers = Portal.removeRow(scope.customers, id);
                },
                function (err) { // error callback

                }
            )
        }
         /**
          * Scope Functions
          */
        scope.editCustomer = function (id) {
            httpService.resetLocalStorage('portalState');// resetting local storage.
            scope.state.fkCustomerID = id; //setting customer id
            window.location= httpService.getUrl('portal/edit/setting/'+id);
            //call to prepare all customer settings to view on edit screen
            /*Portal.getPortalDetails(id).then(
                function (res) { //success
                    scope.baseForm = res.data;
                    scope.baseErrors = {};
                    Portal.formFields = res.data;
                    //preparing markup list.
                    Markup.getCustomerMarkups(id, scope.baseForm.site_url).then(
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
                    //preparing quote Settings
                    Quote.getCustomerQuote(id).then(
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
                    //search criteria
                    scope.table_search = scope.baseForm.site_name; //setting model name
                    //setting localstorage to use on edit screen
                    httpService.setLocalStorage('portalState', scope, scope.state.propertiesToSave);
                    window.location= httpService.getUrl('portal/settings/'+id);
                },
                function (err) { //error
                    console.log(err);
                }
            );*/
        }
        //definition functions
        function LoadCustomersList() {
            Portal.getCustomers().then(
                function(response){
                    console.log("ok response received");
                    scope.customers = response.data;
                },
                function(response){
                    console.log('there is something wrong please review');
                    return {};
                }

            );
        }

        function pusherSubscription() {
            var pusher = pusherService.initlizePusherObject();

            var channel = pusher.subscribe('site_manager');
            
            channel.bind('pusher:subscription_succeeded', function(){
                console.log('subscription completed');
            });

            channel.bind('settings', function(data) {
                scope.state.pusherNotification = true;
                scope.state.pusherNotification = data.text;
                console.log(data);
            });
        }
    }
})();
