<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseChoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'response_id',
        'choice_id',
    ];

    public function response()
    {
        return $this->belongsTo(Response::class);
    }

    public function choice()
    {
        return $this->belongsTo(Choice::class);
    }
}
