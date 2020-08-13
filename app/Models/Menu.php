<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['user_id', 'name', 'status'];

    public function content()
    {
        return $this->hasMany(Content::class, 'menu_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
