<?php

namespace App\Http\Requests;

use App\Rules\UniqueIgnoreCase;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreUpdatePost extends FormRequest
{

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    error_log("StoreUpdatePost: authorize");
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    $id = $this->segment(2);
    return [
      'title' => [
        "required", "string", "min:3", "max:160",
        new UniqueIgnoreCase("posts","id", $id),
      ],
      'content' => ['nullable', 'string', 'min:3' . 'max:10000'],
//      "id_user" => ['required', 'exists:users,id'],
      'image' => 'nullable|image|max:2048',
    ];
  }
}
