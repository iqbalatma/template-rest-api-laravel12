<?php

namespace App\Enums;

use App\Enums\MetaProperties\Description;
use App\Enums\MetaProperties\FeatureGroup;
use ArchTech\Enums\Meta\Meta;
use ArchTech\Enums\Metadata;

/**
 * @method featureGroup
 * @method description
 */
#[Meta(Description::class, FeatureGroup::class)]
enum Permission: string {
    use Metadata;

    #[Description("can show data permission")] #[FeatureGroup("management - permission")]
    case MANAGEMENT_PERMISSION_SHOW = "management.permission.show";
}
