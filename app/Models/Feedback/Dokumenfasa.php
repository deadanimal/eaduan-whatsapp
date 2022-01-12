<?php

namespace App\Models\Feedback;

use Illuminate\Database\Eloquent\Model;

class Dokumenfasa extends Model
{
    protected $fillable = [
        'nama_fail',
        'laluan_fail',
        'saiz',
    ];
}
