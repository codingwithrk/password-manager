<?php

namespace App\Models;

use App\DTOs\PasswordDto;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Password extends Model
{
    use HasUuids;

    protected $fillable = [
        'application_name',
        'application_url',
        'ref_id',
        'secure_key',
    ];

    protected $hidden = [
        'secure_key',
    ];

    public static function CreateNewPassword(PasswordDto $passwordDto): void
    {
        self::create([
            'application_name' => $passwordDto->applicationName,
            'application_url' => $passwordDto->applicationUrl,
            'ref_id' => $passwordDto->refId,
            'secure_key' => $passwordDto->secureKey,
        ]);
    }

    public static function GetAllPasswords(): Collection
    {
        return self::latest()->get()->map(function (self $item) {
            return new PasswordDto(
                applicationName: $item->application_name,
                applicationUrl: $item->application_url,
                refId: $item->ref_id,
                secureKey: $item->secure_key,
                id: $item->id,
            );
        });
    }
}
