/**
 * Created by:  Muhammad Basit Munir
 * Date: 21 November 2016.
 * Description: 
 */
angular.module('companyModel',['httpServiceModel']).factory('Company', ['$http','httpService', function($http, httpService){
	/**
	 * [Markup functions used to initialize variables]
	 */
    var Company = function() {
    	
    };

    Company.getCompanies = function () {
    	return $http.post(httpService.getUrl('customers/load_customers'), {});
    }

     Company.getCurrentSession = function () {
        return $http.post(httpService.getUrl('customers/customer_session'), {});
    }
   
    // build the api and return it
    return Company;

}]);