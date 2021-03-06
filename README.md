dnsbl-webutils
==============

[![Current tag](http://img.shields.io/github/tag/frdmn/dnsbl-webutils.svg)](https://github.com/frdmn/dnsbl-webutils/tags) [![Repository issues](http://issuestats.com/github/frdmn/dnsbl-webutils/badge/issue)](http://issuestats.com/github/frdmn/dnsbl-webutils) [![Flattr this repository](http://api.flattr.com/button/flattr-badge-large.png)](https://flattr.com/submit/auto?user_id=frdmn&url=https://github.com/frdmn/dnsbl-webutils)

![](http://up.frd.mn/aBIZ5.png)

Web based and self hosted DNSBL (or RBL) utilities:

* __Check__: Web based real time check against quite a few (233 at this time) DNSBLs
* __API__: In case you need a JSON response, use the API.

This can be used as free alternative to [MXtoolbox](http://mxtoolbox.com/blacklists.aspx)'s monitor.

### Requirements

* Web server (Nginx/Apache)
* PHP (tested with 5.5)
* Bower, Grunt, JSHint, JSCS (in case you build from master)

### Installation

##### Stable official release

1. Click on [GitHub releases](https://github.com/frdmn/dnsbl-webutils/releases).
1. Download the latest version.
1. Copy and rename the default config to `config.php`:
  `cp config.example.php config.php`
1. Set your web servers document root to "public/"!
1. Install PHP components using Composer:  
  `composer install` 

##### Development git master branch

1. Make sure you've installed `node` and `npm`
1. Clone this repository:  
  `https://github.com/frdmn/dnsbl-webutils.git`
1. Open cloned repository:  
  `cd dnsbl-webutils`
1. Install requirements and dependencies:  
  `npm install -g grunt-cli bower jshint jscs`  
  `npm install`
1. Download web libraries:  
  `bower install`
1. Install PHP components:  
  `composer install` 
1. Compile assets:  
  `grunt dev` or `grunt`

Caution: When using the `dev` argument, Grunt won't minify your JS or CSS, so it's easier to debug. Once you run `grunt` (without the `dev`), the files are minified!

### Pretty URLs / rewrites

The project contains a `.htaccess` file in case you run Apache with enabled `AllowOverride`. You can use the following rewrite directive for your server block configuration in case you run Nginx:

```
location / {
   try_files $uri $uri/ /index.php?$args;
}
```
  
### Version

1.3.0

## License

[MIT](LICENSE)
