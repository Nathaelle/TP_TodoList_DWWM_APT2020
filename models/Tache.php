<?php

class Tache extends DbConnect {

    private $idTache;
    private $description;
    private $deadline;
    private $idUtilisateur;
    private $image;

    function getIdTache(): int {
        return $this->idTache;
    }

    function getDescription(): string {
        return $this->description;
    }

    function getDeadline(): DateTime {
        return $this->deadline;
    }

    function getIdUtilisateur(): int {
        return $this->idUtilisateur;
    }

    function getImage(): string {
        return $this->image;
    }

    function setIdTache(int $id) {
        $this->idTache = $id;
    }

    function setDescription(string $desc) {
        $this->description = $desc;
    }

    function setDeadline(DateTime $dd) {
        $this->deadline = $dd;
    }

    function setIdUtilisateur(int $id) {
        $this->idUtilisateur = $id;
    }

    function setImage(string $image) {
        $this->image = $image;
    }

    function insert() {

        $ddline = $this->deadline->format("Y-m-d");
        $query = "INSERT INTO `tasks`(`description`, `deadline`, `id_user`, `image`) VALUES (:desc,:deadline,:id, :image)";
        $result = $this->pdo->prepare($query);
        $result->bindValue("desc", $this->description, PDO::PARAM_STR);
        $result->bindValue("deadline", $ddline, PDO::PARAM_STR);
        $result->bindValue("image", $this->image, PDO::PARAM_STR);
        $result->bindValue("id", $this->idUtilisateur, PDO::PARAM_INT);
        $result->execute();

        $this->idTache = $this->pdo->lastInsertId();
        return $this;
    }

    function selectAll() {

    }

    function selectByUser() {

        $query = "SELECT `id_task`, `description`, `deadline`, `id_user`, `image` FROM Tasks WHERE id_user = :id";
        $result = $this->pdo->prepare($query);
        $result->bindValue("id", $this->idUtilisateur, PDO::PARAM_INT);
        $result->execute();
        $datas = $result->fetchAll();
        
        $tasks = [];
        foreach($datas as $elem) {
            $task = new Tache();
            $task->setIdTache($elem['id_task']);
            $task->setDescription($elem['description']);
            $task->setIdUtilisateur($elem['id_user']);
            $task->setDeadline(new DateTime($elem['deadline'], new DateTimeZone("europe/paris")));
            $task->setImage($elem['image']);
            array_push($tasks, $task);
        }

        return $tasks;

    }

    function select() {

        $query = "SELECT `id_task`, `description`, `deadline`, `id_user`, `image` FROM tasks WHERE id_task = :id";
        $result = $this->pdo->prepare($query);
        $result->bindValue("id", $this->idTache, PDO::PARAM_INT);
        $result->execute();
        $datas = $result->fetch();
        $this->setDescription($datas['description']);
        $this->setIdUtilisateur($datas['id_user']);
        $this->setDeadline(new DateTime($datas['deadline'], new DateTimeZone("europe/paris")));
        $this->setImage($datas['image']);
        return $this;
    }

    function update() {

        $ddline = $this->deadline->format("Y-m-d");
        $query = "UPDATE `tasks` SET `description`= :desc,`deadline`= :deadline,`id_user`= :iduser WHERE id_task = :idtache";
        $result = $this->pdo->prepare($query);
        $result->bindValue("desc", $this->description, PDO::PARAM_STR);
        $result->bindValue("deadline", $ddline, PDO::PARAM_STR);
        $result->bindValue("iduser", $this->idUtilisateur, PDO::PARAM_INT);
        $result->bindValue("idtache", $this->idTache, PDO::PARAM_INT);
        $result->execute();

        var_dump($this);

    }

    function delete() {

        $query = "DELETE FROM Tasks WHERE id_task = :id";
        $result = $this->pdo->prepare($query);
        $result->bindValue("id", $this->idTache, PDO::PARAM_INT);
        $result->execute();
    }

    function getProperties(): array {
        return get_object_vars($this);
    }

}