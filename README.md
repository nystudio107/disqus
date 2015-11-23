### Disqus plugin for Craft CMS

A simple plugin for integrating [Disqus](https://disqus.com) into [Craft CMS](http://buildwithcraft.com) websites, including Single Sign On (SSO) and custom login/logout URLs.

**Installation**

1. Unzip file and place `disqus` directory into your `craft/plugins` directory
2.  -OR- do a `git clone https://github.com/khalwat/disqus.git` directly into your `craft/plugins` folder.  You can then update it with `git pull`
3. Install plugin in the Craft Control Panel under Settings > Plugins

###Configuring Disqus###

First, make sure you have [set up a Disqus account](https://disqus.com/websites/).

Next in the Craft Admin CP, go to Settings->Plugins->Disqus and enter the Short Name for your Disqus site.  This is the only required setting for the Disqus plugin.

#### Single Sign On (SSO) ####

The real usefulness of the Disqus plugin is that it takes care of the Single Sign On (SSO) integration with your Craft site.

Before you can use this, you'll need to set up the Disqus SSO API as described on the [Integrating Single Sign-On](https://help.disqus.com/customer/portal/articles/236206-integrating-single-sign-on) web page.

Then copy and paste the API Key and API Secret into the Disqus plugin settings, and turn on the "User Single Sign On" lightswitch.

#### Custom Login/Logout URLs ####

The Diqus plugin will also take care of the custom login/logout URLs, should you wish to use them.  Please see [Adding your own SSO login and logout links](https://help.disqus.com/customer/portal/articles/236206-integrating-single-sign-on#sso-login) for details.

You only need this is you want to have a custom login button displayed in the Disqus UI itself.  

`url` should be the address of your login page. The page will be opened in a new window and it must close itself after authentication is done. That is how we know when it is done and reload the page.

`logout` should be set to `http://example.com/actions/disqus/logoutRedirect` to hit the Disqus controller that handles the logout and redirect.

###Using the Disqus plugin in your templates ###

Both of these methods accomplish the same thing:

	{# Output the Disqus embed code using the 'disqusEmbed' function #}
    {{ disqusEmbed( DISQUS_IDENTIFIER, DISQUS_TITLE, DISQUS_URL, DISQUS_CATEGORY_ID) }}
    
	{# Output the Disqus embed code using the 'disqusEmbed' filter #}
    {{ DISQUS_IDENTIFIER | disqusEmbed(DISQUS_TITLE, DISQUS_URL, DISQUS_CATEGORY_ID) }}

All of the parameters except for `DISQUS_IDENTIFIER` are optional.  For more information on what these parameters are, please see [Javascript configuration variables](https://help.disqus.com/customer/portal/articles/472098-javascript-configuration-variables)

In its most basic case, this will result in output to your Craft template that looks like this:

	<div id="disqus_thread"></div>
	<script type="text/javascript">
	    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
	    var disqus_shortname = 'DISQUS_SHORTNAME';
	    var disqus_identifier = 'DISQUS_IDENTIFIER';
	    var disqus_title = 'DISQUS_TITLE';
	    var disqus_url = 'DISQUS_URL';
	    var disqus_category_id = 'DISQUS_CATEGORY_ID';
	    
	    /* * * DON'T EDIT BELOW THIS LINE * * */
	    (function() {
	        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
	        dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
	
	        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
	    })();
	</script>
	
	<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
	<a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>

The `DISQUS_SHORTNAME` setting is taken from the Admin CP settings, and the rest of the `DISQUS_*` settings are passed in as variables from the `disqusEmbed` Twig filter/function.

If you have turned on "User Single Sign On" it will also output something like this prior to the above tag:

	<script type="text/javascript">
	var disqus_config = function() {
	    this.page.remote_auth_s3 = "eyJpZCI6IjEiLCJ1c2VybmFtZSI6IkFkbWluIiwiZW1haWwiOiJhbmRyZXdAbWVnYWxvbWFuaWFjLmNvbSJ9 c0e4b8f2eca3c0e995cdd64ba2dedd720820ab5b 1431214361";
	    this.page.api_key = "GTX1r1JBbiJah3hzZkBO06hI71VxjyWxgdurckHYBWLiELkHDidVmnDkBW0XeROe";
	};
	</script>
	
Which, assuming you've set up the Disqus SSO properly, will allow your Craft users to be logged into Disqus using your Craft website credentials.

If you have "Use Custom Login/Logout URLs" turned on, it will also generate the `this.sso` settings for you, [as described here](https://help.disqus.com/customer/portal/articles/236206-integrating-single-sign-on#sso-login)

## Changelog

### 1.0.1 -- 2015.11.23

* Added support for Craft 2.5 new plugin features
* Added a controller to handle the custom logout URL

### 1.0.0 -- 2015.05.09

* Initial release
