<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DTO\StoreLinkDto;
use App\Models\Link;
use App\Models\LinkClick;

class LinkRepository
{
    public function create(StoreLinkDto $dto, string $shortCode): Link
    {
        return Link::create([
            'user_id' => $dto->userId,
            'original_url' => $dto->originalUrl,
            'short_code' => $shortCode,
        ]);
    }

    public function incrementClicks(Link $link): void
    {
        LinkClick::create([
            'link_id' => $link->id,
            'ip_address' => request()->ip() ?? '',
        ]);
    }

    public function findByShortCode(string $shortCode): ?Link
    {
        /** @var Link|null $link */
        $link = Link::query()
            ->where('short_code', $shortCode)
            ->first();

        return $link;
    }

    public function existsByShortCode(string $shortCode): bool
    {
        return Link::query()
            ->where('short_code', $shortCode)
            ->exists();
    }
}
