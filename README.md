<!-- logo -->
<img src="https://cdn.weglot.com/logo/logo-hor.png" height="40" />

# Symfony Translate Bundle

<!-- tags -->
[![WeglotSlack](https://weglot-community.now.sh/badge.svg)](https://weglot-community.now.sh/)
[![Latest Stable Version](https://poser.pugx.org/weglot/translate-bundle/v/stable)](https://packagist.org/packages/weglot/translate-bundle)
[![Maintainability](https://api.codeclimate.com/v1/badges/b1785d1e9225869f3da0/maintainability)](https://codeclimate.com/github/weglot/translate-bundle/maintainability)
[![License](https://poser.pugx.org/weglot/translate-bundle/license)](https://packagist.org/packages/weglot/translate-bundle)

## Overview
Seamless integration of Weglot into your Symfony project.

## Requirements
- PHP version 5.5 and later
- Weglot API Key, starting at [free level](https://dashboard.weglot.com/register?origin=8)

## Installation
You can install the library via [Composer](https://getcomposer.org/). Run the following command:

```bash
composer require weglot/translate-bundle
```

When you require the bundle with `symfony/flex` (available for `symfony/symfony:^4.0`) it should ask you if you wanna execute a recipe, tell yes.
Like that it will make bundle registration in `config/bundles.php` & default config creation in `config/packages/weglot_translate.yaml`.

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

### Quick configuration

For Symfony 4, create configuration file under `config/packages/weglot_translate.yaml` and add following content.
For Symfony 3 & 2, add following content to your `app/config/config.yaml`.

```yaml
weglot_translate:
    api_key: '%env(WG_API_KEY)%'
    original_language : 'en'
    cache: true
    destination_languages:
        - 'fr'
        - 'de'
```

This is the default configuration file, if you want more default, check next part.

## Configuration

As already said, depending on Symfony version, we've different configuration file paths:
- Symfony 4: `config/packages/weglot_translate.yaml`
- Symfony 3 & 2: `app/config/config.yaml`

There is a full configuration file:

```yaml
weglot_translate:
  api_key: '%env(WG_API_KEY)%'
  original_language : 'en'
  cache: false
  destination_languages:
    - 'fr'
    - 'de'
  exclude_blocks:
    - '.material-icons'
```

This is an example of configuration, enter your own API key, your original language and destination languages that you want.
- `api_key` : is your personal API key. You can get an API Key by signing up on [Weglot](https://dashboard.weglot.com/register?origin=8).
- `original_language` : original language is the language of your website before translation.
- `destination_languages` : are the languages that you want your website to be translated into.
- `cache` : if you wanna use cache or not. It's not a required field and set as false by default. Look at [Caching part](#caching) for more details.

There is also a non-required parameters:
- `exclude_blocks` : You can list here all blocks you don't want to be translated. In this example, we won't translate all DOM tags with "material-icons" class.

## Twig extensions

### Hreflang links

Hreflang links are a way to describe your website and to tell webcrawlers (such as search engines) if this page is available in other languages.
More details on Google post about hreflang: https://support.google.com/webmasters/answer/189077

You can add them through the Twig function: `weglot_hreflang_render`

Just put the function at the end of your `<head>` tag:
```twig
<html>
    <head>
        ...

        {{ weglot_hreflang_render() }}
    </head>
```

### Language button

You can add a language button if you're using Twig with function: `weglot_translate_render`

Two layouts exists:
```twig
<!-- first layout -->
{{ weglot_translate_render(1) }}

<!-- second layout -->
{{ weglot_translate_render(2) }}
```

### Language code

Simple filter to convert ISO 639-1 code to full language name. It can takes one boolean parameter that allow you to choose having english name or original language name.

Here is some examples:
```twig
<!-- Will return english name for given code, here: "Bulgarian" -->
{{ 'bg' | language }}

<!-- Will return original name for given code, here: "български" -->
{{ 'bg' | language(false) }}
```

## Caching

We implemented usage of cache pool service for both Symfony 4 and Symfony 3 (`symfony/cache` bundle was released with Symfony 3, so there is no compatibility for Symfony 2).

If you wanna use cache, just add `cache: true` to this bundle configuration. It will use a file-based cache through Symfony `cache.system` service.

To clear the cache, you just have to use the usual pool clear command:
```
$ php bin/console cache:pool:clear weglot_translate.cache
```

## Examples

You'll find a short README with details about example on each repository

- Symfony 4: https://github.com/weglot/translate-bundle-example-sf4
- Symfony 3: https://github.com/weglot/translate-bundle-example-sf3
- Symfony 2: https://github.com/weglot/translate-bundle-example-sf2

## About
`translate-bundle` is guided and supported by the Weglot Developer Team.

`translate-bundle` is maintained and funded by Weglot SAS.
The names and logos for `translate-bundle` are trademarks of Weglot SAS.

## License
[The MIT License (MIT)](LICENSE.txt)
