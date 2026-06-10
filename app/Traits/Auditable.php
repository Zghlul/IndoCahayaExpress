<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Request;

trait Auditable
{
    protected static function bootAuditable()
    {
        static::created(function ($model) {
            $model->logAudit('created', $model->getAttributes());
        });

        static::updated(function ($model) {
            $changes = $model->getChanges();
            if (!empty($changes)) {
                $model->logAudit('updated', $changes, $model->getOriginal());
            }
        });

        static::deleted(function ($model) {
            $model->logAudit('deleted', $model->getAttributes());
        });
    }

    protected function logAudit($event, $newData = [], $oldData = [])
    {
        ActivityLog::create([
            'user_id'     => auth()->id(),
            'action'      => strtoupper($event) . '_' . strtoupper(class_basename($this)),
            'description' => ucfirst($event) . ' ' . class_basename($this) . ' #' . $this->getKey(),
            'ip_address'  => Request::ip(),
            'user_agent'  => Request::userAgent(),
            'payload'     => [
                'event'    => $event,
                'model'    => get_class($this),
                'model_id' => $this->getKey(),
                'old'      => $oldData,
                'new'      => $newData,
            ],
        ]);
    }
}