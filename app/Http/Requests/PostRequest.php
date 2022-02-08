<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function rules()
    {
        return [
			"title" => "required",
			"body" => "required",
			"status" => "nullable",
			"author" => "nullable",
            "hashtagIds" => "nullable|array"

        ];
    }

    public function authorize()
    {
        return true;
    }
}
