<?php
namespace WorldCup;
use \SendRequete\SendRequete;
use \DateTime;
use \DateInterval;
\session_start();

if(empty($_SESSION) === true || empty($_SESSION['worldCup']) === true || empty($_SESSION['worldCup']['login']) === true || empty($_SESSION['worldCup']['login']['id']) === true) {
    header('Location: /public/index.php');
}

header('Content-Type: text/html; charset=UTF-8');
require_once './../../class/SendRequete/SendRequete.class.php';

$SendRequete = new SendRequete('loadUser', array(
    'idUser' => $_SESSION['worldCup']['login']['id'],
));
$datas       = $SendRequete->exec();
$datas = (array)$datas;

$Profil = new Profil($datas);

class Profil {
    /**
     * id User
     *
     * @var int
     */
    private $id;
    /**
     * nom user
     *
     * @var string
     */
    private $nom;
    /**
     * prenom user
     *
     * @var string
     */
    private $prenom;
    /**
     * pseudo user
     *
     * @var string
     */
    private $pseudo;
    /**
     * avatar user
     *
     * @var int
     */
    private $avatar;
    /**
     * mail user
     *
     * @var string
     */
    private $mail;
    /**
     * password user
     *
     * @var string
     */
    private $password;
    /**
     * mail confirm
     * 
     * @var bool
     */
    private $mailConfirm;
    /**
     * date a la quel il y a eu les derniere modification
     * 
     * @var string
     */
    private $dateUpdate;
    /**
     * activation newsLetter
     * 
     * @var bool
     */
    private $newsLetter;
    /**
     * accordRGPD
     * 
     * @var bool
     */
    private $accordRGPD;
    /**
     * Data user
     *
     * @var DataUser
     */
    private $dataUser;


    /**
     * Construct
     * 
     * @param array $data
     */
    public function __construct(array $data)
    {
        if(empty($data['id']) === true) {
            $data['id'] = -1;
        }
        if(empty($data['mailConfirm']) === true) {
            $data['mailConfirm'] = false;
        }
        if(empty($data['newsLetter']) === true) {
            $data['newsLetter'] = false;
        }
        if(empty($data['accordRGPD']) === true) {
            $data['accordRGPD'] = true;
        }
        $this->setId((int)$data['id']);
        $this->setNom((string)$data['nom']);
        $this->setPrenom((string)$data['prenom']);
        $this->setPseudo((string)$data['pseudo']);
        $this->setAvatar((int)$data['avatar']);
        $this->setMail((string)$data['mail']);
        $this->setPassword((string)$data['password']);
        $this->setMailConfirm((bool)$data['mailConfirm']);
        $this->setDateUpdate($data['dateUpdate']);
        $this->setNewsLetter((bool)$data['newsLetter']);
        $this->setAccordRGPD((bool)$data['accordRGPD']);
        if(empty($data['dataUser']) === true) {
            $data['dataUser'] = array(
                'cagnotte'        => 0,
                'cagnotteEnCours' => 0,
            );
        }
        $this->setDataUser($data['dataUser']);
    }


    public function getFormulaireUpdate() {

        $html = '<div class="container">';
            $html .= '<div class="row">';
                $html .= '<div class="col-md-12">';
                    $html .= '<div class="card">';
                        $html .= '<div class="card-header card-head-inverse bg-blue" >';
                            $html .= '<h5>Modification des informations personnelles</h5>';
                        $html .= '</div>';
                        $html .= '<div class="card-content collapse show">';
                            $html .= '<div class="card-body">';
                                $html .= '<div class="form-row">';
                                    $html .= '<div class="form-group col-md-6">';
                                        $html .= '<label for="infoPaxNom">Nom</label>';
                                        $html .= '<input type="text" class="form-control" id="infoPaxNom" placeholder="Nom" value="'.$this->getNom().'">';
                                    $html .= '</div>';
                                    $html .= '<div class="form-group col-md-6">';
                                        $html .= '<label for="infoPaxPrenom">Prenom</label>';
                                        $html .= '<input type="text" class="form-control" id="infoPaxPrenom" placeholder="Prenom" value="'.$this->getPrenom().'">';
                                    $html .= '</div>';
                                $html .= '</div>';
                                $html .= '<div class="form-row">';
                                    $html .= '<div class="form-group col-md-6">';
                                        $html .= '<label for="infoPaxMail">Pseudo</label>';
                                        $html .= '<input type="text" class="form-control" id="infoPaxPseudo" placeholder="Pseudo" value="'.$this->getPseudo().'">';
                                    $html .= '</div>';
                                    $html .= '<div class="form-group col-md-6">';
                                        $html .= '<label for="inputPassword4">Mail</label>';
                                        $html .= '<input type="email" class="form-control" id="inputPassword4" placeholder="Mail" value="'.$this->getMail().'">';
                                    $html .= '</div>';
                                $html .= '</div>';
                                $html .= '<div class="form-row">';
                                    $html .= '<div class="form-group col-md-12">';
                                        $html .= '<label for="infoPaxMail">Avatar</label>';
                                        $html .= '<div class="input-group">';
                                        $labelProtraitChecked = ' labelProtraitChecked';
                                        for($i = 1; $i <= 8; $i++) {
                                            $checked = '';
                                            if($i === $this->getAvatar()) {
                                                $checked = ' checked';
                                            }
                                            $html .= '<label for="portrait_'.$i.'" class="labelProtrait'.$labelProtraitChecked.'">';
                                                $html .= '<input type="radio" name="avatar" id="portrait_'.$i.'" value="'.$i.'" '.$checked.'/>';
                                                $html .= '<img src="/src/images/portrait/dessin/'.$i.'.png"/>';
                                            $html .= '</label>';
                                            $labelProtraitChecked = $checked = '';
                                        }
                                        unset($labelProtraitChecked);
                                        $html .= '</div>';
                                    $html .= '</div>';
                                $html .= '</div>';
                                $html .= '<div class="form-row">';
                                    $html .= '<div class="form-group col-md-6">';
                                        $html .= '<label for="infoPaxMail">Nouveau mot de passe</label>';
                                        $html .= '<input type="password" class="form-control" id="infoPaxPseudo" placeholder="Nouveau mot de passe" value="">';
                                    $html .= '</div>';
                                    $html .= '<div class="form-group col-md-6">';
                                        $html .= '<label for="inputPassword4">Confirmation nouveau mot de passe</label>';
                                        $html .= '<input type="password" class="form-control" id="inputPassword4" placeholder="Confirmation nouveau mot de passe" value="">';
                                    $html .= '</div>';
                                $html .= '</div>';
                                $html .= '<div class="form-row">';
                                    $html .= '<div class="form-group col-md-12">';
                                        $html .= '<div class="custom-control custom-checkbox" >';
                                            $checked = null;
                                            if($this->isNewsLetter()) {
                                                $checked = ' checked';
                                            }
                                            $html .= '<input type="checkbox" class="custom-control-input" id="customControlValidationCheckNewsLetter" name="checkNewsLetter" '.$checked.'>';
                                            $html .= '<label class="custom-control-label" for="customControlValidationCheckNewsLetter" >';
                                                $html .= 'Je veux que tu me spam ma boite mail.';
                                            $html .= '</label>';
                                        $html .= '</div>';
                                    $html .= '</div>';
                                $html .= '</div>';
                                $html .= '<div class="form-row">';
                                    $html .= '<div class="form-group col-md-12 text-center">';
                                        $html .= '<intput type="submit" name="btnSaveInfosProfil" class="btn btn-success">Enregistrer les modifications</button>';
                                    $html .= '</div>';
                                $html .= '</div>';
                            $html .= '</div>';
                        $html .= '</div>';
                    $html .= '</div>';
                $html .= '</div>';
            $html .= '</div>';
        
            $html .= '<div class="row">';
                $html .= '<div class="col-md-12">';
                    $html .= '<div class="card">';
                        $html .= '<div class="card-header card-head-inverse bg-blue" >';
                            $html .= '<h5>Fermeture du compte</h5>';
                        $html .= '</div>';
                        $html .= '<div class="card-content collapse show">';
                            $html .= '<div class="card-body">';
                                $html .= '<div class="form-row">';
                                    $html .= '<div class="form-group col-md-12">';
                                        $html .= '<button type="button" name="btnDeleteDataUser" class="btn btn-danger" >Je veux fermer mon compte!</button>';
                                    $html .= '</div>';
                                $html .= '</div>';
                            $html .= '</div>';
                        $html .= '</div>';
                    $html .= '</div>';
                $html .= '</div>';
            $html .= '</div>';
        $html .= '</div>';
        return $html;
    }

    /**
     * Get id User
     *
     * @return int
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id User
     *
     * @param int $id id User
     *
     * @return self
     */ 
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get nom user
     *
     * @return  string
     */ 
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set nom user
     *
     * @param string  $nom  nom user
     *
     * @return  self
     */ 
    public function setNom(string $nom)
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * Get prenom user
     *
     * @return string
     */ 
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set prenom user
     *
     * @param string $prenom  prenom user
     *
     * @return  self
     */ 
    public function setPrenom(string $prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get pseudo user
     *
     * @return string
     */ 
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * Set pseudo user
     *
     * @param string  $pseudo  pseudo user
     *
     * @return self
     */ 
    public function setPseudo(string $pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get 1 = femme
     *
     * @return  bool
     */ 
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set avatar
     *
     * @param  bool  $avatar
     *
     * @return  self
     */ 
    public function setAvatar(int $avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get mail user
     *
     * @return string
     */ 
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set mail user
     *
     * @param string  $mail  mail user
     *
     * @return self
     */ 
    public function setMail(string $mail)
    {
        $this->mail = strtolower($mail);

        return $this;
    }

    /**
     * Get password user
     *
     * @return string
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set password user
     *
     * @param string  $password  password user
     *
     * @return  self
     */ 
    public function setPassword(string $password)
    {
        $this->password = $password;

        return $this;
    }    

    /**
     * Get mail confirm
     *
     * @return  bool
     */ 
    public function isMailConfirm()
    {
        return $this->mailConfirm;
    }

    /**
     * Set mail confirm
     *
     * @param  bool  $mailConfirm  mail confirm
     *
     * @return  self
     */ 
    public function setMailConfirm(bool $mailConfirm)
    {
        $this->mailConfirm = $mailConfirm;

        return $this;
    }

    /**
     * Get data user
     *
     * @return  array
     */ 
    public function getDataUser()
    {
        return $this->dataUser;
    }

    /**
     * Get date a la quel il y a eu les derniere modification
     *
     * @return  string
     */ 
    public function getDateUpdate()
    {
        return $this->dateUpdate;
    }

    /**
     * Set date a la quel il y a eu les derniere modification
     *
     * @param  string|DateTime  $dateUpdate  date a la quel il y a eu les derniere modification
     *
     * @return  self
     */ 
    public function setDateUpdate($dateUpdate)
    {
        if($dateUpdate instanceof DateTime) {
            $this->dateUpdate = $dateUpdate;
        }
        else {
            if($dateUpdate === null) {
                $dateUpdate = '';
            }
            $this->dateUpdate = new DateTime($dateUpdate);
        }
        return $this;
    }

    /**
     * Get activation mail auto
     *
     * @return  bool
     */ 
    public function isNewsLetter()
    {
        return $this->newsLetter;
    }

    /**
     * Set activation mail auto
     *
     * @param  bool  $newsLetter  activation mail auto
     *
     * @return  self
     */ 
    public function setNewsLetter(bool $newsLetter)
    {
        $this->newsLetter = $newsLetter;

        return $this;
    }

    /**
     * Get accordRGPD
     *
     * @return  bool
     */ 
    public function isAccordRGPD()
    {
        return $this->accordRGPD;
    }

    /**
     * Set accordRGPD
     *
     * @param  bool  $accordRGPD  accordRGPD
     *
     * @return  self
     */ 
    public function setAccordRGPD(bool $accordRGPD)
    {
        $this->accordRGPD = $accordRGPD;

        return $this;
    }

    /**
     * Set data user
     *
     * @param  array  $array  Data user
     *
     * @return  self
     */ 
    public function setDataUser(array $dataUser)
    {
        $this->dataUser = $dataUser;

        return $this;
    }
}

?>
<!DOCTYPE html>
<html class="loading" lang="fr" data-textdirection="ltr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <link rel="stylesheet" type="text/css" href="/src/bootstrap-4.0.0/css/bootstrap.min.css" id="bootstrap-css">
        <link rel="stylesheet" type="text/css" href="/app/src/css/flag-icon.min.css">
        <link rel="stylesheet" type="text/css" href="/app/src/css/feather.min.css">
        <link rel="stylesheet" type="text/css" href="/app/src/fonts/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="./css/pace.css">
        <link rel="stylesheet" type="text/css" href="./css/bootstrap-extended.css">
        <link rel="stylesheet" type="text/css" href="./css/colors.css">
        <link rel="stylesheet" type="text/css" href="./css/components.css">
        <link rel="stylesheet" type="text/css" href="./css/users.css">
        <link rel="stylesheet" type="text/css" href="/app/src/css/nav.css">
        <link rel="stylesheet" type="text/css" href="./css/home.css">
        <link rel="stylesheet" type="text/css" href="./css/profil.css">
        <link rel="stylesheet" type="text/css" href="./css/datatables.min.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i"
        rel="stylesheet">
    </head>
    <body class="2-columns">
        <?php require_once "./../../src/nav.php"; ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="app-content content">
                <div class="content-wrapper">
                    <div class="content-body">
                        <div class="row match-height">
                            <div class="col-xl-12 col-lg-12">
                            <?php


                            if($_SESSION['worldCup']['login']['id'] === 1) {
                                echo $Profil->getFormulaireUpdate();
                            }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <footer class="footer footer-static footer-light navbar-border">
            <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2">
            <span class="float-md-left d-block d-md-inline-block">Copyright &copy; 2018 <a class="text-bold-800 grey darken-2" href="#">CHRISTOPHE</a>, All rights reserved. </span>
            <span class="float-md-right d-block d-md-inline-block d-none d-lg-block">Fait avec <i class="ft-heart pink"></i></span>
            </p>
        </footer>
        <script src="./js/vendors.min.js" type="text/javascript"></script>
        <script src="./js/app-menu.js" type="text/javascript"></script>
        <script src="./js/app.js" type="text/javascript"></script>
        <script src="./js/profil.js" type="text/javascript"></script>
        <!-- <script src="./js/home.js" type="text/javascript"></script> -->
        <script src="./js/datatables.min.js" type="text/javascript"></script>
        <script src="./js/datatable-styling.js" type="text/javascript"></script>
    </body>
</html>