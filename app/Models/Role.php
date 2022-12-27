<?php

namespace App\Models;
use Spatie\Permission\Models\Role as OriginalRole;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends OriginalRole
{
    use SoftDeletes; 
}
