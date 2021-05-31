<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueIgnoreCase implements Rule
{
  /**
   * Create a new rule instance.
   *
   * @return void
   */
  private $table = null;
  private $idColumn = null;
  private $idValue = null;

  public function __construct(string $table, $idColumn = null, string $idValue = null)
  {
    //
    $this->table = $table;
    $this->idColumn = $idColumn;
    $this->idValue = $idValue;
  }

  /**
   * Determine if the validation rule passes.
   *
   * @param string $attribute
   * @param mixed $value
   * @return bool
   */
  public function passes($attribute, $value)
  {
    $reg = DB::table($this->table)
      ->where($attribute, "like", $value);

    if (isset($this->idColumn) && isset($this->idValue)){
      $reg = $reg->where($this->idColumn, "!=", $this->idValue);
    }
    $reg = $reg->get()->first();
    if (empty($reg)) return true;

    return false;
  }

  /**
   * Get the validation error message.
   *
   * @return string
   */
  public function message()
  {
    return ':attribute it is already been used';
  }
}
