<?php

namespace App\Models;

use App\Enums\Table;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string id
 * @property string name
 * @property string guard_name
 * @property string is_mutable
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Role extends \Spatie\Permission\Models\Role
{
    use HasUuids;

    protected $table = Table::roles->name;

    protected $fillable = [
        "name", "guard_name", "is_mutable"
    ];
}
