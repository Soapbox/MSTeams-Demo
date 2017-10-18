<?php

namespace App\Soapboxes;

use Illuminate\Database\Eloquent\Model;

class Soapbox extends Model
{
    protected $fillable = [
        'soapbox_id',
        'tenant_id',
        'slug'
    ];

    public function getSoapboxId(): int
    {
        return $this->soapbox_id;
    }

    public static function findByTenantId(string $tenantId): Soapbox
    {
        return Soapbox::where('tenant_id', $tenantId)->firstOrFail();
    }
}
