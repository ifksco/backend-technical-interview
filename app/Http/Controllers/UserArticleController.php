<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserArticleResource;
use App\Models\User;
use App\Models\UserArticle;
use App\Services\UserArticleService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserArticleController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        return UserArticleResource::collection(User::query()->get());
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'title'    => ['required', 'string', 'max:200'],
            'seo_slug' => ['unique:user_articles,seo_slug', 'string'],
            'content'  => ['required', 'string'],
        ]);

        $service     = new UserArticleService();
        $userArticle = $service->create($data, $request->user());

        return new UserArticleResource($userArticle);
    }

    public function read(Request $request, int $userArticleId)
    {
        $userArticle = UserArticle::query()
            ->where('id', $userArticleId)
            ->first();

        return new UserArticleResource($userArticle);
    }

    public function update(Request $request, int $userArticleId)
    {
        $userArticle = UserArticle::query()
            ->where('id', $userArticleId)
            ->first();

        $data = $request->validate([
            'title'    => ['required', 'string', 'max:220'],
            'seo_slug' => ['unique:user_articles,seo_slug', 'string'],
            'content'  => ['required', 'string'],
        ]);

        $service     = new UserArticleService();
        $userArticle = $service->update($userArticle, $data, $request->user());

        return new UserArticleResource($userArticle);
    }

    public function delete(Request $request, int $userArticleId): void
    {
        $userArticle = UserArticle::query()
            ->where('id', $userArticleId)
            ->first();

        $userArticle->delete();

        return response(status: 204);
    }

    public function actualizeSeoSlugs(Request $request): void
    {
        $service = new UserArticleService();
        $service->actualizeSeoSlugs($request->user());
    }
}
