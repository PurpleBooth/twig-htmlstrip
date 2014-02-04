twig-htmlstrip
==============

Filter for Twig to convert HTML into Text

Build Status: [![Build Status](https://travis-ci.org/PurpleBooth/twig-htmlstrip.png?branch=master)](https://travis-ci.org/PurpleBooth/twig-htmlstrip)

To use:

Add the dependency to your composer.json
```bash
php composer.phar require purplebooth/twig-htmlstrip:dev-master
```

Add a service which points to the class, and tag it with the twig.extension tag.
```yaml
# src/Acme/DemoBundle/Resources/config/services.yml
services:
    purplebooth.twig.html_stripper_extension:
        class: PurpleBooth\HtmlStripperExtension
        tags:
            - { name: twig.extension }
```

And use it
```twig
{{ yourhtml|html_strip }}
```