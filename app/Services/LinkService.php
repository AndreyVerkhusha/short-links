<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\StoreLinkDto;
use App\Models\Link;
use App\Repositories\LinkRepository;

class LinkService
{
    public function __construct(
        private readonly LinkRepository $linkRepository,
        private readonly ShortCodeGenerator $shortCodeGenerator,
    ) {}

    public function create(StoreLinkDto $dto): Link
    {
        $shortCode = $this->shortCodeGenerator->generate();

        return $this->linkRepository->create($dto, $shortCode);
    }

    public function resolve(string $shortCode): string
    {
        $link = $this->linkRepository->findByShortCode($shortCode);
        abort_if($link === null, 404);
        $this->linkRepository->incrementClicks($link);

        return $link->original_url;
    }
}
