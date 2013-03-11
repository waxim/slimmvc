# SLIM MVC
SlimMVC is a Model-View-Controller wrapper for SLIM Framework. SlimMVC allows you to define
controllers for your API routes, those routes then pass through a view before being returned
to the browser, this allows for many format types on return.

Note: the ' suffux is for things yet to do.

## Database'
SlimMVC only requires a DB layer if auth and logging are used. Out of the box it supports mongo and sql

## Events
SlimMVC contains extensive Event support to make the code as extenable as possible, instead of
having to edit core functionality you can attach functions to the system events. 

## Auth'
SlimMVC has some support for auth and access control. It also supports rate limiting.

### API Keys'
SlimMVC contains support for API keys, call limits and key levels.

### Oauth'
SlimMVC supports the oauth protocol.

### Generic Auth'
SlimMVC user/password htauth.

## Logging'
SlimMVC supports full logging (logging must be enabled for rate limiting to work) 
