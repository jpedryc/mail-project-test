<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'mail_id',
        'filename',
        'content',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function mail()
    {
        return $this->belongsTo(Mail::class);
    }
}
