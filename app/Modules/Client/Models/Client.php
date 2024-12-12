<?php

namespace App\Modules\Client\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }
}
