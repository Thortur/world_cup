<?php
declare (strict_types = 1);
namespace AppApiRest;
header('Content-Type: text/html; charset=UTF-8');

use \Connexion\ConfigDataBase;
use \Connexion\Database;
use \Team\TeamManagerMYSQL;
use \User\User;
use \User\UserManagerMYSQL;


require_once './../src/Autoloader.class.php';
Autoloader::register();
$ConfigDataBase = new ConfigDataBase('netfocus', './../');
$Db = Database::init($ConfigDataBase);

$User = UserManagerMYSQL::connexion('Thortur', 'Mendy!2');

if($User instanceof User) {
    echo 'Oui<br/>';
}
else {
    echo 'Non<br/>';
}
// $listUser = UserManagerMYSQL::loadListAllTeam();

// $User = new User(array(
//     'id'      => 1,
//     'nom'      => 'Lefèvre',
//     'prenom'   => 'Christophe',
//     'pseudo'   => 'Thortur',
//     'mail'     => 'lefevre.christophe@outlook.com',
//     'password' => 'Mendy!2',
// ));

// var_dump($User);
// UserManagerMYSQL::insertUser($User);
// UserManagerMYSQL::updateUser($User);
// UserManagerMYSQL::updatePassWord($User);
// var_dump($res);
// $listTeam = TeamManagerMYSQL::loadListAllTeam();
// var_dump($listTeam);
// Initiiate Library
// $api = new ApiApp();
// $api->processApi();


// $req = "SELECT
//             *
//         FROM utilisateurs
//         WHERE
//             utilisateurs.id_organisation = :idOrg AND (utilisateurs.id_organisation = :idOrg OR utilisateurs.id_organisation = :idOrg) AND utilisateurs.id_organisation = :idOrg AND utilisateurs.id_organisation IN (:idOrg, :idOrg)
//             ORDER BY utilisateurs.id_organisation";
// $res = $Db->execStatement($req, 
//                             array(
//                                 ':idOrg' => array(
//                                                 'type' => 'int',
//                                                 'value' => 28025,
//                                             )
//                                 ),
//                             array(
//                                 'methode'    => 'fetchAll',
//                                 'fetchStyle' => 'FETCH_OBJ',
//                             ));
// echo '<pre>';
//     var_dump($res);
// echo '</pre>';
