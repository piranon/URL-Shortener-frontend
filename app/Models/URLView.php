<?php

namespace App\Models;

/**
 * Class URLView
 * @package App\Models
 */
class URLView
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $code;

    /**
     * @var int
     */
    public $hits;

    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $status;

    /**
     * @var string
     */
    public $expires;

    /**
     * @var string
     */
    public $created;

    /**
     * @var string
     */
    public $updated;

    /**
     * URLView constructor.
     * @param int $id
     * @param string $code
     * @param int $hits
     * @param string $url
     * @param string $status
     * @param string $expires
     * @param string $created
     * @param string $updated
     */
    public function __construct(
        $id,
        $code,
        $hits,
        $url,
        $status,
        $expires,
        $created,
        $updated
    ) {
        $this->id = (int)$id;
        $this->code = $code;
        $this->hits = (int)$hits;
        $this->url = $url;
        $this->status = $status;
        $this->expires = $expires;
        $this->created = $created;
        $this->updated = $updated;
    }
}
