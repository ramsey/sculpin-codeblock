# Codeblock Bundle for Sculpin

This [Sculpin](https://sculpin.io/) bundle provides the [Codeblock extension for Twig](https://github.com/ramsey/twig-codeblock) to Sculpin sites.

This project adheres to a [Contributor Code of Conduct][conduct]. By participating in this project and its community, you are expected to uphold this code.

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
            'Ramsey\Sculpin\Bundle\CodeBlockBundle\RamseySculpinCodeBlockBundle',
        );
    }
}
```

For more information, see the Sculpin [Configuration](https://sculpin.io/documentation/extending-sculpin/configuration/) documentation.

## TODO

* Write tests for this package


[conduct]: https://github.com/ramsey/sculpin-codeblock/blob/master/CODE_OF_CONDUCT.md