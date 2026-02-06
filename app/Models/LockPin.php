<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class LockPin extends Model
{
    use HasUuids;

    protected $fillable = [
        'pin',
        'security_question',
        'security_answer',
    ];

    public static function checkForFirstRecord(): bool
    {
        return self::exists();
    }

    public static function getFirstRecord(): ?self
    {
        return self::first();
    }
}
