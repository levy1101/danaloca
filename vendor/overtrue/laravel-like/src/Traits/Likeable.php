<?php

namespace Overtrue\LaravelLike\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

trait Likeable
{
    public function isLikedBy(Model $user): bool
    {
        if (\is_a($user, config('like.user_model') ?? config('auth.providers.users.model'))) {
            if ($this->relationLoaded('likers')) {
                return $this->likers->contains($user);
            }

            return $this->likers()->where(\config('like.user_foreign_key'), $user->getKey())->exists();
        }

        return false;
    }

    /**
     * Return followers.
     */
    public function likers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(
            config('like.user_model') ?? config('auth.providers.users.model'),
            config('like.likes_table'),
            'likeable_id',
            config('like.user_foreign_key')
        )
            ->where('likeable_type', $this->getMorphClass());
    }

    protected function totalLikers(): Attribute
    {
        return Attribute::get(function () {
            return $this->likers()->count() ?? 0;
        });
    }
}
