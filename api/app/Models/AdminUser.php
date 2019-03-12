<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use BenBjurstrom\EloquentPostgresUuids\HasUuid;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class AdminUser extends Authenticatable
{
    use Notifiable, HasUuid, HasRoles;
    //
}
