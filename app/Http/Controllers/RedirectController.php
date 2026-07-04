<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\LinkService;
use Illuminate\Http\RedirectResponse;

class RedirectController extends Controller
{
    public function __construct(
        private readonly LinkService $linkService,
    ) {
    }

    /**
     * @param string $shortCode
     * @return RedirectResponse
     */
    public function __invoke(string $shortCode): RedirectResponse
    {
        return redirect()->away(
            $this->linkService->resolve($shortCode),
        );
    }
}