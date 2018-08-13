<?php

namespace App\Facades;

/**
 * Interface URLFacadeInterface
 * @package App\Facades
 */
interface URLFacadeInterface
{
    /**
     * @param array $url
     * @return mixed
     */
    public function createUrl(array $url);

    /**
     * @param string $code
     * @return mixed
     */
    public function getOriginalUrl($code);
}
