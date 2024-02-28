<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int       $id
 * @property int       $user_id
 * @property string    $title
 * @property string    $seo_slug
 * @property string    $content
 * @property string    $created_at
 * @property string    $updated_at
 * @property string    $deleted_at
 *
 * @property-read User $user
 */
class UserArticle extends Model
{
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $fillable = [
        'title',
        'seo_slug',
        'content',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class)->cascadeOnDelete();
    }
}
