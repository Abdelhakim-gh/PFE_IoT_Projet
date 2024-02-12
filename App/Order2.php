<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\OrderDetail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Order2 extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $table = 'orders';

    protected static function booted(): void
    {

        static::addGlobalScope('orders2', function (Builder $builder) {
            $builder->whereType(20);
        });

        static::addGlobalScope('orders', function (Builder $builder) {
            $showday = false;
            try {
                $showday = DB::table('user_roles')->whereUserId(Auth::user()->id ?? 0)->whereRoleId(5)->exists();
            } catch (\Throwable $th) {
            }
            if ($showday) $builder->where('created_at', '>', now()->subDay()->setTime(23, 59));
        });
    }
}
