<?php

namespace App\Traits;

use App\Activity;

trait RecordsActivity 
{
    protected static function bootRecordsActivity()
    {
        if (auth()->guest()) return ;
        
        foreach (static::getRecordEvents() as $event) {
            static::$event(function($model) use ($event) {
                $model->recordActivity($event);
            });
        }

        static::deleting(function($model) {
            $model->activity()->delete();
        });
    }

    protected function recordActivity(String $event)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $event,
        ]);
    }

    protected static function getRecordEvents()
    {
        return ['created'];
    }

    // protected function getActivityType($event)
    // {
    //     $type = strtolower((new \ReflectionClass($this))->getShortName());
    //     return "{$event}_{$type}";
    // }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}