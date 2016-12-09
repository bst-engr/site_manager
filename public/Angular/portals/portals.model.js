/**
 * Author: Basit Munir
 * Date Added: 28 Nov 2016
 * @return Deals with backend api to connect UI layer to server Layer
 */
angular.module('portalModel',['httpServiceModel']).factory('Portal', ['$http', 'httpService', function($http, httpService){
	
    var Portal = {
            formFields: {
                'site_name': '',
                'site_url': '',
                'fkCustomerID': '',
                'loginMessage': '',
                'signupMessage': '',
                'catPrefix': '',
                'catSuffix': '',  
                'site_logo': '',
                'loginButtonColor' : '',
                'configuratorColor': '',
                'customPartColor' : ''
            },
            errors: []

        };
    
    /**
     * [getPortals description]
     * @return {[type]} [description]
     */
    Portal.getPortals = function () {
       return $http.get(httpService.getUrl('portals'));
    };

    /**
     * [getPortalDetails description]
     * @param  {[type]} customer [description]
     * @return {[type]}          [description]
     */
    Portal.getPortalDetails = function (customer) {
        return $http.post(httpService.getUrl('portal/detail'), {customerId: customer});
    }

    /**
     * [getCustomers description]
     * @return {[type]} [description]
     */
    Portal.getCustomers = function () {
    	return $http.post(httpService.getUrl('portal/list'), {});
    }

    /**
     * [saveBasicSettings description]
     * @return {[type]} [description]
     */
    Portal.saveBasicSettings = function () {
        //Portal.formFields._token = httpService._token;
        console.log(Portal.formFields);
        return $http.post(httpService.getUrl('portal/save_settings'), Portal.formFields);
    };

    Portal.deleteRecord = function (id) {
        return $http.post(httpService.getUrl('portal/delete/'+id),{});
    };

    Portal.removeRow = function (object, find) {
        for(var i=0; i< object.length; i++) {
            if(object[i].id == find) {
                object.splice(i, 1);
            }
        }
        return object;
    }
    // build the api and return it
    return Portal;

}]);