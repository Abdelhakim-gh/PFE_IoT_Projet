<?php

namespace App;

use App\OrderDetail;
use App\Neighborhood;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Order extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    protected $guarded = [];

    public function order_details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function neighborhood()
    {
        return $this->belongsTo(Neighborhood::class, 'neighborhoods_id');
    }

    protected static function booted(): void
    {
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
