<?php
require_once 'formIndex.php';
require_once 'formules.php';
require_once 'jeu.php';
require_once 'classes/compte.php';
require_once 'classes/equipe.php';
require_once 'classes/gestion.php';
require_once 'tables/equipe.php';

class IndexController extends Zend_Controller_Action
{
    public $titre="Dusk";
    
    public function init()
    {
        $this->view->titre=$this->titre;
    }

    public function indexAction()
    {
        /*$compte=new Compte(array('id'=>1,'argent'=>10000));

        echo "Bienvenue au magasin !<br />Vous avez ".$compte->argent." argent !";

        $lieu['nom']='Barbesse';
        $lieu['faction']='fed';

        $m=recrutement($lieu,$compte);
        if(!count($m)) {
            if(0) {
                for($i=0;$i<6;$i++) {
                    $m[]=new Merco(generationMerco($lieu, $compte));
                }
                TableMerco::createMercos($m);
                $m=recrutement($lieu,$compte);
            }
        }

        echo "<br />";echo "<br />";echo "<br />";
        echo "<table>";
        foreach($m as $key=>$value) {
            echo "<tr><td>";
            echo "<pre>";print_r($value);echo "</pre><br />";
            echo "<td><a href='".$this->view->url(array('controller'=>'index','action'=>'achat','id'=>$value['id']))."'>Engager ce mercenaire</a></td>";
            echo "</td></tr>";
        }
        echo "</table>";
        
        /*for($i=0;$i<6;$i++) {
            $mercos[]=new Merco(generationMerco($lieu,$compte));
        }

        TableMerco::createMercos($mercos);

        echo "<pre>";print_r($mercos);echo "</pre>";




        /*$merco=new Merco(TableMerco::getMerco(1));

        echo "<pre>";print_r($merco);echo "</pre>";

        /*$equipe=array($merco1,$merco2,$merco3);

        $mission=array(
            'type'=>'Pillage',
            'temps'=>120,
            'reputation'=>-50,
            'letalite'=>1,
            'moral'=>-10,
            'butin'=>'un nounours'
        );

        if($mission['type']=='Pillage') $stat='brutalite';
        foreach($equipe as $key => $value) {
            $stats[]=$value[$stat];
        }

        $comp=calculComp($stats);
        
        $mission['difficulte']=mt_rand($comp-18-2*count($stats),$comp+42-2*count($stats));

        $difficulte=$mission['difficulte'];

        $s="<strong>";
        if($difficulte <= $comp-20) $s.="très facile";
        else if($difficulte <= $comp-10) $s.="facile";
        else if($difficulte <= $comp+10) $s.="normale";
        else if($difficulte <= $comp+20) $s.="difficile";
        else if($difficulte <= $comp+30) $s.="très difficile";
        else if($difficulte <= $comp+40) $s.="de difficulté infernale";
        $s.="</strong>";

        echo "Type : <strong>".$mission['type']."</strong><br />";
        echo "Temps : <strong>".$mission['temps']."</strong><br />";
        echo "Réputation : <strong>".$mission['reputation']."</strong><br />";
        echo "Butin : <strong>".$mission['butin']."</strong><br />";
        echo "<br />Cette mission est $s";



        $mu=calculMu($difficulte,$comp);

        $resultat=loiNormale($mu,50);
        echo "<br />";
        if($resultat < -150) echo "Pitoyable...";
        else if($resultat < -100) echo "Indigne !";
        else if ($resultat < -50) echo "Mauvais !";
        else if ($resultat < 0) echo "Pas de chance...";
        else if ($resultat < 50) echo "Victoire basique...";
        else if ($resultat < 100) echo "Victoire assurée !";
        else if ($resultat < 150) echo "Victoire incroyable !";
        else if ($resultat > 150) echo "Victoire non-euclidienne";
        
        //Temps
        $stats=array();
        foreach($equipe as $key => $value) {
            $stats[]=$value['brutalite'];
        }
        $comp=calculComp($stats);
        $difficulte=mt_rand($comp-30,$comp+40);
        $resultat=loiNormale(calculMu($difficulte,$comp),50);
        if($resultat < -150) $mission['temps']+=45;
        else if($resultat < -100) $mission['temps']+=30;
        else if ($resultat < -50) $mission['temps']+=15;
        else if ($resultat < 0) $mission['temps']+=0;
        else if ($resultat < 50) $mission['temps']-=0;
        else if ($resultat < 100) $mission['temps']-=15;
        else if ($resultat < 150) $mission['temps']-=30;
        else if ($resultat > 150) $mission['temps']-=45;
        echo "<br />Temps final : ".$mission['temps']." minutes";

        //Létalité
        $stats=array();
        foreach($equipe as $key => $value) {
            $stats[]=$value['constitution'];
        }
        $comp=calculComp($stats);
        $difficulte=mt_rand($comp-30,$comp+40);
        $resultat=loiNormale(calculMu($difficulte,$comp),50);
        if($resultat < -150) $mission['letalite']+=3;
        else if($resultat < -100) $mission['letalite']+=2;
        else if ($resultat < -50) $mission['letalite']+=1;
        else if ($resultat < 0) $mission['letalite']+=0;
        else if ($resultat < 50) $mission['letalite']-=0;
        else if ($resultat < 100) $mission['letalite']-=1;
        else if ($resultat < 150) $mission['letalite']-=2;
        else if ($resultat > 150) $mission['letalite']-=3;

        $mission['letalite']=4;
        echo "<br />Blessures : ".$mission['letalite'];
        if($mission['letalite']<=count($stats)) {
            echo "<br />Il y a ";
            echo $mission['letalite']." blessé";
            if($mission['letalite']>1) echo "s";
        }
        
        if($mission['letalite']>count($stats)) {
            if($mission['letalite']<2*count($stats)) {
                echo "<br />Il y a ";
                echo ($mission['letalite']-count($stats))." mort";
                if($mission['letalite']-count($stats)>1) echo "s";

                if($mission['letalite']<2*count($stats)) {
                    echo " et ".(2*count($stats)-$mission['letalite'])." blessé";
                    if(2*count($stats)-$mission['letalite']>1) echo "s";
                }
            }
            else {
                echo "<br />Tous vos mercenaires sont morts !";
            }
        }
        



        /*$tab=array();
        for($i=0;$i<1000;$i++) {
            $tab[]=loiNormale($mu,50);
        }

        $victoires=0;
        $res=array('pitoyable'=>0,'indigne'=>0,'mauvais'=>0,'pas de chance'=>0, 'victoire basique'=>0, 'victoire assurée'=>0, 'victoire incroyable'=>0, 'ca existe pas'=>0);
        foreach ($tab as $key=>$value) {
            if($value < -150) $res['pitoyable']++;
            else if($value < -100) $res['indigne']++;
            else if ($value < -50) $res['mauvais']++;
            else if ($value < 0) $res['pas de chance']++;
            else if ($value < 50){
                $res['victoire basique']++; $victoires++;
            }
            else if ($value < 100) {
                $res['victoire assurée']++; $victoires++;
            }
            else if ($value < 150) {
                $res['victoire incroyable']++; $victoires++;
            }
            else if ($value > 150) {
                $res['ca existe pas']++; $victoires++;
            }
        }

        echo "<pre>"; print_r($res); echo "</pre>";
        echo "$victoires";








        /*$this->view->form1=new formConnexion();
        $this->view->form2=new formInscription();
        
        if($this->_request->isPost()) {
            $infos=$this->_request->getPost();
            if($this->view->form1->isValid($infos)) {

            }
        }*/
    }
}

