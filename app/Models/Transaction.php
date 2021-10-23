<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['total', 'notes', 'date', 'type', 'category_id', 'state_id', 'timing_id', 'method_id', 'created_at'];

    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function timing()
    {
        return $this->belongsTo(Timing::class);
    }

    public function method()
    {
        return $this->belongsTo(Method::class);
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class);
    }
}
