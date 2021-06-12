<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Post extends Model
{
  use HasFactory, Notifiable;
  use SoftDeletes;


  protected $fillable = [
    "title", "content", "image", "id_user"
  ];


  public function user()
  {
    return $this->belongsTo(User::class, "id_user", "id");
  }

  protected static function boot()
  {
    parent::boot();

    self::saving(function (Post $model) {


    });
  }
}
