<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $guarded = ['id'];

    public function staff() :BelongsTo
    {
        return $this->belongsTo(User::class, 'staff_id', 'id');
    }

    public function project() :BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
