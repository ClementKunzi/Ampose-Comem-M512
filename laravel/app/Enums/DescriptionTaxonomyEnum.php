<?php

namespace App\Enums;

use MyCLabs\Enum\Enum;

final class DescriptionTaxonomyEnum extends Enum
{
    const architectural_description = 'Exploration Architecturale : Parcours mettant en avant les édifices et monuments architecturaux significatifs.';
    const gastronomic_description = 'Découverte Culinaire : Sentiers centrés sur la gastronomie locale, incluant visites de restaurants, marchés et dégustations.';
    const history_description = 'Voyage dans le Temps : Parcours retraçant des événements historiques marquants et des sites patrimoniaux.';
    const natural_description = 'Immersion Naturelle : Balades à travers les paysages naturels, parcs et réserves du canton.';
    const artistic_description = "Pérégrination Artistique : Sentiers dédiés à l'art\, incluant des musées\, galeries et œuvres d\'art public.";
    const literary_description = 'Promenade Littéraire : Parcours inspirés par des œuvres littéraires ou des écrivains locaux.';
    const religious_description = 'Sentier Spirituel : Balades autour des lieux de culte, églises, abbayes et sites religieux.';
    const industrial_description = 'Héritage Industriel : Exploration des anciens sites industriels, usines et technologies locales.';
    const botany_description = 'Circuit Botanique : Sentiers à travers jardins botaniques, parcs fleuris et réserves de biodiversité.';
    const oenological_description = 'Route des Vins : Parcours à travers les vignobles et caves, avec dégustation de vins locaux.';
    const suitable_for_children_description = 'Adapté pour les Familles : Sentiers sécurisés et faciles, idéaux pour les familles avec de jeunes enfants.';
    const weelchair_accessible = 'Accessibilité PMR : Parcours adaptés pour les personnes à mobilité réduite, sans obstacles et avec des surfaces appropriées.';
    const doable_by_bike = "Cyclisme Autorisé : Sentiers permettant l'accès et la pratique du vélo, avec des pistes bien entretenues.";
    const nocturne = 'Balade Nocturne : Sentiers praticables la nuit, souvent éclairés ou sécurisés pour une exploration après la tombée de la nuit.';
    const pets_allowed = 'Animaux Acceptés : Parcours où les animaux de compagnie sont les bienvenus, avec des zones adaptées pour eux.';
}
