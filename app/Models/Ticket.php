<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
      'client_id',
      'status',
    ];

    public function client (): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function services ():BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'service_ticket')
            ->withPivot('quantite', 'prix_unitaire')
            ->withTimestamps();
    }

    public function getMontantTotalAttribute(): float
    {
        return $this->services->sum(function ($service) {
            return $service->pivot->prix_unitaire * $service->pivot->quantite;
        });
    }
}
