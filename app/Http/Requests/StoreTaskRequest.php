<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'image' => '',
            'name' => ['sometimes', 'required', 'string'],
            'description' => ['sometimes', 'required', 'string'],
            'user_id' => ['nullable', 'integer', 'min:1', 'exists:users,id'],
            'assignee_id' => ['nullable', 'integer', 'min:1', 'exists:users,id'],
            'status_id' => ['nullable', 'integer', 'min:1', 'exists:status,id'],
            'project_id' => ['nullable', 'integer', 'min:1', 'exists:projects,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date','after_or_equal:start_date'],
        ];
    }
}
