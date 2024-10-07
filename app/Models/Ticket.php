<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = ['number', 'client_id', 'departament_id', 'type', 'status'];

    public function client(): BelongsTo
    {
        return $this->BelongsTo(Client::class);
    }
    public function departament(): BelongsTo
    {
        return $this->BelongsTo(Departament::class);
    }
}
