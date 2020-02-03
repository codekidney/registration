<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgrammingLanguages extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
    
    /**
     * The users that belong to the language.
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }    
}
