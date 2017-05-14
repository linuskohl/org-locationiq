<?php

namespace linuskohl\orgLocationIQ\models;

/**
 * Class Address
 *
 * @package   linuskohl\org-locationiq
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link      https://github.com/linuskohl/org-locationiq
 * @copyright 2017-2020 Linus Kohl
 */

class Address
{
    /** @var string|null $house_number */
    public $house_number;

    /** @var string|null $road */
    public $road;

    /** @var string|null $neighbourhood */
    public $neighbourhood;

    /** @var string|null $suburb */
    public $suburb;

    /** @var string|null $city_district */
    public $city_district;

    /** @var string|null $city */
    public $city;

    /** @var string|null $state_district */
    public $state_district;

    /** @var string|null $state */
    public $state;

    /** @var string|null $postcode */
    public $postcode;

    /** @var string|null $country */
    public $country;

    /** @var string|null $country_code */
    public $country_code;

}
