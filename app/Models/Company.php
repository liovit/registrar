<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Worker;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'email',
        'web_url',
        'logo',
    ];

    // get workers of company
    public function workers() {
        return $this->hasMany(Worker::class);
    }

}
