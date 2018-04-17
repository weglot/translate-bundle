<!-- logo -->
<img src="https://cdn.weglot.com/logo/logo-hor.png" height="40" />

# Symfony Translate Bundle

<!-- tags -->
[![Latest Stable Version](https://poser.pugx.org/weglot/translate-bundle/v/stable)](https://packagist.org/packages/weglot/translate-bundle)
[![Maintainability](https://api.codeclimate.com/v1/badges/b1785d1e9225869f3da0/maintainability)](https://codeclimate.com/github/weglot/translate-bundle/maintainability)
[![License](https://poser.pugx.org/weglot/translate-bundle/license)](https://packagist.org/packages/weglot/translate-bundle)

## Overview
Seamless integration of Weglot into your Symfony project.

## Requirements
- PHP version 5.5 and later
- Weglot API Key, starting at [free level](https://dashboard.weglot.com/register)

## Installation
You can install the library via [Composer](https://getcomposer.org/). Run the following command:

```bash
composer require weglot/translate-bundle
```

To use the library, use Composer's [autoload](https://getcomposer.org/doc/01-basic-usage.md#autoloading):

```php
require_once __DIR__. '/vendor/autoload.php';
```

## Getting Started

### Bundle Register

#### Symfony 4

Add Weglot bundle in the `config/bundles.php`:
```php
return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    // ... Other bundles ...
    Weglot\TranslateBundle\WeglotTranslateBundle::class => ['all' => true],
];
```

#### Symfony 3 & 2

Add Weglot bundle to `app/AppKernel.php` file:
```php
$bundles = array(
    new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
    // ... Other bundles ...
    new Weglot\TranslateBundle\WeglotTranslateBundle(),
);
```

### Configuration

For Symfony 4, create configuration file under `config/packages/weglot_translate.yml` and add following content.
For Symfony 3 & 2, add following content to your `config.yml`.
```yaml
weglot_translate:
    api_key: 'YOUR_WEGLOT_API_KEY'
    original_language : 'en'
    destination_languages:
        - 'fr'
        - 'de'
```

This is an example of configuration, enter your own API key, your original language and destination languages that you want.
- `api_key` : is your personal API key. You can get an API Key by signing up on weglot.
- `original_language` : original language is the language of your website before translation.
- `destination_languages` : are the languages that you want your website to be translated into.

There is also a non-required parameters `exclude_blocks` where you can list all blocks you don't want to be translated. For example, if I've a block with class "site-name", you've to do as following:
```yaml
    exclude_blocks:
        - .site-name
```

### Optional - Language button

You can add a language button if you're using Twig with function: `weglot_translate_render`

Two layouts exists:
```twig
<!-- first layout (horizontal) -->
{{ weglot_translate_render(1) }}

<!-- first layout (vertical) -->
{{ weglot_translate_render(2) }}
```


## Examples

TODO

## About
`translate-bundle` is guided and supported by the Weglot Developer Team.

`translate-bundle` is maintained and funded by Weglot SAS.
The names and logos for `translate-bundle` are trademarks of Weglot SAS.

## License
[The MIT License (MIT)](LICENSE.txt)