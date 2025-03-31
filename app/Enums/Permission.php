<?php

namespace App\Enums;

use App\Enums\MetaProperties\Description;
use App\Enums\MetaProperties\FeatureGroup;
use ArchTech\Enums\Meta\Meta;
use ArchTech\Enums\Metadata;
use ArchTech\Enums\Values;

/**
 * @method featureGroup
 * @method description
 */
#[Meta(Description::class, FeatureGroup::class)]
enum Permission: string
{
    use Metadata, Values;

    #[Description("can show data permission")] #[FeatureGroup("management - permission")]
    case MANAGEMENT_PERMISSION_SHOW = "management.permission.show";

    #[Description("can show data role")] #[FeatureGroup("management - role")]
    case MANAGEMENT_ROLE_SHOW = "management.role.show";
    #[Description("can add new data role")] #[FeatureGroup("management - role")]
    case MANAGEMENT_ROLE_STORE = "management.role.store";
    #[Description("can delete data role")] #[FeatureGroup("management - role")]
    case MANAGEMENT_ROLE_DESTROY = "management.role.destroy";
}
