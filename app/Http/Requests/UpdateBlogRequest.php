<?php

namespace App\Http\Requests;

class UpdateBlogRequest extends StoreBlogRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        $rules['featured_image'][0] = 'nullable';
        $rules['author_profile_image'][0] = 'nullable';
        $rules['existing_sections'] = ['nullable', 'array']; // max:5 ကို ဖြုတ်လိုက်ပါပြီ
        $rules['existing_sections.*.id'] = ['required', 'integer', 'exists:blog_sections,id'];
        $rules['existing_sections.*.title'] = ['nullable', 'string', 'max:255'];
        $rules['existing_sections.*.message'] = ['nullable', 'string', 'max:5000'];
        $rules['existing_sections.*.sort_order'] = ['nullable', 'integer', 'min:0'];
        $rules['existing_sections.*.image'] = ['nullable', 'image', 'max:102400']; // 100MB အထိ
        $rules['existing_sections.*.delete'] = ['nullable', 'boolean'];
        $rules['existing_sections.*.remove_image'] = ['nullable', 'boolean'];
        return $rules;
    }
}