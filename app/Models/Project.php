<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public function type(){
        return $this->belongsTo(Type::class);
    }

    protected $fillable = [
        'title',
        'type_id',
        'slug',
        'description',
        'start_date',
        'end_date',
        'status',
        'project_url',
        'technologies'
    ];

    protected $casts =  [
        'start_date' => 'datetime:d/m/Y',
        'end_date' => 'datetime:d/m/Y',
        'created_at' => 'datetime:d/m/Y',
        'updated_at' => 'datetime:d/m/Y',
    ];
}
