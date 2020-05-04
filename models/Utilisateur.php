<?php

class Utilisateur {

    private $idUtilisateur;
    private $pseudo;
    private $passwd;
    private $nom;
    private $prenom;
    private $email;
    private $pdo;

    function __construct() {
        $this->pdo = new PDO();
    }

    function getIdUtilisateur(): int {
        return $this->idUtilisateur;
    }

    function setIdUtilisateur(int $id) {
        $this->idUtilisateur = $id;    
    }

    function getPseudo(): string {
        return $this->pseudo;
    }

    function setPseudo(string $pseudo) {
        $this->pseudo = $pseudo;    
    }

    function getPasswd(): string {
        return $this->passwd;
    }

    function setPasswd(string $passwd) {
        $this->passwd = $passwd;    
    }

    function getNom(): string {
        return $this->nom;
    }

    function setNom(string $nom) {
        $this->nom = $nom;    
    }

    function getPrenom(): string {
        return $this->prenom;
    }

    function setPrenom(string $prenom) {
        $this->prenom = $prenom;    
    }
    
    function getEmail(): string {
        return $this->email;
    }

    function setEmail(string $email) {
        $this->email = $email;    
    }

    function saveUser() {

        $tab = json_decode(file_get_contents("datas/users.json"));

        $unique = true;
        foreach($tab as $element) {
            if($element->pseudo == $this->pseudo) {
                $unique = false;
            }
        }

        $user = [
            "id_utilisateur" => sizeof($tab) + 1,
            "pseudo" => $this->pseudo,
            "passwd" => $this->passwd,
            "nom" => $this->nom,
            "prenom" => $this->prenom,
            "email" => $this->email
        ];

        if($unique) {
            array_push($tab, $user);
            $users_json = json_encode($tab);
            file_put_contents("datas/users.json", $users_json);
        }
        
    }

    function verifyUser() {

        $tab = json_decode(file_get_contents("datas/users.json"));
        foreach($tab as $user) {
            if($this->pseudo == $user->pseudo) {
                return $user;
            }
        }
    }

}