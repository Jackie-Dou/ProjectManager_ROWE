<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'status_id', 'created_by_id'];

    public function creator(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'created_by_id');
    }

    public function tasks(): \Illuminate\Database\Eloquent\Relations\HasOneOrMany
    {
        return $this->hasMany('App\Models\Task');
    }
}
