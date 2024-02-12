<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Config extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;
}
