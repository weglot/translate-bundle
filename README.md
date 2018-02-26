# Weglot Symfony Bundle
A bundle to make your Symfony website multilingual

## Install

### Require the dependency (with Composer)

```bash
composer require weglot/translate-bundle dev-4-rework-for-_locale-compatibility
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

#### With Symfony 3.4

Add Weglot to your `app/Kernel.php`:

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

This is an example, enter your own API key, your original language and destination languages that you want