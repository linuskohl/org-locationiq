<?php

namespace linuskohl\orgLocationIQ;

use \linuskohl\orgLocationIQ\models\Entry;

/**
 * Class Client
 *
 * @package   linuskohl\orgLocationIQ;
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link      https://github.com/linuskohl/org-locationiq
 * @copyright 2017-2020 Linus Kohl
 */
class Client
{
    /** locationiq.org base URL */
    const BASE_URL = "https://locationiq.org/v1/";
    const FORMAT   = "json";
    const LANGUAGE = "";

    const DEFAULT_USER_AGENT = "linuskohl-orgLocationIQ";
    const CACHE_ENABLED = false;
    const DEFAULT_TIMEOUT = 4.0;
    const DEFAULT_CACHE_DURATION = 3600;

    /**
     * @var string|null             $api_key
     * @var \GuzzleHttp\Client|null $httpClient
     * @var \JsonMapper|null        $jsonMapper
     * @var mixed                   $cache
     * @var integer                 $requests_left
     * */
    private $httpClient;
    private $jsonMapper;
    private $cache;
    private $settings;

    /**
     * Constructor
     *
     * @param string $auth_token
     */
    public function __construct($api_key = NULL)
    {
        $this->settings = [];

        // initialize the HTTP client
        $this->httpClient = new \GuzzleHttp\Client([
            'base_uri' => self::BASE_URL,
            'timeout'  => self::DEFAULT_TIMEOUT,
            'headers'  => [
                'User-Agent'   => self::DEFAULT_USER_AGENT,
            ],
        ]);

        // initialize the JSON Mapper
        $this->jsonMapper = new \JsonMapper();
        $this->jsonMapper->bIgnoreVisibility = false;
        $this->jsonMapper->bEnforceMapType = false;
        $this->jsonMapper->bExceptionOnUndefinedProperty = false;
        $this->jsonMapper->bExceptionOnMissingData = false;

        $this->settings["format"] = self::FORMAT;
        $this->setAPIKey($api_key);
    }


    /**
     * Set API key
     *
     * @param string $api_key
     * @return void
     */
    public function setAPIKey($api_key)
    {
        $this->settings["key"] = $api_key;
    }

    /**
     * Set language
     *
     * @param string $language Language according to 14.4 https://www.ietf.org/rfc/rfc2616.txt
     * @return void
     */
    public function setLanguage($language)
    {
        $this->settings["accept-language"] = $language;
    }

    /**
     * Show address details
     *
     * @param boolean $details
     * @return void
     */
    public function setShowDetails($details)
    {
        $this->settings["addressdetails"] = $details;
    }



    /**
     * Geocode
     *
     * @param  string $query
     * @param  boolean $cached
     *
     * @return \linuskohl\orgLocationIQ\models\Entry[]|null
     * @throws \Exception
     */
    public function geocode($query, $cached = self::CACHE_ENABLED)
    {
        $entries = [];
        $result = $this->geocodeRaw($query, $cached);

        if(!empty($result) && is_array($result)) {
            foreach($result as $entry) {
                array_push($entries, $this->jsonMapper->map($entry, new Entry()));
            }
        }
        return $entries;
    }



    /**
     * Geocode raw
     *
     * @param string $query
     * @return mixed|null
     */
    public function geocodeRaw($query, $cached = self::CACHE_ENABLED)
    {
        $query_string = 'search.php';
        $params = $this->settings;
        $params["q"] = $query;

        $query_string .= "?" . http_build_query($params);
        $response = $this->get($query_string, [], false);
        $balance = json_decode($response, true);

        return $balance;
    }


    /**
     * Get balance
     *
     * @return integer
     * @throws \Exception
     */
    public function getBalance()
    {
        $error = "";
        $balance = $this->getBalanceRaw();

        if(!empty($balance) && array_key_exists("status", $balance)) {
            $status = $balance["status"];
            switch($status) {
                case "ok":
                    if(array_key_exists("balance",$balance) && array_key_exists("day", $balance["balance"])) {
                        return $balance["balance"]["day"];
                    } else {
                        throw new \Exception("No balance available");
                    }
                    break;
                case "error":
                    if(array_key_exists("message", $balance)) {
                        $error = $balance["message"];
                    }
                    break;
            }
        } else {
            $error = "No valid response";
        }
        throw new \Exception($error);
    }


    /**
     * Get balance
     *
     * @return mixed|null
     */
    public function getBalanceRaw()
    {
        $query_string = 'balance.php';
        $params = ["key"=>$this->api_key];
        $query_string .= "?" . http_build_query($params);
        $response = $this->get($query_string, [], false);
        $balance = json_decode($response, true);

        return $balance;
    }


    /**
     * Set cache
     *
     * @param mixed $cache
     */
    public function setCache($cache)
    {
        $this->cache = $cache;
    }

    /**
     * Send request to API
     *
     * @param  string  $url
     * @param  mixed[] $parameters
     *
     * @return string
     */
    protected function sendRequest($url, $parameters)
    {
        // send request
        try {
            $response = $this->httpClient->request('GET', $url, $parameters);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
        }
        return (string)$response->getBody()->getContents();
    }

    /**
     * Get data from API or cache
     *
     * @param  string  $url
     * @param  mixed[] $parameters
     * @param  boolean $cached
     *
     * @return string
     * @throws \Exception
     */
    protected function get($url, $parameters = [], $cached = true)
    {
        if (isset($this->cache)) {
            $key = self::generateCacheKey($url, $parameters);
            if ($cached) {
                $data = $this->cache->get($key);
                if ($data !== false) {
                    return $data;
                }
            }
            $data = $this->sendRequest($url, $parameters);
            $this->cache->set($key, $data, self::DEFAULT_CACHE_DURATION);

            return $data;
        } else {
            return $this->sendRequest($url, $parameters);
        }
    }

    /**
     * Generate a key to cache the query
     *
     * @param  string $url
     * @param  mixed  $parameters
     *
     * @return string
     */
    protected static function generateCacheKey($url, $parameters)
    {
        return $url . json_encode($parameters);
    }

}
