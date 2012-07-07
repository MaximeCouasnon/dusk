<?php

/**
 * Retourne un nombre pseudo-aléatoire selon une loi normale de paramètres mu et sigma
 * @param mu moyenne (espérance mathématique) de la distribution
 * @param sigma écart-type de la distribution (doit être strictement positif)
 */
function loiNormale($mu, $sigma) {
    $deux_pi=6.2831853071796;

    $n1= mt_rand(1,999999)/1000000;
    $n2= mt_rand(1,999999)/1000000;
    $res=sqrt(-2 * log($n1)) * cos($deux_pi*$n2);

    return $mu+$sigma*$res;
}

function calculMu($diff,$comp) {
    // diff = comp => mu=0
    // diff >> comp => mu = 2 ; sigma=0.5
    // diff << comp => mu = -2 ; sigma=0.5

    // -2 < 1/($diff - $comp) < 2
    // 50 et 1 => mu= 2
    // 1 et 50 => mu= -2

    return $comp-$diff;
}

function calculComp(array $equipe) {
    /*
     * [0] => 23 (2)
     * [1] => 67 (6)
     * [2] => 26 (2)
     */

    $resultat=0;
    foreach($equipe as $key=>$value) {
        $resultat+=$value;
    }

    return $resultat;
}

?>
