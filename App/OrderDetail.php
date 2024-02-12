<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use App\Order;


class OrderDetail extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    protected static function booted(): void
    {
        static::saving(function (OrderDetail $OrderDetail) {
            try {
                $OrderDetail->price = $OrderDetail->product->price ?? null;
                $OrderDetail->total = $OrderDetail->price * $OrderDetail->qte;
                $OrderDetail->libelle = ($OrderDetail->product->category->name ?? '')  . ' - ' . ($OrderDetail->product->name ?? '') . ' * ' . ($OrderDetail->qte ?? 0) . ' => ' . ($OrderDetail->total ?? 0) . ' DH';
            } catch (\Throwable $th) {
            }
        });

        static::saved(function (OrderDetail $OrderDetail) {
            try {
                $OrderDetail->order->total = collect($OrderDetail->order->order_details ?? [])->sum('total') * 0.05;
                $OrderDetail->order->save();
            } catch (\Throwable $th) {
            }
        });

        static::deleted(function (OrderDetail $OrderDetail) {
            try {
                $OrderDetail->order->total = collect($OrderDetail->order->order_details ?? [])->sum('total') * 0.05;
                $OrderDetail->order->save();
            } catch (\Throwable $th) {
            }
        });
    }
}
