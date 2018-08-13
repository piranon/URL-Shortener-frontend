<?php

namespace App\Services;

use App\Facades\URLFacadeInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class URLService
 * @package App\Services
 */
class URLService
{
    const STATUS_ACTIVE = 'active';
    const STATUS_DELETED = 'deleted';
    const STATUS_EXPIRED = 'expired';

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

    /**
     * @param string $code
     * @return array
     */
    public function getRedirectUrl($code)
    {
        $originalUrl = $this->urlFacade->getOriginalUrl($code);

        if (!isset($originalUrl['url']) || !isset($originalUrl['status'])) {
            return ['http_code' => Response::HTTP_NOT_FOUND];
        }

        $url = $originalUrl['url'];
        $status = $originalUrl['status'];

        if ($status === URLService::STATUS_ACTIVE) {
            $httpCode = Response::HTTP_FOUND;
        } elseif ($status === URLService::STATUS_DELETED || $status === URLService::STATUS_EXPIRED) {
            $httpCode = Response::HTTP_GONE;
        } else {
            $httpCode = Response::HTTP_OK;
        }

        return ['url' => $url, 'http_code' => $httpCode];
    }
}
