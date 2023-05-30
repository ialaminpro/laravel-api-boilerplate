<?php

declare(strict_types=1);

namespace App\Models\Concerns;


trait UpdatedBy
{
    public static function bootUpdatedBy()
    {

        // updating updated_by when model is updated
        static::updating(function ($model) {
            if (!$model->isDirty('updated_by') || !$model->updated_by) {
                $model->updated_by = auth('sanctum')->user()?->id;
            }
        });
    }

}
