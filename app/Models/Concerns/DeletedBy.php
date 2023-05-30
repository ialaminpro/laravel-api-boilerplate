<?php

declare(strict_types=1);

namespace App\Models\Concerns;


trait DeletedBy
{
    public static function bootDeletedBy()
    {
        // deleting deleted_by when model is updated
        static::deleting(function ($model) {
            if (!$model->isDirty('deleted_by') || !$model->deleted_by) {
                $model->deleted_by = auth('sanctum')->user()?->id;
            }
        });
    }

}
