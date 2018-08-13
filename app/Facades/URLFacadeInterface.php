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
}
