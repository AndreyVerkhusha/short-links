<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\LinkClickRepository;
use App\Repositories\LinkRepository;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RedirectService
{
    public function __construct(
        private readonly LinkRepository $linkRepository,
        private readonly LinkClickRepository $linkClickRepository,
    ) {
    }

    /**
     * @param string $shortCode
     * @return RedirectResponse
     */
    public function redirect(string $shortCode): RedirectResponse
    {
        $link = $this->linkRepository->findByShortCode($shortCode);

        if ($link === null) {
            throw new NotFoundHttpException();
        }

        $this->linkClickRepository->create(
            $link,
            request()->ip() ?? '0.0.0.0',
        );

        return redirect()->away($link->original_url);
    }
}