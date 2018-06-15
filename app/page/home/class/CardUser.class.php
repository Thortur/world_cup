<?php
namespace WorldCup;

class CardUser {
    /**
     * id utilisateur connecter
     * 
     * @var int $idUserConnecter
     */
    private $idUserConnecter;
    /**
     * nom de l'utilisateur connecter
     * 
     * @var string $nom
     */
    private $nom;
    /**
     * prenom de l'utilisateur connecter
     * 
     * @var string $prenom
     */
    private $prenom;
    /**
     * pseudo de l'utilisateur connecter
     * 
     * @var string $pseudo
     */
    private $pseudo;
    /**
     * mail de l'utilisateur connecter
     * 
     * @var string $mail
     */
    private $mail;
    /**
     * id de l'avatar
     * 
     * @var int $avatar
     */
    private $avatar;
    /**
     * Cagnotte restant a l'utilisateur connecter
     * 
     * @var float $cagnotteRestante
     */
    private $cagnotteRestante;

    /**
     * Construct de la class
     * 
     * @param object $datas
     */
    public function __construct(int $idUserConnecter, object $datas, float $cagnotteRestante) {
        $this->setIdUserConnecter($idUserConnecter);
        $this->setNom($datas->listUser->$idUserConnecter->nom);
        $this->setPrenom($datas->listUser->$idUserConnecter->prenom);
        $this->setPseudo($datas->listUser->$idUserConnecter->pseudo);
        $this->setMail($datas->listUser->$idUserConnecter->mail);
        $this->setAvatar($datas->listUser->$idUserConnecter->avatar);
        $this->setCagnotteRestante($cagnotteRestante);
    }

    /**
     * Retoure le code html de la carte des paris
     * 
     * @return string $html
     */
    public function getCard() {
        $html = '<div class="card text-center profile-card-with-stats">';
            $html .= '<div class="card-header card-head-inverse bg-blue">';
                $html .= '<h4 class="card-title">Votre profil</h4>';
            $html .= '</div>';
            $html .= '<div class="text-center">';
                $html .= '<div class="card-profile-image">';
                    $html .= '<img src="/src/images/portrait/dessin/'.$this->getAvatar().'.png" class="rounded-circle img-border box-shadow-1 mt-3" alt="Card image">';
                $html .= '</div>';
                $html .= '<div class="card-body">';
                    $html .= '<h4 class="card-title">@'.$this->getPseudo().'</h4>';
                    $html .= '<ul class="list-inline list-inline-pipe">';
                        $html .= '<li>Groupe1</li>';
                        $html .= '<li>Misterbooking</li>';
                        $html .= '<li>Groupe3</li>';
                    $html .= '</ul>';
                    $html .= '<h6 class="card-subtitle text-muted">'.$this->getCagnotteRestante().' €</h6>';
                $html .= '</div>';
                $html .= '<div class="btn-group" role="group" aria-label="Profile example">';
                    $html .= '<button type="button" class="btn btn-float box-shadow-0 btn-outline-info" data-toggle="tooltip" data-placement="bottom" title="Nombre de paris réussis">';
                        $html .= '<span class="ladda-label"><i class="fa fa-bar-chart"></i>';
                            $html .= '<span>0/0</span>';
                        $html .= '</span>';
                        $html .= '<span class="ladda-spinner"></span>';
                    $html .= '</button>';
                    $html .= '<button type="button" class="btn btn-float box-shadow-0 btn-outline-info" data-toggle="tooltip" data-placement="bottom" title="Plus grande côte misée">';
                        $html .= '<span class="ladda-label"><i class="fa fa-trophy"></i>';
                            $html .= '<span>1</span>';
                        $html .= '</span>';
                        $html .= '<span class="ladda-spinner"></span>';
                    $html .= '</button>';
                    $html .= '<button type="button" class="btn btn-float box-shadow-0 btn-outline-info" data-toggle="tooltip" data-placement="bottom" title="Plus grande somme gagnée sur un pari">';
                        $html .= '<span class="ladda-label"><i class="fa fa-money"></i>';
                            $html .= '<span>0</span>';
                        $html .= '</span>';
                        $html .= '<span class="ladda-spinner"></span>';
                    $html .= '</button>';
                $html .= '</div>';
                $html .= '<div class="card-body">';
                    $html .= '<button type="button" class="btn btn-outline-danger btn-md mr-1"><i class="fa fa-plus"></i> Passer Premium</button>';
                    $html .= '<a href="/app/page/home/profil.php"><button type="button" class="btn btn-outline-primary btn-md mr-1"><i class="ft-user"></i> Voir le profil</button></a>';
                $html .= '</div>';
            $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Get $idUserConnecter
     *
     * @return  int
     */ 
    public function getIdUserConnecter()
    {
        return $this->idUserConnecter;
    }

    /**
     * Set $idUserConnecter
     *
     * @param  int  $idUserConnecter  $idUserConnecter
     *
     * @return  self
     */ 
    public function setIdUserConnecter(int $idUserConnecter)
    {
        $this->idUserConnecter = $idUserConnecter;

        return $this;
    }

    /**
     * Get $nom
     *
     * @return  string
     */ 
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set $nom
     *
     * @param  string  $nom  $nom
     *
     * @return  self
     */ 
    public function setNom(string $nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get $prenom
     *
     * @return  string
     */ 
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set $prenom
     *
     * @param  string  $prenom  $prenom
     *
     * @return  self
     */ 
    public function setPrenom(string $prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get $pseudo
     *
     * @return  string
     */ 
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * Set $pseudo
     *
     * @param  string  $pseudo  $pseudo
     *
     * @return  self
     */ 
    public function setPseudo(string $pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get $mail
     *
     * @return  string
     */ 
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set $mail
     *
     * @param  string  $mail  $mail
     *
     * @return  self
     */ 
    public function setMail(string $mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get $avatar
     *
     * @return  int
     */ 
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set $avatar
     *
     * @param  int  $avatar  $avatar
     *
     * @return  self
     */ 
    public function setAvatar(int $avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get $cagnotteRestante
     *
     * @return  float
     */ 
    public function getCagnotteRestante()
    {
        return $this->cagnotteRestante;
    }

    /**
     * Set $cagnotteRestante
     *
     * @param  float  $cagnotteRestante  $cagnotteRestante
     *
     * @return  self
     */ 
    public function setCagnotteRestante(float $cagnotteRestante)
    {
        $this->cagnotteRestante = $cagnotteRestante;

        return $this;
    }
}