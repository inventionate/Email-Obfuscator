Email Obfuscator
=====================

A text filter for automatic email obfuscation using the well-established Javascript and a CSS fallback:

- For Javascript-enabled browsers: ROT13 ciphering
- For non-Javascript browsers: CSS reversed text direction

## Contents

- [Installation & usage](#installation--usage)
	- [Common installation step](#common-installation-step)
	- [Additional platform specific steps](#additional-platform-specific-steps)
		- [Standalone](#standalone)
		- [Laravel 5](#laravel-5)
		- [Twig](#twig)
	- [Your platform not listed here?](#your-platform-not-listed-here-aka-go-go-community)
- [Credits](#credits)

## Installation & usage

### Common installation step

Add the library to `composer.json`:

```json
"require": {
    "propaganistas/email-obfuscator": "~1.0",
}

```

And finally include the supplied Javascript file (`assets/EmailObfuscator.js`) somewhere in your template. Publish the file yourself or use the following CDN link (no uptime guaranteed):

    https://cdn.rawgit.com/Propaganistas/Email-Obfuscator/master/assets/EmailObfuscator.js

### Additional Platform specific steps

- [Standalone](#standalone)
- [Laravel 5](#laravel)
- [Twig](#twig)

#### Standalone

Include the `src/Obfuscator.php` file somewhere in your project:

```php
require_once 'PATH_TO_LIBRARY/src/Obfuscator.php';
```

Parse and obfuscate a string by using the `obfuscateEmail($string)` function.

#### Laravel 5

You have 3 options depending on your use case:

- (recommended) If you want to obfuscate all email addresses that Laravel ever outputs, add the Middleware class to the `$middleware` array in `App\Http\Middleware\Kernel.php`:

    ```php
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
    	    ...
    	\Propaganistas\EmailObfuscator\Laravel\Middleware::class,
    ];
    ```

- If you only want to have specific controller methods return obfuscated email addresses, add the Middleware class to the `$routeMiddleware` array in `App\Http\Middleware\Kernel.php`:
    
    ```php
    protected $routeMiddleware = [
    	'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
    	...
    	'obfuscate' => \Propaganistas\EmailObfuscator\Laravel\Middleware::class,
    ];
    ```
    
    and apply controller middleware as usual in a controller's construct method or route definition:

    ````php
    public function __construct()
    {
        $this->middleware('obfuscate');
    }
    ```

- If you want to apply obfuscation only on specific strings, just use the `obfuscateEmail($string)` function.


#### Twig

Add the extension to the `Twig_Environment`:

```php
$twig = new Twig_Environment(...);
$twig->addExtension(new \Propaganistas\EmailObfuscator\Twig\Extension());
```

The extension exposes an `obfuscateEmail` Twig filter, which can be applied to any string.

```twig
{{ "Lorem Ipsum"|obfuscateEmail }}
{{ variable|obfuscateEmail }}
```

### Your platform not listed here? (aka "Go go community!")

Well, feel free to hop in and create an integration yourself! If you have made an integration bundle/extension/package for a specific framework or CMS, please:

- Fork the project
- Place the necessary files in a correspondingly named folder in `src/`
- Supply a README entry
- Open up a pull request

If your platform enforces a strict package structure, create a repository and submit a pull request supplying only a README entry pointing to your repository.

## Credits

* [Scott Yang](http://scott.yang.id.au/2003/06/obfuscate-email-address-with-javascript-rot13) - For the Javascript used in this method.
* [Silvan Mühlemann](http://techblog.tilllate.com/2008/07/20/ten-methods-to-obfuscate-e-mail-addresses-compared/) - For the inspiration of the CSS implementation.
