<?php

declare(strict_types=1);

namespace App\Models\Concerns;


trait CreatedBy
{
    public static function bootCreatedBy()
    {

        // updating created_by and updated_by when model is created
        static::creating(function ($model) {
            if (!$model->isDirty('created_by') || !$model->created_by) {
                $model->created_by = auth('sanctum')->user()?->id;
            }
            if (!$model->isDirty('updated_by') || !$model->updated_by) {
                $model->updated_by = auth('sanctum')->user()?->id;
            }

        });
    }

}
