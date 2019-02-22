<?php

namespace App\Models;

use BenBjurstrom\EloquentPostgresUuids\HasUuid;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasUuid;
}
