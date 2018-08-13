<?php

namespace App\Services;

use App\Facades\URLFacadeInterface;

/**
 * Class URLService
 * @package App\Services
 */
class URLService
{
    /**
     * @var URLFacadeInterface
     */
    protected $urlFacade;

    /**
     * URLService constructor.
     * @param URLFacadeInterface $urlFacade
     */
    public function __construct(URLFacadeInterface $urlFacade)
    {
        $this->urlFacade = $urlFacade;
    }

    /**
     * @param $url
     * @param $expires
     * @return mixed
     */
    public function create($url, $expires)
    {
        $create = [
            'url' => $url
        ];

        if (!empty($expires)) {
            $dateTime = new \DateTime();
            $dateTime->modify('+' . $expires . ' day');
            $create['expires'] = $dateTime->format('Y-m-d H:i:s');
        }

        return $this->urlFacade->createUrl($create);
    }
}
