**Please Note: This is an indevelopment project you shouldn't try and use it yet.**

# SLIM MVC
SlimMVC is a Model-View-Controller wrapper for SLIM Framework. SlimMVC allows you to define
controllers for your API routes, those routes then pass through a view before being returned
to the browser.

## Controllers
Controllers extend Controller with the class name being the name you wish for your URI. You must extend the parent controller in order to preserve the before_controller event if you could care less then leave it out or call it statically from the Events class.
```PHP
    class Say extends Controller {
		public function __construct(){ parent::__construct(); }
		public function index_get(){ return "Hello, world"; }
	
	}
```	
Will be triggerd for "say/index" as controller and method in the url with a GET request. 

    class Say extends Controller {
		public function __construct(){ parent::__construct(); }
		public function index_post(){ return "Hello, world"; }
	
	}

Will be triggerd for "say/index" as controller and method in the url with a POST request. You can have diffrent verbs within the same class.

    class Say extends Controller {
		public function __construct(){ parent::__construct(); }
		public function index_post(){ return "Hello, post"; }
		public function index_get(){ return "Hello, get"; }
	
	}
	
If you wish to use the same verb for a whole class you can.

    class Say extends Controller {
		
		var $verb = "get";
		public function __construct(){ parent::__construct(); }
		public function index(){ return "Hello, get"; }
		public function another(){ return "Hello, from another get"; }
	
	}
	
Now SlimMVC will automatically afix the verb to the function names in the background.

## Views
Views are the 'output formats' of your API, currently they are API wide but I plan to give controllers the power to overwrite a view. To add a view simply create a class that is prefixed with View_ and the the name for your view such as "View_json" all views need the method display() which will receive a variable of content.

	Class View_json {
		public function display($data){
			return json_encode($data);
		}
	}
	
You can also send headers for the view by setting an array called headers with the key the name of the header and its value as the value you require.

	Class View_json {
	
		var $headers = array("Content-type" => "text/json");
		
		public function display($data){
			return json_encode($data);
		}
	
	}

	
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
### before_request
### after_request
### before_model
### after_model
### before_auth
### after_auth

## Auth
SlimMVC has some support for auth and access control. It also supports rate limiting.

### API Keys
SlimMVC contains support for API keys, call limits and key levels.

### Generic Auth'
SlimMVC user/password htauth.

## Logging
SlimMVC supports full logging (logging must be enabled for rate limiting to work) 
