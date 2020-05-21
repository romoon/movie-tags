<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movielist extends Model
{
  protected $table = 'movietags.movielist';
  protected $fillable = ['id', 'listname',  'taglist', 'user_id'];

  protected $guarded = array('id');

  public static $rules = array(
      'listname' => 'required',
      'taglist' => 'required',
      'user_id' => 'required',
  );

  public function movies()
  {
      return $this->belongsToMany('App\Models\Movie');
  }
}
