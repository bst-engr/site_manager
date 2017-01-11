/**
 * Author: Basit Munir
 * Date Added: 29 Nov 2016
 * @return Deals with backend api to connect UI layer to server Layer for color settings
 */
angular.module('portalAliasModel',['httpServiceModel']).factory('Alias', ['$http', 'httpService', function($http, httpService){
	
    var Alias = {
            AliasList: [],
            formFields: {},
            lastPart:'',
            lastDescription:'',
            formulaDetails:[]
        };
    
    Alias.saveAliasSettings = function(customer) {
    	console.log(Alias.formFields);
       Alias.formulaDetails.fkCustomerID=customer;
       // alert(Alias.formulaDetails.fiberPartString);
         var customer = '/getFomula/saveAliaseFormula';
         return $http.post(httpService.getUrl('aliases'+ customer),Alias.formulaDetails);
    }

    Alias.getAliasBaseUrl = function(url) {
        return httpService.getUrl(url);
    }

    Alias.getDefaultAlias = function (customer,name) {
        var customer = '/'+customer || '';
        return $http.post(httpService.getUrl('aliases'+ customer), {siteName:name});
    }

    Alias.editAlias = function (lp,ld,dbrefPart,customerID,siteName,part,description,rowform) {
        
        /*

        if(Alias.lastPart!='')
        lp=Alias.lastPart;
        
        if(Alias.lastDescription!='')
        ld=Alias.lastDescription;
        
        Alias.lastPart=part;
        Alias.description=description;
        */

        var customer = '/edit/editAliases';
        return $http.post(httpService.getUrl('aliases'+ customer), {lastPart:lp,lastDescription:ld,fkCustomerID:customerID,site:siteName,aliasPart:part,aliasDescription:description,dbref:dbrefPart});
       
    }



    Alias.getAliasFormula = function (customerID) {
        

        var customer = '/getFomula/getAliasFormula';
        return $http.post(httpService.getUrl('aliases'+ customer), {fkCustomerID:customerID});
       
    }
    

    Alias.updateAliasList = function (list, obj) {
        
        for(var i = 0; i< list.length; i++ ) {
            if(list[i].dbRef == obj.dbRef && list[i].fieldTable == obj.fieldTable) {
                list[i] = obj;
            }
        }
        return list;
        
    }
    // build the api and return it
    return Alias;

}]);