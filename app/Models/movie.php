<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $guarded = array('id');

    public static $rules = array(
        'movieurl' => 'required',
        'user_id' => 'required',
    );

    public function user()
      {
        return $this->belongsTo('App\User');
      }
}
