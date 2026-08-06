<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'], 'category' => ['required', 'string', 'max:100'],
            'summary' => ['required', 'string', 'max:2000'], 'content' => ['required', 'string'],
            'author_name' => ['required', 'string', 'max:255'], 'author_role' => ['required', 'string', 'max:255'],
            'read_time' => ['required', 'integer', 'min:1', 'max:999'], 'published_at' => ['required', 'date'],
            'featured_image' => ['required', 'image', 'max:5120'], 'author_profile_image' => ['required', 'image', 'max:5120'],
            'is_featured' => ['nullable', 'boolean'], 'sections' => ['nullable', 'array', 'max:5'],
            'sections.*.image' => ['nullable', 'image', 'max:5120'], 'sections.*.title' => ['nullable', 'string', 'max:255'],
            'sections.*.message' => ['nullable', 'string', 'max:5000'], 'sections.*.sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
