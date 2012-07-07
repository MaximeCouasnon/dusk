<?php
class formConnexion extends Zend_Form {
    public function  __construct() {
        $login=new Zend_Form_Element_Text('login');
        $login->setLabel('Identifiant')
                ->setDecorators(array('ViewHelper','Label'))
                ->setRequired();

        $pass=new Zend_Form_Element_Password('pass');
        $pass->setLabel('Mot de Passe')
                ->setDecorators(array('ViewHelper','Label'))
                ->setRequired();

        $connexion_auto=new Zend_Form_Element_Checkbox('connexion_auto');
        $connexion_auto->setLabel("Connexion automatique")
                ->setDecorators(array('ViewHelper','Label'));

        $valider=new Zend_Form_Element_Submit('valider');
        $valider->setLabel("Connexion")
                ->setDecorators(array('ViewHelper'));

        $this->setElements(array($login,$pass,$connexion_auto,$valider));
    }
}

class formInscription extends Zend_Form {
    public function __construct() {
        $login=new Zend_Form_Element_Text('login');
        $login->setLabel('Identifiant')
                ->setDecorators(array('ViewHelper','Label'))
                ->setRequired();

        $pass1=new Zend_Form_Element_Password('pass1');
        $pass1->setLabel('Mot de Passe')
                ->setDecorators(array('ViewHelper','Label'))
                ->setRequired();

        $pass2=new Zend_Form_Element_Password('pass2');
        $pass2->setLabel('Confirmer')
                ->setDecorators(array('ViewHelper','Label'))
                ->setRequired();

        $captcha = new Zend_Form_Element_Captcha('captcha', array(
            'captcha' => array(
                'captcha' => 'reCaptcha',
                'pubkey'=>'6Le2D8MSAAAAAHY3S-AM0a9yhJFitqkF56HZIrN-',
                'privKey'=>'6Le2D8MSAAAAAOv2H2bFzKAyd8wgWTjSS26oTguL'
            ),
        ));
                        //'6Le2D8MSAAAAAHY3S-AM0a9yhJFitqkF56HZIrN-', '6Le2D8MSAAAAAOv2H2bFzKAyd8wgWTjSS26oTguL'));

        $valider=new Zend_Form_Element_Submit('valider');
        $valider->setLabel("Connexion")
                ->setDecorators(array('ViewHelper'));

        $this->setElements(array($login,$pass1,$pass2,$captcha,$valider));
    }
}
?>
