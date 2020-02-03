<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProgrammingLanguagesUser extends Pivot
{
    protected $table = 'user_programming_languages';
}
