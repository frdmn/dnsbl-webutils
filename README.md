dnsbl-monitor
=============

Web based DNSBL blacklist monitor for your mail servers.

## Requirements

* Web server (Nginx/Apache)
* PHP (tested with 5.5)

## Installation

1. Clone this repository to your document root
1. Point your browser to that document root
1. Copy and rename the default config to `config.php`

## Development

In case you want to help and contribute to the project you need to compile the assets with the assistence of Grunt:

1. Make sure you've installed `node` and `npm`
1. Install Grunt, Bower and Linter and code checker:  
  `npm install -g grunt-cli bower jshint jscs`
1. Install all dependencies:  
  `npm install`
1. Install web libraries:  
  `bower install`
1. Run grunt task to compile assets and start watching for local file changes:  
  `grunt dev`

If you want to commit your changes, exclude the `dev` argument.

Caution: When using the `dev` argument, Grunt won't minify your JS or CSS, so it's easier to debug. Once you run `grunt` (without the `dev`), the files are minified!

## Version

1.0.0
