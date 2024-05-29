<?php

namespace App\Enums;

use MyCLabs\Enum\Enum;

final class TypeAlertEnum extends Enum
{
    const imprecise_course = 'Parcours imprécis';
    const step_inaccessible = 'Une ou plusieurs étapes inaccessible(s)';
    const shocking_content = 'Contenu choquant';
    const other = 'Autre';
}
