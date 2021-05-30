<?php

namespace App\Http\Requests;

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
    return [
      'title' => 'required|string|min:3|max:160',
      'content' => ['nullable', 'string', 'min:3' . 'max:10000'],
      'image' => 'nullable|image|max:2048',
    ];
  }
}
