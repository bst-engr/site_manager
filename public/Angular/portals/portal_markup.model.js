/**
 * Author: Basit Munir
 * Date Added: 5 Dec 2016
 * @ Deals with backend api to connect UI layer to server Layer for markup listing at basic settings.
 */
angular.module('MarkupModel',['httpServiceModel']).factory('Markup', ['$http', 'httpService', function($http, httpService){
	
    var Markup = {
            formFields: {
                'domain': '',
                'catMarkup': '',
                'mtpMarkup': '',
                'fibermarkup': '',
                'domainLevel': '',
                'attachCsvFlag': '',
                'costColunmName': '',
                'id': null
            },
            newRow: {
                        'domain': '',
                        'catMarkup': '',
                        'mtpMarkup': '',
                        'fibermarkup': '',
                        'domainLevel': '',
                        'attachCsvFlag': '',
                        'costColunmName': '',
                        'id': null
                    }
        };
    /**
     * [saveMarkupList description]
     * @return {[type]} [description]
     */
    Markup.saveMarkupList = function() {
    	return $http.post(httpService.getUrl('markups/save'), Markup.formFields);
    }

    /**
     * [getCustomerMarkups description]
     * @param  {[type]} customer [description]
     * @param  {[type]} site     [description]
     * @return {[type]}          [description]
     */
    Markup.getCustomerMarkups = function (customer, site) {
        return $http.post(httpService.getUrl('markups'), { 'customer': customer, site: site});
    }

    /**
     * [resetErrors description]
     * @param  {[type]} form [description]
     * @return {[type]}      [description]
     */
    Markup.resetErrors = function(form) {
        angular.forEach(Markup.formFields, function(value, key) {
            form.$setError(key, '');
        });
    }

    /**
     * [setErrors description]
     * @param {[type]} form   [description]
     * @param {[type]} errors [description]
     */
    Markup.setErrors = function (form, errors) {
        angular.forEach(errors, function(value, key) {
            form.$setError(key, value[0]);
          });
    }

    Markup.removeMarkup = function (row) {
        return $http.post(httpService.getUrl('markups/remove'), row);
    }
    /**
     * [updateMarkupList description]
     * @param  {[type]} list [description]
     * @param  {[type]} obj  [description]
     * @return {[type]}      [description]
     */
    Markup.updateMarkupList = function (list, obj) {
        for(var i = 0; i< list.length; i++ ) {
            if(list[i].id == obj.id ) {
                list[i] = obj;
            }
        }
        return list;
    }   
    /**
     * [deleteMarkupList description]
     * @param  {[type]} list [description]
     * @param  {[type]} obj  [description]
     * @return {[type]}      [description]
     */
    Markup.deleteMarkupList = function (list, obj) {
        for(var i = 0; i< list.length; i++ ) {
            if(list[i].id == obj.id ) {
                list.splice(i, 1); //remove empty row object from list
            }
        }
        return list;
    }
    
    // build the api and return it
    return Markup;

}]);