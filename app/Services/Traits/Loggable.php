<?php

namespace App\Services\Traits;

use Illuminate\Support\Facades\DB;

trait Loggable
{
    static protected $logTable = 'logs';

    static function logToDb($model, $logType)
    {
        $updatedData = $title = $userId = $adminUserId = $tableId= null;
        $tableName = $model->getTable();
        if (!auth()->check() || $model->excludeLogging || !config('custom-log.activated', true)) return;
        if ($logType == 'create')
        {
            $originalData = json_encode($model);
            $title = buildTableNameToLogInfoTitle($tableName).' created.';
        }
        else {
            if (version_compare(app()->version(), '7.0.0', '>='))
            {
                $originalData = json_encode($model->getRawOriginal()); // getRawOriginal available from Laravel 7.x
                $tableId = $model->getRawOriginal()['id'];
            }
            else
            {
                $originalData = json_encode($model->getOriginal());
                $tableId = $model->getRawOriginal()['id'];
            }

            $title = buildTableNameToLogInfoTitle($tableName).' updated.';
            $updatedData = json_encode($model->getChanges());
        }


        $dateTime = date('Y-m-d H:i:s');



        if(auth()->guard('user')->check())
            $userId = auth()->guard('user')->user()->id;

         if(auth()->guard('admin')->check())
             $adminUserId = auth()->guard('admin')->user()->id;

        DB::table(self::$logTable)->insert([
            'title'    => $title,
            'user_id'    => $userId,
            'admin_user_id'    => $adminUserId,
            'log_date'   => $dateTime,
            'table_name' => $tableName,
            'table_id' => $tableId,
            'log_type'   => $logType,
            'before_data'       => $originalData,
            'after_data'       => $updatedData,
        ]);
    }

    public static function bootLoggable()
    {
        if (config('custom-log.log_events.on_edit', false)) {
            self::updated(function ($model) {
                self::logToDb($model, 'edit');
            });
        }


        if (config('custom-log.log_events.on_delete', false)) {
            self::deleted(function ($model) {
                self::logToDb($model, 'delete');
            });
        }


        if (config('custom-log.log_events.on_create', false)) {
            self::created(function ($model) {
                self::logToDb($model, 'create');
            });
        }
    }
}
