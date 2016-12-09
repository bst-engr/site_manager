/**
 * Created by:  Muhammad Basit Munir
 * Date: 15 November 2016.
 * Description: 
 */
angular.module('pusherServiceModel',['pusher-angular']).factory('pusherService', ['$http','$pusher', function($http, $pusher){
	
    var pusher = {
    		API_KEY: 'a92b74efb851f57211cc'        
        };

    pusher.initlizePusherObject = function() {
    	console.log(pusher.API_KEY);
        var client =  new Pusher(pusher.API_KEY);
        var pusherObj = $pusher(client);
        return pusherObj;
    }
    
    
    // build the api and return it
    return pusher;

}]);