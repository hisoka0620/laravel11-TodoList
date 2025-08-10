<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:not_started,in_progress,pending,completed',
            'priority' => 'required|in:none,low,medium,high',
            'due_date' => 'date|nullable',
        ];
    }
}
