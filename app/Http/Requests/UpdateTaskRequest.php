<?php

// namespace App\Http\Requests;

// use Illuminate\Foundation\Http\FormRequest;

// class UpdateTaskRequest extends FormRequest
// {
//     /**
//      * Determine if the user is authorized to make this request.
//      *
//      * @return bool
//      */
//     public function authorize(): bool
//     {
//         return false;
//     }

//     /**
//      * Get the validation rules that apply to the request.
//      *
//      * @return array<string, mixed>
//      */
//     public function rules(): array
//     {
//         return [
//             'title'       => ['sometimes','required','string','min:5'],
//             'description' => ['sometimes','nullable','string','max:500'],
//             'status'      => ['sometimes','required','in:'.implode(',', Task::statuses())],
//             // user_id NO se actualiza en este ejercicio.
//         ];
//     }
// }



namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // 👈 ¡IMPORTANTE!
    }

    public function rules(): array
    {
        return [
            'title'       => ['sometimes','required','string','min:5'],
            'description' => ['sometimes','nullable','string','max:500'],
            'status'      => ['sometimes','required','in:'.implode(',', Task::statuses())],
        ];
    }
}
