<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\LinkRepository;
use Illuminate\Support\Str;

final class ShortCodeGenerator
{
    public function __construct(
        private readonly LinkRepository $linkRepository,
    ) {
    }

    /**
     * @return string
     */
    public function generate(): string
    {
        do {
            $shortCode = Str::random(6);
        } while ($this->linkRepository->existsByShortCode($shortCode));

        return $shortCode;
    }
}