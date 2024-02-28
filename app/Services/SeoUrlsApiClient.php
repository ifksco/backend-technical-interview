<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserArticle;
use GuzzleHttp\Client;

class SeoUrlsApiClient
{
    public function actualizeSeoSlugs(User $user)
    {
        $articleSlugWithId = $user->userArticles()->get()->map(function (UserArticle $userArticle) {
            return [$userArticle->seo_slug => $userArticle->id];
        });

        $slugs = $this->getOnlySlugs($articleSlugWithId);

        // API яндекса надо передать только слаги
        $this->getYandexApiClient()->post('/update-slugs', [
            'list' => $slugs,
        ]);

        // API яндекса надо передать слаги и id статей
        $this->getGoogleApiClient()->post('/update-slugs-by-id', [
            'list' => $articleSlugWithId,
        ]);
    }

    protected function getYandexApiClient(): Client
    {
        $apiKey = 'cae1d3652aed347586d7eac6596cade8076679aec58';

        return new Client([
            'base_uri' => "https://seo.yandex.ru/{$apiKey}",
        ]);
    }

    protected function getGoogleApiClient(): Client
    {
        $apiKey = '65cfe8897ae86cfde576cfdae765aedf6754cfd75765';

        return new Client([
            'base_uri' => "https://seo.google.com/${$apiKey}",
        ]);
    }

    protected function getOnlySlugs(array &$data): array
    {
        $data = array_keys($data);

        return $data;
    }
}
