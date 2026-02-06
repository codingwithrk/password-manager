<?php

/**
 * @author : CodingwithRK
 * @created: 04/02/26
 */

declare(strict_types=1);

namespace App\DTOs;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

final readonly class PasswordDto implements Arrayable, JsonSerializable
{
    public function __construct(
        public string  $applicationName,
        public string  $applicationUrl,
        public string  $refId,
        public string  $secureKey,

        public ?string $id = null,
    )
    {
        //
    }

    /**
     * Convert the DTO to an array.
     */
    public function toArray(): array
    {
        return [
            'applicationName' => $this->applicationName,
            'applicationUrl' => $this->applicationUrl,
            'refId' => $this->refId,
            'secureKey' => $this->secureKey,
            'id' => $this->id,
        ];
    }

    /**
     * For JSON_encode() compatibility.
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}