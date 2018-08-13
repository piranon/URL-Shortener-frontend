<?php

namespace App\Services;

use App\Facades\AdminFacadeInterface;
use App\Models\URLView;

/**
 * Class AdminService
 * @package App\Services
 */
class AdminService
{
    /**
     * @var AdminFacadeInterface
     */
    protected $adminFacade;

    /**
     * AdminService constructor.
     * @param AdminFacadeInterface $adminFacade
     */
    public function __construct(AdminFacadeInterface $adminFacade)
    {
        $this->adminFacade = $adminFacade;
    }

    /**
     * @return URLView[]
     */
    public function getAllUrls()
    {
        /** @var URLView $urls */
        $urls = [];

        $responses = $this->adminFacade->getUrls();

        foreach ($responses as $response) {
            $urls[] = new URLView(
                $response->id,
                $response->code,
                $response->hits,
                $response->url,
                $response->status,
                $response->expires_in,
                $response->created_at,
                $response->updated_at
            );
        }

        return $urls;
    }

    public function search($field, $searchText)
    {
        /** @var URLView $urls */
        $urls = [];

        $responses = $this->adminFacade->getUrlsByField($field, $searchText);

        foreach ($responses as $response) {
            $urls[] = new URLView(
                $response->id,
                $response->code,
                $response->hits,
                $response->url,
                $response->status,
                $response->expires_in,
                $response->created_at,
                $response->updated_at
            );
        }

        return $urls;
    }


    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteUrl($id)
    {
        if (empty($id)) {
            return ['success' => false, 'message' => 'Invalid URL ID.'];
        }

        return $this->adminFacade->deleteUrl($id);
    }
}
