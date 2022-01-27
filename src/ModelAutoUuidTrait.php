<?php

namespace VirX\LaravelModelAutoUuid;

use Illuminate\Support\Str;

trait AutoUuid
{

    public static function bootAutoUuid()
    {
        static::creating(function ($model) {
            if(empty($model->{$model->getUuidColumn()})) {
                if (!empty($model->uuid_type)) {
                    switch ($model->uuid_type) {
                        case 'uuid':
                            $model->{$model->getUuidColumn()} = Str::uuid()->toString();
                            break;
                        default:
                            throw new \Exception("Unknown UUID convention {$model->uuid_type}");
                    }
                } else {
                    // Default
                    $model->{$model->getUuidColumn()} = Str::orderedUuid()->toString();
                }
            }
        });
    }

    public function getUuidColumn(): string
    {
        if (empty($this->uuid_column)) {
            return 'uuid';
        } 
        return $this->uuid_column;
    }
}