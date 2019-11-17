<?php

namespace Froala\NovaFroalaField;

use Laravel\Nova\Nova;

function nova_version_higher_then(string $version)
{
    return version_compare(Nova::version(), $version) === 1;
}
