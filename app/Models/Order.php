<?php

namespace CodeFlix\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Order extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'user_id',
        'code',
        'value'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
