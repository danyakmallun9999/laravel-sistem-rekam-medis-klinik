<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

trait Auditable
{
    public static function bootAuditable()
    {
        static::created(function ($model) {
            self::logAudit('created', $model);
        });

        static::updated(function ($model) {
            self::logAudit('updated', $model);
        });

        static::deleted(function ($model) {
            self::logAudit('deleted', $model);
        });
    }

    protected static function logAudit($action, $model)
    {
        if (Auth::check()) {
            AuditLog::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'model' => class_basename($model),
                'model_id' => $model->id,
                'changes' => $action === 'updated' ? $model->getChanges() : $model->toArray(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        }
    }
}
