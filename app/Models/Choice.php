<?php

// app/Models/Choice.php

// app/Models/Choice.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'choice_text',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function responseChoices()
    {
        return $this->hasMany(ResponseChoice::class);
    }
}
