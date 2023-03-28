<?php

namespace App\Observers;

use App\Enums\UserType;
use App\Models\Statistic;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class StatisticObserver
{
    public function creating(Model $model)
    {
        if ($model instanceof User && $model->user_type != UserType::superadmin()) {
            self::incrementCount($model->user_type. '_count', $model->created_at->format('Y-m-d'));
        } else {
            self::incrementCount(mb_strtolower(class_basename(get_class($model))) . '_count', $model->created_at->format('Y-m-d'));
        }
    }


    public function deleted(Model $model)
    {
        if ($model instanceof User && $model->user_type != UserType::superadmin()) {
            self::decrementCount($model->user_type. '_count', $model->created_at->format('Y-m-d'));
        } else {
            self::decrementCount(mb_strtolower(class_basename(get_class($model))) . '_count', $model->created_at->format('Y-m-d'));
        }
    }


    public static function incrementCount($key, $added_at): void
    {
        $statistic = Statistic::firstOrCreate(['key' => $key, 'added_at' => $added_at], ['value' => 0]);
        $statistic->increment('value');
    }

    public static function decrementCount($key, $added_at): void
    {
        Statistic::where(['key'=> $key, 'added_at' => $added_at])->decrement('value');
    }

}
