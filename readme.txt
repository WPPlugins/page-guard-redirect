=== Page Guard Redirect ===
Contributors: Frank Culross
Donate link: https://gitlab.com/fculross/wp-plugins/wikis/Donate
Tags: redirect, url, query string, url parameters, urlparam, url params, url param, paypal, frank culross
Requires at least: 4.7
Tested up to: 4.7
Stable tag: trunk
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Adds a short code which allows page redirection based on the value of a token passed as a URL parameter or POST variable

== Description ==

Page Guard Redirect uses a single URL parameter or POST variable as a means of providing a token to guard access to any page on which this plugin's shortcode is placed - redirection can be made to occur when the token fails to match what is expected (the alternative, i.e. redirect when token DOES match - is also included for completeness.)

The shortcode to use is 'pgredirect' - its attributes are:

	tokenparam (required): a string value containing the name of the token URL param - e.g. 'mytoken'
	tokenvalue (required): a string value containing the expected value of the tokenparam - e.g. 'x34ggj45b'
	redirectURL (required): a string value containing the URL to redirect to (you can use an existing page as the target for the redirection - alternatively, for many configurations, setting this to a non existent page will make WordPress redirect to the default 404 "not found" page.)
	redirectWhen (optional): -> when = "1", redirects when match is found, otherwise defaults to redirect on non-match

Syntax examples:

	  redirect on non match (default) -
		[pgredirect tokenparam="mytoken" tokenvalue="1234abcd" redirecturl="http://my.redirurl.com/notfound" /]

	  redirect on match (add redirectwhen="1" as an attribute) -
		[pgredirect tokenparam="mytoken" tokenvalue="1234abcd" redirectwhen="1" redirecturl="http://my.redirurl.com/notfound" /]

== Installation ==

1. To install the plugin, download the zip file and upload via the plugin interface of your WordPress site or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress

== Usage ==

A typical use scenario might be to prevent access to a downloads page. Suppose you have a PayPal "Buy Now" button on your site which allows visitors to make a payment for say, an eBook or audio recording. When setting up the button in your PayPal account you specify a URL on your site to which the visitor is returned after they've made payment. On this return page you've added a link the visitor can use to download their purchase - however, you don't want any non paying visitors to find the return page by chance! 

Add a parameter to the end of the return URL (using any name and value you want) when you set up your button in PayPal e.g. 

	"http://your.wordpress.site/download/?dltoken=Xc345Fd77"
	
Next, add a pgredirect short code to your return page in WordPress -

	[pgredirect tokenparam="dltoken" tokenvalue="Xc345Fd77" redirecturl="http://your.wordpress.site/notfound" /]
	
This will cause a redirect if Page Guard Redirect detects either the lack of the expected token in the URL parameter, or a value which doesn't match the one in the short code's tokenvalue attribute.

== Frequently Asked Questions ==

= Can I use any name for my URL token parameter =

Yes you can! You might like to use somewhat obfuscated token names as well as values in order to further minimise the possibility of a visitor finding your protected page purely by chance e.g. 

	"http://your.wordpress.site/download/?cck4634kep=spefe4639"

== Changelog ==

= 1.0 =
First implementation