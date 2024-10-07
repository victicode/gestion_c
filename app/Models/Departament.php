<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departament extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name','type','correlativo', 'limit'];

    public function allTickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
    public function ticketsByDay(): HasMany
    {
        return $this->hasMany(Ticket::class)
        ->whereDate('created_at', '=' , date('Y-m-d'))
        ->whereTime('created_at', '<', '23:59:59');
    }
    public function ticketsPending(): HasMany
    {
        return $this->hasMany(Ticket::class)
        ->where('status','!=',0)
        ->whereDate('created_at', '=' , date('Y-m-d'))
        ->whereTime('created_at', '<', '23:59:59');

    }   
}
