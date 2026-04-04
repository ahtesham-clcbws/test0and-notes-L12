<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gn_PackageTransaction extends Model
{
    use HasFactory;

    /**
     * Get the plan associated with the transaction.
     */
    public function plan(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Gn_PackagePlan::class, 'plan_id');
    }
}
