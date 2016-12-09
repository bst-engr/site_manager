(function() {
    'use strict';
    /**
     * [app Defined module as patchables]
     */
    var app = angular.module('authApp',[
        'authModel',
        'pusherServiceModel',
        'ngSanitize',
        'ui.bootstrap',
    ]);
    //
    app.config(function($interpolateProvider){
        $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
    });
    /**
     * Initializes controller for patch cables module.
     */
    app.controller('authController', [
        '$scope','$http', '$window', '$interval','pusherService', 'Auth', authController
    ]);
    
    function authController(scope, $http, $window, $interval, pusherService, Auth) {
        
        scope.state ={};
        scope.auth = Auth;
        
    }
})();
