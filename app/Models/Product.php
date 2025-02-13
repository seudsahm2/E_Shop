<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Events\LowStockNotification;
use App\Models\Notification;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'cost',
        'image',
        'description',
        'quantity',
        'category_id',
        'brand_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class);
    }

    public function updateQuantity($quantity)
    {
        $this->quantity = $quantity;
        $this->save();

        if ($this->quantity < 3) {
            event(new LowStockNotification($this));
        } else {
            Notification::where('product_id', $this->id)
                ->where('type', 'low_stock')
                ->update(['is_read' => true]);
        }
    }
}
