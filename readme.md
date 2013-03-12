# SLIM MVC
SlimMVC is a Model-View-Controller wrapper for SLIM Framework. SlimMVC allows you to define
controllers for your API routes, those routes then pass through a view before being returned
to the browser.

## Controllers
Controllers extend Controller with the class name being the name you wish for your URI. Methods should be suffixed with the verb they should be avliable to, if you wish a function to run for more than one verb you will have to add a utility to your class (see below.) If a class has a $verb variable it will treat the whole controller with that variable and you will not need a verb suffix on method names. 

    class Say extends Controller {
	
		public function index_get(){ return "Hello, world"; }
	
	}
	
Will be triggerd for "say/index" as controller and method in the url with a GET request. 

    class Say extends Controller {
	
		public function index_post(){ return "Hello, world"; }
	
	}

Will be triggerd for "say/index" as controller and method in the url with a POST request. You can have diffrent verbs within the same class.

    class Say extends Controller {
	
		public function index_post(){ return "Hello, post"; }
		public function index_get(){ return "Hello, get"; }
	
	}
	
If you wish to use the same verb for a whole class you can.

    class Say extends Controller {
		
		var $verb = "get";
		public function index(){ return "Hello, get"; }
	
	}
	
Now SlimMVC will automatically afix the verb to the function names in the background.

	
## Database
SlimMVC only requires a DB layer if auth and logging are used. Out of the box it supports sql.

## Events
SlimMVC contains extensive Event support to make the code as extenable as possible, instead of
having to edit core functionality you can attach functions to the system events. 

### first_event
This is the very first event fired by the system, before 'events' are event included so it should only be used to add events from your 'MY' core files.

### after_includes
This event is fired right after the system finishes its includes, its handy to add files/folders to the system.

### before_controller
### after_controller
### before_model
### after_model
### before_auth
### after_auth
### before_get_request
### after_get_request
### before_post_request
### after_post_request
### before_put_request
### after_put_request
### before_delete_request
### after_delete_request

## Auth
SlimMVC has some support for auth and access control. It also supports rate limiting.

### API Keys
SlimMVC contains support for API keys, call limits and key levels.

### Generic Auth'
SlimMVC user/password htauth.

## Logging
SlimMVC supports full logging (logging must be enabled for rate limiting to work) 
