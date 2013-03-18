**Please Note: This is an indevelopment project you shouldn't try and use it yet. There is nothing in the way of sanitaion and its hacky. Consider this your warning. :) **

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

```PHP
class Say extends Controller {
	public function __construct(){ parent::__construct(); }
	public function index_post(){ return "Hello, world"; }

}
```	

Will be triggerd for "say/index" as controller and method in the url with a POST request. You can have diffrent verbs within the same class.

```PHP
class Say extends Controller {
	public function __construct(){ parent::__construct(); }
	public function index_post(){ return "Hello, post"; }
	public function index_get(){ return "Hello, get"; }

}
```	
	
If you wish to use the same verb for a whole class you can.

```PHP
class Say extends Controller {
	
	var $verb = "get";
	public function __construct(){ parent::__construct(); }
	public function index(){ return "Hello, get"; }
	public function another(){ return "Hello, from another get"; }

}
```	
	
Now SlimMVC will automatically afix the verb to the function names in the background.

If you wish to pass arguments to your get requests you can use the url and collect them in your controller by accepting an argument in your constructor

```PHP
class User extends Controller {
	
	var $user_idx;
	public function __construct($args){ $this->user_idx = $args[0] }
	public function show_get{ return "Showing info for the user ".$this->user_idx; }

}
```

so /user/show/1 would return "Showing info for the user 1"

if you wish your controller to 404 (say if they forget to give you a user idx) simple set a return value of "false"

## Views
Views are the 'output formats' of your API, currently they are API wide but I plan to give controllers the power to overwrite a view. To add a view simply create a class that is prefixed with View_ and the the name for your view such as "View_json" all views need the method display() which will receive a variable of content.

```PHP
Class View_json {
	public function display($data){
		return json_encode($data);
	}
}
```	
	
You can also send headers for the view by setting an array called headers with the key the name of the header and its value as the value you require.

```PHP
Class View_json {

	var $headers = array("Content-type" => "text/json");
	
	public function display($data){
		return json_encode($data);
	}

}
```	

## Auth
SlimMVC has some support for auth and access control. It also supports rate limiting.

### API Keys
SlimMVC contains support for API keys, if enabled from the Keys config. You can also set the model you wish to use for validation, the model can also be set to an array of values to validate against. If enabled the key will the first paramter in the url

    /my_key/controller/method


### HTTP Basic Auth
If http_auth is enabled the user is required to send a authorization header with a base64 encoded string of username:password you can set the model you wish to use to validate these values from within the Http config file. An example might be Aladdin:open sesame which would be sent from the client like so

    Authorization: Basic QWxhZGRpbjpvcGVuIHNlc2FtZQ==
	
It is possible to use both http auth and a key, as keys are used for 'crediting' this can be useful. 

## Database
SlimMVC has its own db utility class, slimmvc can function without a db but for the more complex logging and auth options its reccomended. You can use the db utilities by enabling db in the Db config file. 

### Queries

### Results 

## Logging
SlimMVC supports full logging (logging must be enabled for rate limiting to work) 

## Errors
This is a general note on errors, the tempation might be to send actual 404 pages or maybe error breakdowns but my feeling is this should be avoided so a 'global' way to run to errors hasn't really be included to instead encourage the you to use actual returns to pass meaningful errors from your controllers to your end users. The system will 404 on a missing controller or method and will 403 on a access validation by default sending ONLY the http codes which I think is cleanest, you controllers can run to 404 by returning false but a much nicer way might be to return say a json response "{error: 'Sorry, you did not include a user id.'}" or some much.

I may well add the option to add an error class from which you can handle the routes to errors yourself, likely using http codes on an error view. 

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

## ToDo
- Write a generic db model with mysqli
- Add system 'log' files.
- Add a hardcoded 'log' check and table for api requests.
- Add a credits system.
- Add some advanced acl tied to keys maybe some scaffolding to restrict controller access on the fly. 
- Write a my_keys model to read a db table for keys.
- Make all 'core' classes 'psudo extend' system ($system->controller = new controller) like CI does.
- Consider methods for 'streaming' data
- add a config function to sanitize all the assoc array calls. no more $config['http_auth']['enabled'] -> $system->config("http_auth/enabled"); 
