<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;

class Machine extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected static function booted(): void
    {
        static::addGlobalScope('addGlobalScope', function (Builder $builder) {
            $is_admin = false;
            try {
                $is_admin = Auth::user()->id == 1;
            } catch (\Throwable $th) {
            }
            if (!$is_admin && Auth::user() != null) $builder->where('user_id', Auth::user()->id ?? 0);
        });
    }
    
}
