/**
 * Author: Basit Munir
 * Date Added: 29 Nov 2016
 * @return Deals with backend api to connect UI layer to server Layer for color settings
 */
angular.module('portalColorModel',['httpServiceModel']).factory('Color', ['$http', 'httpService', function($http, httpService){
	
    var Color = {
            formFields: {
                'id' : '',
                'loginButtonColor' : '',
                'signupButtonColor' : '',
                'configuratorColor' : '',
                'customPartColor' : '',
                'fkSiteId' : ''
            }
        };
    
    Color.saveColorSettings = function () {
    	console.log(Color.formFields);
    }

    /**
     * [getPortalColor description]
     * @param  {[type]} customer [description]
     * @return {[type]}          [description]
     */
    Color.getPortalColor = function (customer) {
        return $http.post(httpService.getUrl('colors'), { 'customer': customer});
    }
    
    // build the api and return it
    return Color;

}]);