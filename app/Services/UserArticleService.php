<?php

namespace App\Services;

use App\Jobs\ActualizeUserArticleSeoSlugs;
use App\Models\User;
use App\Models\UserArticle;
use Illuminate\Support\Facades\DB;

class UserArticleService
{
    public function create(array $data, User $user)
    {
        $userArticle           = new UserArticle();
        $userArticle->user_id  = $user->id;
        $userArticle->seo_slug = $data['seo_slug'];
        $userArticle->title    = $data['title'];
        $userArticle->content  = $data['content'];

        DB::transaction(function () use ($userArticle) {
            $userArticle->saveOrFail();
        });

        return $userArticle;
    }

    public function update(UserArticle $userArticle, array $data, User $user): UserArticle
    {
        $userArticle->user_id  = $user->id;
        $userArticle->seo_slug = $data['seo_slug'];
        $userArticle->title    = $data['title'];
        $userArticle->content  = $data['content'];

        DB::transaction(function () use (UserArticle $userArticle, User $user) {
            $userArticle->saveOrFail();
            $user->total_articles++;
            $user->saveOrFail();
        });

        return $userArticle;
    }

    public function actualizeSeoSlugs(User $user): void
    {
        dispatch(new ActualizeUserArticleSeoSlugs($user));
    }
}
