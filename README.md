# Codeblock Bundle for Sculpin

This [Sculpin](https://sculpin.io/) bundle provides the [Codeblock extension for Twig](https://github.com/ramsey/twig-codeblock) to Sculpin sites.

## Installation

Add `ramsey/sculpin-codeblock` as a requirement to your `sculpin.json` file and run `sculpin install`.

Then, add the bundle to your `SculpinKernel`. For example:

``` php
<?php
class SculpinKernel extends \Sculpin\Bundle\SculpinBundle\HttpKernel\AbstractKernel
{
    protected function getAdditionalSculpinBundles()
    {
        return array(
            'Ramsey\\Sculpin\\Bundle\\CodeBlockBundle\\RamseySculpinCodeBlockBundle',
        );
    }
}
```

For more information, see the Sculpin [Configuration](https://sculpin.io/documentation/extending-sculpin/configuration/) documentation.

## TODO

* Write tests for this package
