# Weglot Symfony Bundle
A bundle to make your Symfony website multilingual

## Install

### Require the dependency (with Composer)

```bash
composer require weglot/translate-bundle
```

### Register the bundle

The bundle should be registered automatically, otherwise follow this step.

#### With Symfony 4.x

Add Weglot to `config/bundles.php`:

```php
return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    // ... Other bundles ...
    Weglot\TranslateBundle\WeglotTranslateBundle::class => ['all' => true],
];

```

#### With Symfony 3.X or 2.X

Add Weglot to your `app/AppKernel.php`:

```php
$bundles = array(
    new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
    // ... Other bundles ...
    new Weglot\TranslateBundle\WeglotTranslateBundle(),
);
```

## Configuration

Add the following to your `config.yml`

```yaml
weglot_translate:
    api_key: 'API_KEY'
    original_language : 'fr'
    destination_languages:
        - 'en'
        - 'es'
        - 'de'
```

This is an example of configuration, enter your own API key, your original language and destination languages that you want.

* `api_key` : is your personal API key. You can get an API Key by signing up on [weglot](https://dashboard.weglot.com/register).
* `original_language` : original language is the language of your website before translation.
* `original_language` : are the languages that you want your website to be translated into


## Add a language button

At this point, this is already working : Try going on your website and add the 2 letters code in the URL of your website.

For example if your website is on : `http://localhost`, then try to go on `http://localhost/es/` and you should see the page in Spanish !

But now you will need to add a language button in your twig templates.

To add the language button , add the following code in your twig :  `{{ weglot_translate_render(1) }}`

We have a second layout : `{{ weglot_translate_render(2) }}`

Finally, you can customize the button by adding your CSS code. There are already classes you can use.

## Help

Send me a message at remy@weglot.com`
