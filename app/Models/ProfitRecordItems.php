<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfitRecordItems extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'profit_record_id',
        'user_id',
        'profit_id',
        'name',
        'description',
        'value',
        'date',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
