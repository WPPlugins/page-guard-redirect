<?php
/*
Plugin Name: Page Guard Redirect
Plugin URI: https://gitlab.com/fculross/wp-plugins/wikis/home
Description: Adds short code to allow redirection based on value of a token passed as a 
URL parameter or POST variable
Version: 1.0
Author: Frank Culross
Author URI: https://gitlab.com/fculross/wp-plugins/wikis/About-the-Developer
*/

/* 
Page Guard Redirect (Wordpress Plugin)
Copyright (C) 2017 Frank Culross

    Uses either a URL parameter or POST variable as a means of providing a token to guard access to 
    the page on which the plugin's shortcode is placed. Redirection can be made to occur when the token 
    fails to match what is expected (e.g. to prevent access to say, a downloads page where the user has
    not first visited e.g. PayPal to make payment.) The alternative (redirect when token DOES match) 
    is also included for completeness.

    The shortcode to use is 'pgredirect' - its attributes are:

    tokenparam (required) -> a string value containing the name of the token URL param - e.g. 'mytoken'
    tokenvalue (required) -> a string value containing the expected value of the tokenparam - e.g. 'x34ggj45b'
    redirectURL (required) -> a string value containing the URL of the page to redirect to (in most WP setups,
    pointing this to a non-existent page makes wordPress redirect to the template's default 404 "not found" page)
	redirectWhen (optional) -> when = "1", redirect when match is found, otherwise defaults to redirect on non-match
 
    Examples:
    
      redirect on non match (default - doesn't need redirectwhen attribute) -
        [pgredirect tokenparam="mytoken" tokenvalue="1234abcd" 
			redirecturl="http://my.redirurl.com/notfound" /]
 
      redirect on match (add redirectwhen="1" as an attribute) -
        [pgredirect tokenparam="mytoken" tokenvalue="1234abcd" redirectwhen="1" 
            redirecturl="http://my.redirurl.com/notfound" /]
 */

// use output buffering to prevebt the "headers already sent" error when redirecting 
ob_start();
ob_clean();

//tell wordpress to register the shortcode - params are tag, function
add_shortcode("pgredirect", "pgredirect");

function pgredirect ($atts){
    $a = shortcode_atts(array(
        'tokenparam'    => '',
        'tokenvalue'   => '',
        'redirecturl'  => '',
		'redirectwhen' => false,
    ), $atts);
    
	// get the name of the url param used as a token
	$tokenParam = $a['tokenparam'];
	
	// check its value and redirect if needed
	if(isset($_REQUEST[$tokenParam])){
		if($a['redirectwhen']){
		   // redirect when token param value matches - less obvious uses but is
		   // here for the sake of completeness 
		   if ($_REQUEST[$tokenParam] == $a['tokenvalue']){
				wp_redirect($a['redirecturl']);
				exit;
		   } 
		} else { 
			// redirect when token param does not match - most likely use to say,
			// prevent hacker gaining direct access to a (paid) downloads page
			if ($_REQUEST[$tokenParam] != $a['tokenvalue']){
				wp_redirect($a['redirecturl']);
				exit;
		   }
		}
	} 
	else {
		// redirect when $tokenParam is missing from url parameters
		wp_redirect($a['redirecturl']);
		exit;
	}	
		
	// default return
    return '';
}