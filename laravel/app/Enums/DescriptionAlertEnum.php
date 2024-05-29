<?php

namespace App\Enums;

use MyCLabs\Enum\Enum;

final class DescriptionAlertEnum extends Enum
{
    const imprecise_course_description = 'Signalisation Problématique : Difficultés à suivre le parcours en raison de signalisation insuffisante ou erronée.';
    const step_inaccessible_description = 'Accès Bloqué : Une ou plusieurs étapes du sentier sont inaccessibles en raison de travaux, obstacles ou autres raisons.';
    const shocking_content_description = "Inconvenance : Signalement de contenu inapproprié ou choquant rencontré sur le sentier ou l\’application.";
    const other_description = 'Divers : Tout autre type de problème ou incident ne correspondant pas aux catégories précédentes.';
}
