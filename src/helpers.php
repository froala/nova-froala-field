<?php

namespace Froala\NovaFroalaField;

use Laravel\Nova\Nova;

function nova_version_at_least(string $version)
{
    return version_compare(Nova::version(), $version) >= 0;
}
