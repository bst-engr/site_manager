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
            if(confirm("Are you sure to delete this portal?")) {
                $('section.content').showLoader();
                Portal.deleteRecord(id).then(
                    function (res) { //success
                        $('section.content').hideLoader();
                        scope.customers = Portal.removeRow(scope.customers, id);
                    },
                    function (err) { // error callback
                        $('section.content').hideLoader();
                    }
                )
            }
        }
         /**
          * Scope Functions
          */
        scope.editCustomer = function (id) {
            httpService.resetLocalStorage('portalState');// resetting local storage.
            scope.state.fkCustomerID = id; //setting customer id
            window.location= httpService.getUrl('portal/edit/setting/'+id);
        }
        //definition functions
        function LoadCustomersList() {
            $('section.content').showLoader();
            Portal.getCustomers().then(
                function(response){
                    $('section.content').hideLoader();
                    console.log("ok response received");
                    scope.customers = response.data;
                },
                function(response){
                    $('section.content').hideLoader();
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
                if( data.reLoadCustomer == 'yes' ) {
                    LoadCustomersList();
                }
                console.log(data);
            });
        }
    }
})();
