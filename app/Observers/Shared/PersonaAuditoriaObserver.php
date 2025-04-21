<?php

namespace App\Observers\Shared;

use App\Traits\AuditoriaTrait;
use Illuminate\Database\Eloquent\Model;

class PersonaAuditoriaObserver
{
    use AuditoriaTrait;
    /**
     * Handle the Model "created" event.
     *
     * @param  \App\Models\Model  $model
     * @return void
     */
    public function created(Model $model)
    {
        $this->store($model, 'INSERT', $model);
    }

    /**
     * Handle the Model "updated" event.
     *
     * @param  \App\Models\Model  $model
     * @return void
     */
    public function updated(Model $model)
    {
        if ($model->isDirty()) {
            $this->store($model, 'UPDATE', $model->getChanges());
        }
    }
}
