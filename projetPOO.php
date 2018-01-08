<?php

namespace location\dao;
use \PDO;

class Utilisateur
{
    var $idutil;
    var $nomComplet;
    var $login;
    var $password;
    var $profil;
    var $etat;
    private $bdd;

    private function getConnexion(){
        try{
            $this->bdd = new PDO('mysql:host=;dbname=BDLOCATION;charset=utf8', 'root', 'passer');
            $this->bdd ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        }
        catch(Exception $e){
            die('Erreur : ' . $e->getMessage());
        }
    }

    function addUtilisateur()
    {
        $this->getConnexion();
        // requete a executer
        $sql = "INSERT into Utilisateur VALUES(null, :nomComplet, :login, :etat, :password, :profil)";
        // preparation de la requete
        $req = $this->bdd->prepare($sql);
        //execution de la requete
        $data = $req->execute(
            array('nomComplet'=>$this->nomComplet,
                'login'=>$this->login,
                'etat'=>$this->etat,
                'password'=>$this->password,
                'profil'=>$this->profil
            ));
        return $data;
    }

    function getAllUtilisateur()
    {
        $this->getConnexion();
        // requete a executer
        $sql = "SELECT * FROM Utilisateur";
        // preparation de la requete
        $donnees = $this->bdd->query($sql);
        return $donnees;
    }

    function login($login, $password)
    {
        $this->getConnexion();
        // requete a executer
        $sql = "SELECT * FROM Utilisateur WHERE login = :login AND password = :password";
        // preparation de la requete
        $req = $this->bdd->prepare($sql);
        //execution de la requete
        $data = $req->execute(
            array(
                'login'=>$login,
                'password'=>$password
            ));
        return $data;
    }

    function changepassword($password)
    {
        $this->getConnexion();
        // requete a executer
        $sql = "UPDATE Utilisateur
        SET password = :password
        WHERE login = :login;";
        // preparation de la requete
        $req = $this->bdd->prepare($sql);
        //execution de la requete
        $data = $req->execute(
            array(
                'login'=>$this->login,
                'password'=>$password
            ));
        return $data;
    }

}

class Bien
{
    var $idbien;
    var $nombien;
    var $addresse;
    var $montantloc;
    var $commission;
    var $idtbien;
    var $idprop;
    private $bdd;

    private function getConnexion(){
        try{
            $this->bdd = new PDO('mysql:host=;dbname=BDLOCATION;charset=utf8', 'root', 'passer');
            $this->bdd ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        }
        catch(Exception $e){
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function addBien()
    {
        $this->getConnexion();
        // requete a executer
        $sql = "INSERT into Bien VALUES(null, :nom, :addresse, :, :montantloc, :idtbien, :idprop)";
        // preparation de la requete
        $req = $this->bdd->prepare($sql);
        //execution de la requete
        $data = $req->execute(
            array('nom'=>$this->nombien,
                'addresse'=>$this->addresse,
                'commission'=>$this->commission,
                'idtbien'=>$this->idtbien,
                'idprop'=>$this->idprop
            ));
        return $data;
    }

    //methode find qui permet de retrouver un bien à travers son nom

    public static function find($Nom){
        $this->getConnexion();
        $sql = $this->bdd->query("SELECT * FROM Bien WHERE nombien = '".$Nom."'");
        if ($res = $sql->fetch()) {
            do{
                echo $res['nombien']." trouvé";
            }while($res = $sql->fetch());
        }
        else
            echo "Aucun résultat trouvé";
    }

    //methode lister qui retourne la liste des biens

    public static function lister(){
        $this->getConnexion();
        $sql = $this->bdd->query("SELECT * FROM Bien ");
        return $sql;
    }

    //methode listerByType qui retourne tous les biens d'un type donnée qui prend en paramètre l'id

    public static function listerByType($idType){
        $this->getConnexion();
        $sql = $this->bdd->query("SELECT * FROM Bien WHERE idtbien =".$idType);
        return $sql;
    }

    //créer un objet Propietaire

    //créer un objet TypeBien

    // classe Propriétaire

    class Propietaire{
        var $idprop;
        var $numpiece;
        var $nomprop;
        var $tel;
        private $bdd;

        private function getConnexion(){
            try{
                $this->bdd = new PDO('mysql:host=;dbname=BDLOCATION;charset=utf8', 'root', 'passer');
                $this->bdd ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            }
            catch(Exception $e){
                die('Erreur : ' . $e->getMessage());
            }
        }

        //permet de modifier le tel d'un propriétaire

        public function update($tel){
            $this->getConnexion();
            $sql = $this->bdd->exec("UPDATE Propietaire SET tel='".$tel."' WHERE idprop=".$this->idprop);
            return $sql;
        }

        //rechercher un propriétaire à travers son CNI

        public function find($cni){
            $this->getConnexion();
            $sql = $this->bdd->query("SELECT * FROM Propietaire WHERE numpiece='".$cni."'");
            return $sql;
        }

        //méthode lister qui retourne la liste des propriétaire

        public function lister(){
            $this->getConnexion();
            $sql = $this->bdd->query("SELECT * FROM Propietaire");
            return $sql;
        }

    }

    // Classe type bien

        class TypeBien{

            var $idtbien;
            var $nomtbien;
            private $bdd;

            private function getConnexion(){
                try{
                    $this->bdd = new PDO('mysql:host=;dbname=BDLOCATION;charset=utf8', 'root', 'passer');
                    $this->bdd ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
                }
                catch(Exception $e){
                    die('Erreur : ' . $e->getMessage());
                }
            }


            //methode add qui permet d'enregister un bien.

            public function add(){
                $this->getConnexion();
                $sql = "INSERT INTO typeBien VALUES(null, :nom)";
                $req = $this->bdd->prepare($sql);
                $data = $req->execute(array('nom'=>$this->nomtbien));
                return $data;
            }

            //methode lister qui liste les types de bien.

            public function lister(){
                $this->getConnexion();
                $sql = $this->bdd->query("SELECT * FROM typeBien");
                return $sql;
            }

            //methode findById qui retourne un type de bien à travers son id.

            public function findById($id){
                $this->getConnexion();
                $sql = $this->bdd->query("SELECT * FROM typeBien WHERE idtbien=".$id);
                return $sql;
            }
        }
}