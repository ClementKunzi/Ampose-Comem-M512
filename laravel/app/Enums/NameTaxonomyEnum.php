<?php

namespace App\Enums;

use MyCLabs\Enum\Enum;

final class NameTaxonomyEnum extends Enum
{
    const architectural = 'Architectural';
    const gastronomic = 'Gastronomique';
    const history = 'Historique';
    const natural = 'Naturel';
    const artistic = 'Artistique';
    const literary = 'Littéraire';
    const religious = 'Religieux';
    const industrial = 'Industriel';
    const botany = 'Botanique';
    const oenological = 'Oenologique';
    const suitable_for_children = 'Convient aux enfants';
    const weelchair_accessible = 'Accessible aux fauteuils roulants';
    const doable_by_bike = 'Faisable à vélo';
    const nocturne = 'Nocturne';
    const pets_allowed = 'Animaux autorisés';
}
