<?php
class Equipe {
    public $mercos;

    public function __construct(array $mercos) {
        $this->mercos=$mercos;
    }
}

class ClasseDusk {
    public function __construct(array $t) {
        foreach($t as $key=>$value) {
            $this->$key=$value;
        }
    }
}

class Merco extends ClasseDusk {};

class Equipement extends ClasseDusk {};

class Competence extends ClasseDusk {};
?>
