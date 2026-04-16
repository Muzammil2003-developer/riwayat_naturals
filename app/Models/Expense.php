<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['title', 'amount', 'description', 'category', 'expense_date'];
    
    protected $casts = [
        'amount' => 'decimal:2',
        'expense_date' => 'date',
    ];
    
    public static function categories()
    {
        return ['salary', 'rent', 'utilities', 'marketing', 'supplies', 'other'];
    }
}