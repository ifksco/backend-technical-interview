<?php

namespace App\Http\Resources;

use App\Models\UserArticle;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property UserArticle $resource
 */
class UserArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title'    => $this->resource->title,
            'user'     => new UserResource($this->resource->user),
            'content'  => $this->resource->content,
            'seo_slug' => $this->resource->seo_slug,
        ];
    }
}
