<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    use HasFactory;

    protected $fillable = [
        'to',
        'subject',
        'body',
        'send_at',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'send_at' => 'datetime',
    ];

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
}
