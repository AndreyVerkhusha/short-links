<?php

declare(strict_types=1);

namespace App\DTO;

final class StoreLinkDto
{
    public function __construct(
        public int $userId,
        public string $originalUrl,
    ) {}
}
