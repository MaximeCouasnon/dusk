<?php
function encoder($t) {
    foreach($t as $key=>$value) {
        if(is_array($value)) $t[$key]=encoder($value);
        else $t[$key]=utf8_encode($value);
    }
    return $t;
}

function decoder($t) {
    foreach($t as $key=>$value) {
        if(is_array($value)) $t[$key]=decoder($value);
        else $t[$key]=utf8_decode($value);
    }
    return $t;
}

class TableMerco extends Zend_Db_Table {
    public static function getMerco($id) {
        $t=new TableMerco();
        $s=$t->_db->select()->from(array('M'=>"dusk_mercos"))->where("M.id=$id");
        $s1=$t->_db->select()->from(array('M'=>"dusk_mercos"),null)
                ->join(array('EM'=>"dusk_equipement_merco"),"M.id=EM.merco_id",null)
                ->join(array('E'=>'dusk_equipement'),"E.id=EM.equipement_id")
                ->where("M.id=$id");
        $s2=$t->_db->select()->from(array('M'=>"dusk_mercos"),null)
                ->join(array('EM'=>"dusk_competences_merco"),"M.id=EM.merco_id",null)
                ->join(array('E'=>'dusk_competences'),"E.id=EM.competence_id")
                ->where("M.id=$id");

        $resultat=encoder($s->query()->fetch());
        if($resultat) {
            $equipement=encoder($s1->query()->fetchAll());
            $competences=encoder($s2->query()->fetchAll());
            $resultat['equipement']=$equipement;
            $resultat['competences']=$competences;
        }
        return $resultat;
    }

    public static function getMercos($data) {
        $t=new TableMerco();
        $s=$t->_db->select()->from("dusk_mercos","id")
                ->where("compte_id=".$data['compte_id'].
                    " AND lieu_recrutement='".$data['lieu_recrutement']."'
                    AND engage=0
                    AND date_gen>=".(time()-86400));

        $mercos=array();
        foreach($s->query()->fetchAll() as $key=>$value) {
            $mercos[]=self::getMerco($value['id']);
        }
        return $mercos;
    }

    public static function getEquipe($data) {
        $t=new TableMerco();
        $s=$t->_db->select()->from("dusk_mercos",'id')
                ->where("compte_id=".$data['compte_id']."
                    AND engage=1");

        $mercos=array();
        foreach($s->query()->fetchAll() as $key=>$value) {
            $mercos[]=self::getMerco($value['id']);
        }
        return $mercos;
    }

    public static function createMerco($merco) {
        $t=new TableMerco();
        $merco=decoder(get_object_vars($merco));
        $t->_db->insert("dusk_mercos",$merco);
    }

    public static function createMercos($mercos) {
        foreach($mercos as $key=>$value) {
            self::createMerco($value);
        }
    }

    public static function acheterMerco($id,$compte) {
        $t=new TableMerco();
        $t->_db->update("dusk_mercos",array("engage"=>1)
                ,"id=$id");
        
        // soustraire argent du joueur
    }

    public static function renvoyerMerco($id) {
        $t=new TableMerco();
        $t->_db->update("dusk_mercos",array("engage"=>0)
                ,"id=$id");
    }

    public static function getMission($data) {
        $t=new TableMerco();
        $t->_db->insert("dusk_mission",$data);
        return $t->_db->lastInsertId();
    }

    public static function createMission($data) {
        $t=new TableMerco();
        $t->_db->insert("dusk_mission",$data);
        return $t->_db->lastInsertId();
    }
}
?>
