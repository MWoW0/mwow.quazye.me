<?php

namespace App\Concerns;

trait Sluggable
{
    public static function bootSluggable()
    {
        static::creating(function ($model) {
            if ($model->shouldMakeSlug()) {
                $model->{$model->slugAttribute()} = $model->makeSlug();
            }
        });

        static::updating(function ($model) {
            if ($model->shouldMakeSlug()) {
                $model->{$model->slugAttribute()} = $model->makeSlug();
            }
        });
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return $this->slugAttribute();
    }

    public function slugAttribute(): string
    {
        return 'slug';
    }

    public function sluggableAttribute(): string
    {
        return 'name';
    }

    public function shouldMakeSlug(): bool
    {
        if ($this->exists) {
            return $this->isDirty($this->sluggableAttribute());
        }

        return blank($this->{$this->slugAttribute()});
    }

    public function makeSlug(): string
    {
        $sluggable = $this->sluggableAttribute();

        return str_slug($this->$sluggable);
    }
}