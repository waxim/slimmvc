# SLIM MVC
SlimMVC is a Model-View-Controller wrapper for SLIM Framework. SlimMVC allows you to define
controllers for your API routes, those routes then pass through a view before being returned
to the browser.

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
