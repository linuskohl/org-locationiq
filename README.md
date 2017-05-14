# org-locationiq

Unofficial Locationiq.org API client<br>

Documentation available [here](https://locationiq.org/?#docs).<br>
Able to serialize responses to custom models via JSON mapper.<br>

## Requirements
-  "guzzlehttp/guzzle": "^6.2"
-  "netresearch/jsonmapper": "~1.1.1"

## Install

Via Composer

``` bash
$ composer require linuskohl/org-locationiq dev-master
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[link-author]: https://github.com/linuskohl

## Documentation
### Class: \linuskohl\orgLocationIQ\Client
| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>mixed</em> <strong>$api_key=null</strong>)</strong> : <em>void</em><br /><em>Constructor</em> |
| public | <strong>geocode(</strong><em>string</em> <strong>$query</strong>, <em>bool/boolean</em> <strong>$cached=false</strong>)</strong> : <em>\linuskohl\orgLocationIQ\models\Entry[]/null</em><br /><em>Geocode</em> |
| public | <strong>geocodeRaw(</strong><em>string</em> <strong>$query</strong>, <em>bool</em> <strong>$cached=false</strong>)</strong> : <em>mixed/null</em><br /><em>Geocode raw</em> |
| public | <strong>getBalance()</strong> : <em>integer</em><br /><em>Get balance</em> |
| public | <strong>getBalanceRaw()</strong> : <em>mixed/null</em><br /><em>Get balance</em> |
| public | <strong>setAPIKey(</strong><em>string</em> <strong>$api_key</strong>)</strong> : <em>void</em><br /><em>Set API key</em> |
| public | <strong>setCache(</strong><em>mixed</em> <strong>$cache</strong>)</strong> : <em>void</em><br /><em>Set cache</em> |
| public | <strong>setLanguage(</strong><em>string</em> <strong>$language</strong>)</strong> : <em>void</em><br /><em>Set language</em> |
| public | <strong>setShowDetails(</strong><em>boolean</em> <strong>$details</strong>)</strong> : <em>void</em><br /><em>Show address details</em> |
| protected static | <strong>generateCacheKey(</strong><em>string</em> <strong>$url</strong>, <em>mixed</em> <strong>$parameters</strong>)</strong> : <em>string</em><br /><em>Generate a key to cache the query</em> |
| protected | <strong>get(</strong><em>string</em> <strong>$url</strong>, <em>array/mixed[]</em> <strong>$parameters=array()</strong>, <em>bool/boolean</em> <strong>$cached=true</strong>)</strong> : <em>string</em><br /><em>Get data from API or cache</em> |
| protected | <strong>sendRequest(</strong><em>string</em> <strong>$url</strong>, <em>mixed[]</em> <strong>$parameters</strong>)</strong> : <em>string</em><br /><em>Send request to API</em> |
