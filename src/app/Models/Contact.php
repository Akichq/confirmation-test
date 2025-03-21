<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'first_name',
        'last_name',
        'gender',
        'email',
        'tel',
        'address',
        'building',
        'detail',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeName($query, $str)
    {
        if (empty($str)) {
            return;
        }
        $query->where(function ($q) use ($str) {
            $q->where('first_name', 'like', '%' . $str . '%')
                ->orWhere('last_name', 'like', '%' . $str . '%');
        });
    }

    public function scopeGender($query, $gender)
    {
        if (empty($gender) || $gender === '0') {
            return;
        }
        $query->where('gender', $gender);
    }

    public function scopeEmail($query, $str)
    {
        if (empty($str)) {
            return;
        }
        $query->where('email', 'like', '%' . $str . '%');
    }

    public function scopeCategory($query, $category_id)
    {
        if (empty($category_id) || $category_id === '0') {
            return;
        }
        $query->where('category_id', $category_id);
    }

    public function scopeCreatedBetween($query, $from, $until)
    {
        if (empty($from) && empty($until)) {
            return;
        }
        if (empty($from)) {
            $query->whereDate('created_at', '<=', $until);
        } elseif (empty($until)) {
            $query->whereDate('created_at', '>=', $from);
        } else {
            $query->whereBetween('created_at', [$from, $until]);
        }
    }
    public function getFullNameAttribute()
    {
        return $this->last_name . ' ' . $this->first_name;
    }
}