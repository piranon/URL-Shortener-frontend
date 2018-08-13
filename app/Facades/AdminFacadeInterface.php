<?php

namespace App\Facades;

/**
 * Interface AdminFacadeInterface
 * @package App\Facades
 */
interface AdminFacadeInterface
{
    /**
     * @return mixed
     */
    public function getUrls();

    /**
     * @param $id
     * @return mixed
     */
    public function deleteUrl($id);
}
