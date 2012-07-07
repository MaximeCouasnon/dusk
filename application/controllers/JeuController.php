<?php
require_once 'formIndex.php';
require_once 'formules.php';
require_once 'jeu.php';
require_once 'classes/compte.php';
require_once 'classes/equipe.php';
require_once 'classes/gestion.php';
require_once 'tables/equipe.php';
class JeuController extends Zend_Controller_Action
{
    public $titre="Dusk";
    
    public function init()
    {
        $this->view->titre=$this->titre;
    }

    public function indexAction()
    {
        $this->view->map="B2";
        $this->view->avatar="essai";
    }

    public function missionAction()
    {
        $this->view->avatar="essai";
        $compte=new Compte(array('id'=>1,'argent'=>10000));

        $lieu['nom']='Barbesse';
        $lieu['faction']='fed';

        $id=$this->_request->getParam('id',0);
        if($id) {
            TableMerco::getMission($id);
        }
    }

    public function recrutementAction()
    {
        $this->view->avatar="essai";
        $compte=new Compte(array('id'=>1,'argent'=>10000));

        $lieu['nom']='Barbesse';
        $lieu['faction']='fed';

        $m=recrutement($lieu,$compte);
        if(!count($m)) {
            //if(0) { A faire
                for($i=0;$i<6;$i++) {
                    $m[]=new Merco(generationMerco($lieu, $compte));
                }
                TableMerco::createMercos($m);
                $m=recrutement($lieu,$compte);
            //}
        }
        $this->view->equipe=$m;

        /*for($i=0;$i<6;$i++) {
            $mercos[]=new Merco(generationMerco($lieu,$compte));
        }

        TableMerco::createMercos($mercos);*/
    }

    public function equipeAction()
    {
        $this->view->avatar="essai";
        $compte=new Compte(array('id'=>1,'argent'=>10000));
        $lieu['nom']='Barbesse';
        $lieu['faction']='fed';
        $this->view->equipe=getEquipe($compte);
    }

    public function achatAction() {
        $compte=new Compte(array('id'=>1,'argent'=>10000));
        $lieu['nom']='Barbesse';
        $lieu['faction']='fed';

        $id=$this->_getParam('id',0);
        if($id!=0) {
            $m=TableMerco::getMerco($id);
            if($m) {
                if($m['lieu_recrutement']==$lieu['nom']
                        && $m['compte_id']==$compte->id
                        && $m['prix']<=$compte->argent
                        && $m['date_gen']>=(time()-86400))
                    acheterMercenaire($id,$compte);
            }
        }
        $this->_redirect("/jeu/recrutement");
    }

    public function renvoiAction() {
        $compte=new Compte(array('id'=>1,'argent'=>10000));
        $lieu['nom']='Barbesse';
        $lieu['faction']='fed';

        $id=$this->_getParam('id',0);
        if($id!=0) {
            $m=TableMerco::getMerco($id);
            if($m) {
                if($m['engage']==1 && $m['compte_id']==$compte->id)
                    renvoyerMercenaire($id,$compte);
            }
        }
        $this->_redirect("/jeu/equipe");
    }
}