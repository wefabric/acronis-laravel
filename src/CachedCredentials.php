<?php

namespace Wefabric\AcronisLaravel;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Facades\Cache;
use Wefabric\Acronis\Credentials;

class CachedCredentials extends Credentials implements Arrayable, Jsonable
{

    /**
     * @param string $clientId
     * @param string $clientSecret
     * @return CachedCredentials
     */
    public static function make(string $clientId, string $clientSecret): CachedCredentials
    {
        $cachedCredentials = new self($clientId, $clientSecret);
        $cachedCredentials->fillFromCache();
        return $cachedCredentials;
    }

    /**
     * @param string $accessToken
     * @return void
     */
    public function setAccessToken(string $accessToken): void
    {
        parent::setAccessToken($accessToken);
        $this->saveToCache();
    }

    /**
     * @param int $expiresOn
     * @return void
     */
    public function setExpiresOn(int $expiresOn): void
    {
        parent::setExpiresOn($expiresOn);
        $this->saveToCache();
    }

    /**
     * @param Carbon|null $expiresAt
     * @return void
     */
    public function setExpiresAt(?Carbon $expiresAt): void
    {
        parent::setExpiresAt($expiresAt);
        $this->saveToCache();
    }

    /**
     * @return void
     */
    public function fillFromCache(): void
    {
        if($data = Cache::get($this->getCacheKey())) {
            if(isset($data['access_token'])) {
                $this->setAccessToken($data['access_token']);
            }
            if(isset($data['expires_on'])) {
                $this->setExpiresOn($data['expires_on']);
            }
            if(isset($data['expires_at'])) {
                $this->setExpiresAt(new Carbon($data['expires_at']));
            }
        }
    }

    /**
     * @return void
     */
    private function saveToCache(): void
    {
        Cache::put($this->getCacheKey(), $this->toArray(), $this->getExpiresOn());
    }

    /**
     * @return void
     */
    public function clearCache(): void
    {
        Cache::forget($this->getCacheKey());
    }

    /**
     * @return string
     */
    private function getCacheKey(): string
    {
        return 'acronis-laravel-'.$this->getClientId();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'access_token' => $this->getAccessToken(),
            'expires_on' => $this->getExpiresOn(),
            'expires_at' => $this->getExpiresAt()
        ];
    }

    /**
     * @param $options
     * @return false|string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

}
