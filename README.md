# laravel-backpack-branding

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

This package will easily provide you with all the defaults of a new laravel-backpack installation you need to change in order to brand your backend. 

## Install

Via Composer

``` bash
$ composer require zoutapps/laravel-backpack-branding
```

## Basic Usage

Just type the following command in your console.
```
$ php artisan za:brand
```
This will ask you for all the values you can set.

## Extended Usage

You can store your global defaults as as `json` file if you don't want to enter them on each setup.  
We will still ask you for any value we can set that is not provided in the `json` file.  
Furthermore you can also define values we currently don't ask for and add/replace them.

To apply your global defaults just use
``` php
$ php artisan za:brand path/to/your/default.json
```

### Json Format 

* beneath the `env`-key you can specify values to add/replace in your `.env` file.
* the `config` objects contains the config-file keys that should be touched. We currently only support the `backpack_base` key to specify values that should be replaced in your `config/backpack/base.php`
* next is the `copy` array where you define ann array of objects with `src` and `dest`. For each object all files and folders under the src path (relative to the default.json) will be copied to the dest-path (relative to your project root).
* last is the `branding` object that defines values for the `Branding` facade.

Sample `defaults.json` file:

```json
{
  "env": {
    "BACKPACK_LICENSE": "YOUR_BACKPACK_LICENCE_KEY",
    "BACKPACK_REGISTRATION_OPEN": false
  },
  "config": {
    "backpack_base": {
      "project_name": "Your Project Name",
      "logo_lg": "<b>Back</b>pack",
      "logo_mini": "<b>B</b>p",
      "developer_name": "Oliver Ziegler",
      "developer_link": "https://zoutapps.de",
      "show_powered_by": true,
      "skin": "skin-blue",
      "default_date_format": "d.m.Y",
      "default_datetime_format": "d.m.Y H:i",
      "route_prefix": "admin"
    }
  },
  "copy": [
    {
      "src": "public/vendor",
      "dest": "public/vendor"
    }
  ],
  "branding": {
    "asset": {
      "logo": "public/vendor/logo.png",
      "banner": "public/vendor/banner.png"
    },
    "url": "https://github/zoutapps",
    "developer": "Zout Apps"
  }
}
```

## Facade

We provide a `Branding` facade to conveniently access some of your branding values.

Currently implemented are:

* `Branding::asset($key)`: will return the asset url of the file (eg. `Branding::asset('logo')`)
* `Branding::link($content = null, $class = null, $target = null)`: will return an html `<a>` tag with specified values or convenient defaults.
* `Branding::developer()`: returns the developer name specified
* `Branding::url()`: returns the url specified

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email oliver.ziegler@zoutapps.de instead of using the issue tracker.

## Credits

- [Oliver Ziegler][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/zoutapps/laravel-backpack-branding.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/zoutapps/laravel-backpack-branding/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/zoutapps/laravel-backpack-branding.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/zoutapps/laravel-backpack-branding.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/zoutapps/laravel-backpack-branding.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/zoutapps/laravel-backpack-branding
[link-travis]: https://travis-ci.org/zoutapps/laravel-backpack-branding
[link-scrutinizer]: https://scrutinizer-ci.com/g/zoutapps/laravel-backpack-branding/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/zoutapps/laravel-backpack-branding
[link-downloads]: https://packagist.org/packages/zoutapps/laravel-backpack-branding
[link-author]: https://github.com/OliverZiegler
[link-contributors]: ../../contributors
