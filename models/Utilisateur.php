<?php

class Utilisateur extends DbConnect {

    private $idUtilisateur;
    private $pseudo;
    private $passwd;
    private $nom;
    private $prenom;
    private $email;

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

    function insert() {

        $query = "INSERT INTO Users (`nom`, `prenom`, `email`, `pseudo`, `password`) VALUES (:nom, :prenom, :email, :pseudo, :pw);";
        $result = $this->pdo->prepare($query);
        $result->bindValue('nom', $this->nom, PDO::PARAM_STR);
        $result->bindValue('prenom', $this->prenom, PDO::PARAM_STR);
        $result->bindValue('email', $this->email, PDO::PARAM_STR);
        $result->bindValue('pseudo', $this->pseudo, PDO::PARAM_STR);
        $result->bindValue('pw', $this->passwd, PDO::PARAM_STR);

        if(!$result->execute()) {
            throw new Exception("L'utilisateur n'a pas pu être enregistré dans la base de données");
            if($result->errorCode() == "23000") {
                throw new Exception("Le Pseudo et/ou l'email renseigné(s) existe(nt) déjà !");
            }
        }
        

        

        $this->id = $this->pdo->lastInsertId();
        return $this;
    
    }

    function selectAll() {

        $query = "SELECT id_user, nom, prenom, email, pseudo, password FROM Users";
        $result = $this->pdo->prepare($query);
        $result->execute();

        $datas = $result->fetchAll();
        $datatab = [];
        
        foreach($datas as $data) {
            $user = new Utilisateur();
            $user->setIdUtilisateur($data['id_user']);
            $user->setNom($data['nom']);
            $user->setPrenom($data['prenom']);
            $user->setPseudo($data['pseudo']);
            $user->setPasswd($data['password']);
            array_push($datatab, $user);
        }
        
        return $datatab;

    }

    function select() {

    }

    function selectByPseudo(): ?Utilisateur {

        $query = "SELECT `id_user`, `nom`, `prenom`, `email`, `pseudo`, `password` FROM Users WHERE pseudo = :pseudo";
        $result = $this->pdo->prepare($query);
        $result->bindValue("pseudo", $this->pseudo, PDO::PARAM_STR);
        $result->execute();
        $datas = $result->fetch();
        var_dump($datas);
        if($datas) {
            $this->setIdUtilisateur($datas['id_user']);
            $this->setNom($datas['nom']);
            $this->setPrenom($datas['prenom']);
            $this->setEmail($datas['email']);
            $this->setPseudo($datas['pseudo']);
            $this->setPasswd($datas['password']);

            return $this;
        }

    }

    function update() {

    }

    function delete() {

    }

    function getProperties(): array {
        return get_object_vars($this);
    }

}