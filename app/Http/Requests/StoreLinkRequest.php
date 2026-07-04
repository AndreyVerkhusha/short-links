<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\DTO\StoreLinkDto;
use Illuminate\Foundation\Http\FormRequest;

class StoreLinkRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'original_url' => [
                'required',
                'string',
                'max:2048',
                'url',
            ],
        ];
    }

    /**
     * @return StoreLinkDto
     */
    public function toDto(): StoreLinkDto
    {
        return new StoreLinkDto(
            userId: $this->user()?->id,
            originalUrl: $this->validated()['original_url'],
        );
    }
}