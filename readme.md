
__Author Note__
Firstly, this suited my needs. I tried to take steps to make this nicely usable by others but if you have a complex API requirement just use SLIM Framework and dont bother with my 'wrapper' you'll have more control and a better API. Also, this destorys most of the hard work Josh has done with coding standards and PHP 5 lovelyness, I make no use of his middleware functionality or any of his in built hooks so if you need them you'll again likely be better off with plain old SLIM. 

This is still in development and has not been throughly tested so please, please, PLEASE do not drop this into production and expect to be fine. Test the shit out of it and read the code I've written, make sure you understand the implications of my methods. Also, if you spot me being a dofus anywhere or something just plain vomit inducing (which is likely.) let me know.

# SLIM MVC
SlimMVC is a Model-View-Controller wrapper for [SLIM API Framework](http://www.slimframework.com/). SlimMVC allows you to define
controllers for your API routes, those routes then pass through a view before being returned
to the browser.

## Features
- Support for GET, POST, PUT and DELETE
- Controllers
- HTTP Basic Auth
- API Keys
- Auto Documentation
- Events
- Credits
- Logging
- Rate limiting


## Controllers
Controllers extend Controller with the class name being the name you wish to be used for your url. For example a class called User would be accessed form the url by appending `/user/`. You must extend the parent controller in order to preserve the before_controller event if you could care less then leave it out or call it statically from the Events class as detailed below. A controller in its most basic form looks like this.

```PHP
class User extends Controller {
	public function __construct(){ parent::__construct(); }
	public function index_get(){ return "Hello, get user"; }

}
```	

Will be triggerd for `user/index` (also for just `user` as index is the default controller) as controller and method in the url for a GET request.

```PHP
class User extends Controller {
	public function __construct(){ parent::__construct(); }
	public function index_post(){ return "Hello, post user"; }

}
```	

Will be triggerd for `user/index` as controller and method in the url with a POST request. You can have diffrent verbs within the same class.

```PHP
class User extends Controller {
	public function __construct(){ parent::__construct(); }
	public function index_post(){ return "Hello, post user"; }
	public function index_get(){ return "Hello, get user"; }

}
```	
	
If you wish to use the same verb for a whole class you can and then you can drop the requirement to append the verb to your methods.

```PHP
class User extends Controller {
	
	var $verb = "get";
	public function __construct(){ parent::__construct(); }
	public function index(){ return "Hello, get user"; }
	public function another(){ return "Hello, from other get user"; }

}
```	
	
Now SlimMVC will automatically afix the verb to the function names in the background.

If you wish to pass arguments to your get requests you can and then you use the url and collect them in your controller by accepting an argument in your constructor

```PHP
class User extends Controller {
	
	var $user_idx;
	public function __construct($args){ $this->user_idx = $args[0] }
	public function show_get{ return "Showing info for the user ".$this->user_idx; }

}
```

so `/user/show/1` would return "Showing info for the user 1"

Note: Expect this process to change to accept coupling from the URL and to pass the arguments as an on associated object like we do with a JSON body. So URLs would look like /user/show/user_idx/1/other_var/other_value

You can also pass a json object in the body of your request (for all but GET request) this will be pass to your controller in the contructer as a PHP object, so for a POST body such as

```JSON
{
	"user_idx":"12"
}
```

From your controller you can so something like the following

```PHP
class User extends Controller {
	
	var $user_idx;
	public function __construct($args = null){ if($args){ $this->user_idx = $args->user_idx; } }
	public function show_post{ return "Showing info for the user ".$this->user_idx; }

}
```

and also obviously you could combine the two

```PHP
class User extends Controller {
	
	var $user_idx;
	public function __construct($args = null){ 
		if(is_object($args)){ 
			$this->user_idx = $args->user_idx; 
		} else {
			$this->user_idx = $args[0];
		}
	}
	
	public function show_get{ return "Showing info for the user ".$this->user_idx; }
	public function show_post{ $this->show_get(); }

}
```

Request bodies that do not convert to objects via json_decode are passed as the first key of an array to the controller.

Controllers can also set a http code to return. add a code variable to your controller and set it to the value you wish to send. So the code below, will send a 500 error and a message if they give us no user_idx and if the user_idx is less than 11.

```PHP
class User extends Controller {

    var $user_idx;
    var $code;
	var $verb = "get";
	
    public function __construct($args = array()){ 
		if(count($args) < 1){ 
			return $this->error();
		} else { 
			$this->user_idx = $args[0];  
		}
	}

    public function show(){ 
        if($this->user_idx < 11){ 
            return $this->error();
        } else { 
            return "Showing info for the user ".$this->user_idx; 
        }
	}

    public function error(){
        $this->code = 500;
        return array("error" => "Sorry, there was an error processing your request.");
    }
}
```	

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

### API Keys
SlimMVC contains support for API keys, if enabled from the Keys config. You can also set the model you wish to use for validation, the model can also be set to an array of values to validate against. If enabled the key will the first paramter in the url

    /my_key/controller/method


### HTTP Basic Auth
If http_auth is enabled the user is required to send a authorization header with a base64 encoded string of username:password you can set the model you wish to use to validate these values from within the Http config file. An example might be `user:password` which would be sent from the client like so

    Authorization: Basic dXNlcjpwYXNzd29yZA==
	
It is possible to use both http auth and a key.

## Errors
This is a general note on errors, the tempation might be to send actual 404 pages or maybe error breakdowns but my feeling is this should be avoided so a 'global' way to run to errors hasn't really be included to instead encourage you to use actual returns to pass meaningful errors from your controllers to your end users. The system will 404 on a missing controller or method and will 403 on a access validation by default sending ONLY the http codes which I think is cleanest, you controllers can run to 404 by returning false but a much nicer way might be to return say a json response `{error: 'Sorry, you did not include a user id.'}` or some such.

<table>
  <tr>
    <th>HTTP Code</th><th>Meaning</th>
  </tr>
  <tr>
    <td><strong>200</strong></td><td>Everything Okay.</td>
  </tr>
  <tr>
    <td><strong>404</strong></td><td>The controller or method could not be found.</td>
  </tr>
  <tr>
    <td><strong>403</strong></td><td>Auth failed.</td>
  </tr>
  <tr>
    <td><strong>400</strong></td><td>Badly formatted request.</td>
  </tr>
</table>

Controllers can also control the http_code they wish to send, as explained above. Events are explained above. 

## Events
SlimMVC contains extensive Event support, which is provided by an edited version of Eric Barnes' [CodeIgniter-Events](https://github.com/ericbarnes/CodeIgniter-Events) to make the code as extenable as possible, instead of
having to edit core functionality you can attach functions to the system events. Events are simple to add, make a file in the Events folder

```PHP
    class Auth_events {
		public function failed(){ mail("sysadmin@localhost",'Failed Auth', "Somebody just failed auth on your api."); }
	}
	
	Events::register('auth_failed', array('Auth_events', 'failed'));
```

Then an email would be sent everytime somebody failed the http auth.

### first_event
This is the very first event fired by the system, before 'events' are event included so it should only be used to add events from your 'MY' core files.

### after_includes
This event is fired right after the system finishes its includes, its handy to add files/folders to the system.

### before_auth
This event is fired before http_basic auth is attempted.

### auth_failed
This event is fired if http_basic auth fails, before the page is sent to 404.

### after_auth
This event is fired if after auth has finnished, if we got here auth was also a success.

### before_controller
This event is fired on the construction of a parent controller.

### after_controller
This event is fired after our controlle has finished and is the last event the system calls before sending our response.

## Config
All files in Config are automatically passed to $system->config so you can accees then by reference. `$system->config->get("config_key/reference_key");`

## Auto Document
SlimMVC can be used to build basic auto documentation for your API, all you need to do it comment the start of your controllers.

```PHP
    /* Auto Document
     *
     * @path: controller_name
     * @description: something about your controller here.
     * @verbs: get, post
     * @arguments: does it accept arguments? 'yes' or 'no'
    */
```
	
and then add an additional comment block below to describe each method.

```PHP
    /* @method: hello
     * @verb: get
     * @description: returns "Hello, world" for posts requests
	 * @arguments: string $text, int $number // This row can be ommited of @arguments is set to 'no' above.
    */
```

`Notes: @path must be on the third line of the comment block. @method but be on the on the first line of the comment block. Each method must have its own comment block. Comment blocks must appear at the start of the controller.`

To build the documentation just run build.php inside the Docs folder and documentation will be generated into that folder.

## ToDo
- Write a generic db model with mysqli
- Add system 'log' files.
- Add a hardcoded 'log' check and table for api requests.
- Add a credits validation model (will require keys to be enabled)
- Add some advanced acl tied to keys maybe some scaffolding to restrict controller access on the fly. 
- Write a my_keys model to read a db table for keys.
- Make all 'core' classes 'psudo extend' system ($system->controller = new controller) like CI does.
- Consider methods for 'streaming' data
- Finish auto document.
