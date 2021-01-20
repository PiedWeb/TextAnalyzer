<p align="center"><a href="https://dev.piedweb.com">
<img src="https://raw.githubusercontent.com/PiedWeb/piedweb-devoluix-theme/master/src/img/logo_title.png" width="200" height="200" alt="Open Source Package" />
</a></p>

# Text Analyzer

[![Latest Version](https://img.shields.io/github/tag/PiedWeb/TextAnalyzer.svg?style=flat&label=release)](https://github.com/PiedWeb/TextAnalyzer/tags)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat)](LICENSE)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/PiedWeb/TextAnalyzer/Tests?label=tests)](https://github.com/PiedWeb/TextAnalyzer/actions)
[![Quality Score](https://img.shields.io/scrutinizer/g/PiedWeb/TextAnalyzer.svg?style=flat)](https://scrutinizer-ci.com/g/PiedWeb/TextAnalyzer)
[![Code Coverage](https://codecov.io/gh/PiedWeb/TextAnalyzer/branch/main/graph/badge.svg)](https://codecov.io/gh/PiedWeb/TextAnalyzer/branch/main)
[![Type Coverage](https://shepherd.dev/github/PiedWeb/TextAnalyzer/coverage.svg)](https://shepherd.dev/github/PiedWeb/TextAnalyzer)
[![Total Downloads](https://img.shields.io/packagist/dt/piedweb/text-analyzer.svg?style=flat)](https://packagist.org/packages/piedweb/text-analyzer)

Semantic Analysis : Extract Expressions from a text and order it by density.

## Install

Via [Packagist](https://img.shields.io/packagist/dt/piedweb/text-analyzer.svg?style=flat)

``` bash
$ composer require piedweb/text-analyzer
```

## Usage

``` php

use \PiedWeb\ExpressionHarvester\MultiAnalyzer;

$test = new MultiAnalyzer($onlyInSentence = true, $expressionMaxWords = 5, $keepTrail = 5);

$result = $test->addContent("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed...");  // @return \PiedWeb\TextAnalyzer\Analysis
    $result->getExpressions(); // @return array
    $result->getTrails(); // @return array
    $result->getTrail('expression'); // @return array
    $result->getWordNumber(); // @çeturn int

$results = $test->exec(); // @return \PiedWeb\TextAnalyzer\Analysis
    // same methods except in get expression, the value for each expression is not anymore his number

```

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing](https://dev.piedweb.com/contributing)

## Credits

- [PiedWeb](https://piedweb.com)
- [All Contributors](https://github.com/PiedWeb/:package_skake/graphs/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
