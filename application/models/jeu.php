<?php
function script(Equipe $equipe) {
    /*
     * [atouts] => Array()
     * [persos] => Array()
     * 
     */

    $modifs=array();

    foreach($perso['competences'] as $key=>$value) {
        //"finesse +5; machin -4"
        $tab=explode(';',$value);
        foreach($tab as $key2=>$value2) {
            $m=explode(' ',$value2);
            $modifs[$m[0]]=$m[1];
        }
    }

    foreach($perso['equipement'] as $key=>$value) {
        //"finesse +5; machin -4"
        $tab=explode(';',$value);
        foreach($tab as $key2=>$value2) {
            $m=explode(' ',$value2);
            $modifs[$m[0]]=$m[1];
        }
    }

    foreach($modifs as $key=>$value) {
        $perso[$key]+=$value;
    }
    return $perso;
}

function recrutement($lieu_actuel,$compte) {
    $compte_id=$compte->id;
    $lieu=$lieu_actuel['nom'];

    return TableMerco::getMercos(array("compte_id"=>$compte_id,"lieu_recrutement"=>$lieu));
}

function getEquipe($compte) {
    $compte_id=$compte->id;
    return TableMerco::getEquipe(array("compte_id"=>$compte_id));
}

function convertMoral($n) {
    if($n<100) return "Rebelle";
    else if($n<250) return "Maussade";
    else if($n<900) return "Normal";
    else if($n<1000) return "Volontaire";
    else return "Erreur";
}

function convertFaction($s) {
    switch($s) {
        case 'fed':
            return "Fédération";
            break;
        case 'log':
            return "Logres";
            break;
        case 'maw':
            return "Fils de Mawsse";
            break;
        case 'mag':
            return "Magomiquets";
            break;
        case 'mec':
            return "Méchamiquets";
            break;
        default:
            return "Erreur";
            break;
    }
}

function convertSante($n) {
    switch($n) {
        case 0:
            return "Normal";
            break;
        case -1:
            return "Blessure";
            break;
        case -2:
            return "Décès";
            break;
        default:
            return "Erreur";
            break;
    }
}

function convertTypeMission($n) {
    switch($n) {
        case 1:
            return "Pillage";
            break;
        case 2:
            return "Capture";
            break;
        case 3:
            return "Assassinat";
            break;
        case 4:
            return "Bataille";
            break;
        case 5:
            return "Reconnaissance";
            break;
        case 6:
            return "Enquête";
            break;
        default:
            return "Erreur";
            break;
    }
}

function acheterMercenaire($id,$compte) {
    TableMerco::acheterMerco($id,$compte);
}

function renvoyerMercenaire($id) {
    TableMerco::renvoyerMerco($id);
}

function generationMission($lieu_actuel,$compte) {
    $n=mt_rand(1,6);
    $compte=new Compte(array('id'=>1,'argent'=>10000));
    $lieu['nom']='Barbesse';
    $lieu['faction']='fed';
    $equipe=getEquipe($compte);
    if($equipe) {
        switch($n) {
            case 1:
                $t="Pillage";
                $att='brutalite';
                $modificateur_butin=3;
                $modificateur_reput=-0.5;
                $xp=mt_rand(1,2);
                $letalite=mt_rand(0,2);
                break;
            case 2 :
                $t="Capture";
                $att='brutalite';
                $modificateur_butin=3;
                $modificateur_reput=-0.5;
                $xp=mt_rand(1,2);
                $letalite=mt_rand(0,2);
                break;
            case 3 :
                $t="Assassinat";
                $att='finesse';
                $modificateur_butin=2.5;
                $modificateur_reput=-0.25;
                $xp=mt_rand(2,3);
                $letalite=mt_rand(0,1);
                break;
            case 4 :
                $t="Bataille";
                $att='discipline';
                $modificateur_butin=2.5;
                $modificateur_reput=0.25;
                $xp=mt_rand(2,3);
                $letalite=mt_rand(0,2);
                break;
            case 5 :
                $t="Reconnaissance";
                $att='discipline';
                $modificateur_butin=2;
                $modificateur_reput=0.5;
                $xp=mt_rand(0,2);
                $letalite=mt_rand(-1,0);
                break;
            case 6 :
                $t="Enquête";
                $att='finesse';
                $modificateur_butin=2;
                $modificateur_reput=0.5;
                $xp=mt_rand(0,1);
                $letalite=mt_rand(-2,0);
                break;
        }
        foreach($equipe as $key => $value) {
            $stats[]=$value[$att];
        }
        $comp=calculComp($stats);

        $mission['difficulte']=mt_rand($comp-18-2*count($stats),$comp+42-2*count($stats));

        $difficulte=$mission['difficulte'];

        $reput=$difficulte*$modificateur_reput;

        $modificateur_xp=floor($difficulte/100)-1;
        if($modificateur_xp<0)$modificateur_xp=0;
        $xp+=$modificateur_xp;

        $temps=$difficulte;

        $s="<strong>";
        if($difficulte <= $comp-20) $s.="très facile";
        else if($difficulte <= $comp-10) $s.="facile";
        else if($difficulte <= $comp+10) $s.="normale";
        else if($difficulte <= $comp+20) $s.="difficile";
        else if($difficulte <= $comp+30) $s.="très difficile";
        else if($difficulte <= $comp+40) $s.="infernale";
        $s.="</strong>";

        $mission=array('type'=>$n,'compte_id'=>$compte->id,'difficulte'=>$difficulte,'xp'=>$xp,'letalite'=>$letalite);
        $id=TableMerco::createMission($mission);

        $mission['id']=$id;
        $mission['s']=$s;
        return $mission;
    }
    else echo "trouve-toi une équipe";
}

function generationMerco($lieu_actuel,$compte) {
    $compte_id=$compte->id;
    $lieu=$lieu_actuel['faction'];
    
    $hasard=mt_rand(1,100);
    if(($lieu=='log' || $lieu=='fed') && $hasard<=70) $origine=$lieu;
    else if($hasard<=60) $origine=$lieu;
    else if($lieu=='fed') {
        if($hasard<=89) $origine='log';
        else if($hasard<=98) $origine='maw';
        else if($hasard<=99) $origine='mag';
        else if($hasard<=100) $origine='mec';
    }
    else if($lieu=='log') {
        if($hasard<=70+20) $origine='fed';
        else if($hasard<=70+20+3) $origine='maw';
        else if($hasard<=70+20+3+1) $origine='mag';
        else if($hasard<=70+20+3+1+1) $origine='mec';
    }
    else if($lieu=='mag') {
        if($hasard<=60+15) $origine='fed';
        else if($hasard<=60+25) $origine='mec';
        else if($hasard<=60+35) $origine='maw';
        else if($hasard<=100) $origine='log';
    }
    else if($lieu=='mec') {
        if($hasard<=60+15) $origine='mag';
        else if($hasard<=60+25) $origine='fed';
        else if($hasard<=60+35) $origine='maw';
        else if($hasard<=100) $origine='log';
    }
    else if($lieu=='maw') {
        if($hasard<=79) $origine='fed';
        else if($hasard<=98) $origine='mag';
        else if($hasard<=99) $origine='log';
        else if($hasard<=100) $origine='mec';
    }

    if($origine=='maw')$boost=10;
    else $boost=0;
    $brutalite=mt_rand(10,50+$boost);
    $finesse=mt_rand(10,50+$boost);
    $constitution=mt_rand(10,50+$boost);
    $discipline=mt_rand(10,50+$boost);

    if($origine=='fed') {
        $discipline+=mt_rand(1,20);
        $constitution-=mt_rand(1,10);
    }
    else if($origine=='log') {
        $constitution+=mt_rand(1,10);
        $discipline+=mt_rand(1,10);
        $finesse-=mt_rand(1,10);
    }
    else if($origine=='mag') {
        $brutalite+=mt_rand(1,20);
        $discipline-=mt_rand(1,10);
    }
    else if($origine=='mec') {
        $finesse+=mt_rand(1,20);
        $brutalite-=mt_rand(1,10);
    }



    if($origine!='maw') {
        if($brutalite<10)$brutalite=10;
        else if($brutalite>50)$brutalite=50;
        if($discipline<10)$discipline=10;
        else if($discipline>50)$discipline=50;
        if($constitution<10)$constitution=10;
        else if($constitution>50)$constitution=50;
        if($finesse<10)$finesse=10;
        else if($finesse>50)$finesse=50;
    }

    //Compétences aléatoires à faire
    //........

    $prix=round((pow(($brutalite+$finesse+$constitution+$discipline)/2,1.5))/2);
    $salaire=round($prix/10);

    if(mt_rand(0,1)) $s='m';
    else $s='f';

    if($origine=='fed' || $origine=='log') $fichier=fopen(dirname(__FILE__).'/noms_humains.txt','r');
    else $fichier=fopen(dirname(__FILE__).'/noms_miquets.txt','r');

    $prenoms_f=fgetcsv($fichier);
    $prenoms_m=fgetcsv($fichier);
    $noms=fgetcsv($fichier);

    if($s=='f')$prenom=$prenoms_f[array_rand($prenoms_f)];
    else $prenom=$prenoms_m[array_rand($prenoms_m)];
    $nom=$noms[array_rand($noms)];

    $avatar=$origine."_".mt_rand(1,3)."_".$s;

    return array('compte_id'=>$compte_id,'nom'=>"$prenom $nom",'brutalite'=>$brutalite,'finesse'=>$finesse,'constitution'=>$constitution,
        'discipline'=>$discipline,'engage'=>0,'lieu_recrutement'=>$lieu_actuel['nom'],'date_gen'=>time(),
        'origine'=>$origine,'prix'=>$prix,'salaire'=>$salaire,'moral'=>500,'sante'=>0,'avatar'=>$avatar);
}
?>