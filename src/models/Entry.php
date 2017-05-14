<?php

namespace linuskohl\orgLocationIQ\models;

use \linuskohl\orgLocationIQ\models\Address;

/**
 * Class Entry
 *
 * @package   linuskohl\org-locationiq
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link      https://github.com/linuskohl/org-locationiq
 * @copyright 2017-2020 Linus Kohl
 */

class Entry
{
    /** @var  integer $place_id */
    public $place_id;

    /** @var  string $licence */
    public $licence;

    /** @var  string $osm_type */
    public $osm_type;

    /** @var  integer $osm_id */
    public $osm_id;

    /** @var mixed $boundingbox */
    public $boundingbox;

    /** @var  float $lat */
    public $lat;

    /** @var  float $lon */
    public $lon;

    /** @var  string $display_name */
    public $display_name;

    /** @var string $class */
    public $class;

    /** @var string $type */
    public $type;

    /** @var float $importance */
    public $importance;

    /** @var \linuskohl\orgLocationIQ\models\Address|null $address */
    public $address;

}
