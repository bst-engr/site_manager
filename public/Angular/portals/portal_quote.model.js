/**
 * Author: Basit Munir
 * Date Added: 5 Dec 2016
 * @ Deals with backend api to connect UI layer to server Layer for Quote listing at basic settings.
 */
angular.module('QuoteModel',['httpServiceModel']).factory('Quote', ['$http', 'httpService', function($http, httpService){
	
    var Quote = {
            formFields: {
                'headerEmail': '',
                'phone': '',
                'message': '',
                'terms': '',
                'quoteNumberPrefix': '',
                'footerLeft': '',
                'footerMiddle': '',
                'fkCustomerID': '',
                'customPartColor': '',
                'adminCcEmail':'',
                'smtpHost': '',
                'smtpPort': '',
                'smtpUser': '',
                'smtpPassword': '',
                'mailFrom': '',
                'fromName': '',
                'noReplyEmail': '',
                'costColumnAlias':'',
                'id': null
            },
            errors: []
        };
    /**
     * [saveQuoteList description]
     * @return {[type]} [description]
     */
    Quote.saveQuote = function() {
    	return $http.post(httpService.getUrl('quotes/save'), Quote.formFields);
    }

    /**
     * [getCustomerQuotes description]
     * @param  {[type]} customer [description]
     * @param  {[type]} site     [description]
     * @return {[type]}          [description]
     */
    Quote.getCustomerQuote = function (customer) {
        return $http.post(httpService.getUrl('quotes'), { 'customer': customer});
    }
    
    // build the api and return it
    return Quote;

}]);