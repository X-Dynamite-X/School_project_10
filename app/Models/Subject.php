<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'subject_code',
        'success_mark',
        'full_mark',

    ];
    public function users()
    {
        return $this->belongsToMany(User::class, 'subject_users')->withPivot('mark');
    }


}
