<?php

namespace Modules\SolarMitra\Traits;

use Illuminate\Support\Str;

trait HasUniqueUuid
{
    /**
     * Boot the trait.
     */
    protected static function bootHasUniqueUuid()
    {
        static::creating(function ($model) {
            // Only generate if not already set
            if (!$model->uuid) {
                do {
                    $uuid = (string) Str::uuid();
                } while (self::where($model->getUuidColumn(), $uuid)->exists());

                $model->{$model->getUuidColumn()} = $uuid;
            }
        });
    }

    /**
     * Define which column stores the UUID.
     * Override in your model if different.
     */
    public function getUuidColumn(): string
    {
        return property_exists($this, 'uuidColumn') ? $this->uuidColumn : 'uuid';
    }
}