<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';

    protected $guarded = ['id'];

    public function manager() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function team() :BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function tasks() :HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function discussion() :HasMany
    {
        return $this->hasMany(UserProjectActivity::class);
    }
}
