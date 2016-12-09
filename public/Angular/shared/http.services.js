/**
 * Created by:  Muhammad Basit Munir
 * Date: 15 November 2016.
 * Description: 
 */
angular.module('httpServiceModel',[]).factory('httpService', ['$http', function($http){
	
    var service = {
        };
    /**
     * [getUrl returns a complete api url.]
     * @param  {[type]} url [description]
     * @return {[type]}     [description]
     */
    service.getUrl = function (url) {
        console.log('/index.php/'+url);
        return '/index.php/'+url;
    }
    /**
     * [setLocalStorage set localstorage item with given data]
     * @param {[string]} keyName          	[name of the local storage item key]
     * @param {[obj]} data             		[data from which it need to fetch store able data]
     * @param {[array]} propertiesToSave 	[properties of object to store to maintain state]
     */
    service.setLocalStorage = function (keyName, data, propertiesToSave) {
    	var data1 = service.extractAndSave(data, propertiesToSave);
    	console.log(data1);
    	localStorage.setItem(keyName, JSON.stringify(data1) );
    }

    /**
     * [getLocalStorage get data from localstorage and sends back to controller]
     * @param  {[type]} keyName [data to find against givenkey]
     * @return {[type]}         [json object from local storage.]
     */
    service.getLocalStorage = function (keyName) {
    	console.log(JSON.parse( localStorage.getItem(keyName) ));
        var data = JSON.parse( localStorage.getItem(keyName) );

        if(data != null && data.state.step == 1) {
            localStorage.removeItem(keyName);
        }

    	return JSON.parse( localStorage.getItem(keyName) );
    }

    /**
     * [getAndResetStorage description]
     * @param  {[type]} keyName [description]
     * @return {[type]}         [description]
     */
    service.getAndResetStorage = function (keyName, removeIt) {
        var removeIt = removeIt || false;
        var data = JSON.parse( localStorage.getItem(keyName) );
        console.log(data);
        if (removeIt) {
            localStorage.removeItem(keyName);
        }

        return data;
    }

    /**
     * [extractAndSave function extracs data from data variable again properties given in second param]
     * @param  {[obj]} data             [source data]
     * @param  {[Array]} propertiesToSave [properties to save]
     * @return {[type]}                  [description]
     */
    service.extractAndSave = function (data, propertiesToSave) {
    	var temp = {};
    	console.log("-----------------extractAndSave:------------------");
    	console.log(data[propertiesToSave[0]]);
    	console.log(propertiesToSave);
    	for (var i=0; i< propertiesToSave.length; i++) {
    		temp[propertiesToSave[i]] = data[propertiesToSave[i]];
    	}
    	return temp;
    }

    /**
     * [extractAndrestore function not in use right now]
     * @param  {[type]} data             [description]
     * @param  {[type]} propertiesToSave [description]
     * @return {[type]}                  [description]
     */
    service.extractAndrestore = function (data, propertiesToSave) {
    	var temp = {};
    	for (var i=0; i< propertiesToSave.length; i++) {
    		temp.propertiesToSave[i] = data.propertiesToSave[i];
    	}
    	return temp;
    }

    /**
     * [resetLocalStorage delete local storage item]
     * @param  {string} keyName item to remove from local storage.
     * @return {void}         void
     */
    service.resetLocalStorage = function (keyName) {
        localStorage.removeItem(keyName);
    }
    // build the api and return it
    return service;

}]);