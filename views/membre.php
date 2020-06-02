<?php
$tasks = $view["datas"]["tasks"];

?>

<h1>Mon espace</h1>

<p>
    <a href="index.php?route=deconnect">Me déconnecter</a>
</p>

<form action="index.php?route=<?= isset($view['datas']['task'])? "mod_task" : "insert_tache"; ?>" method="post">
    <div>
        <label for="description">Description</label>
        <input type="text" id="description" name="description" value="<?= isset($view['datas']['task'])? $view['datas']['task']->getDescription() : ""; ?>">
    </div>
    <div>
        <label for="deadline">Avant le </label>
        <input type="date" id="deadline" name="deadline" value="<?= isset($view['datas']['task'])? $view['datas']['task']->getDeadline()->format("Y-m-d") : ""; ?>">
    </div>
    <?= isset($view['datas']['task'])? "<input type='hidden' name='id_tache' value='".$view['datas']['task']->getIdTache()."'>" : ""; ?>
    <input type="submit" value="<?= isset($view['datas']['task'])? "Modifier" : "Ajouter"; ?>">
</form>

<h2>Liste des choses à faire :</h2>
<ul>
    
<?php foreach($tasks as $task): ?>
    <li><a href="index.php?route=membre&id=<?= $task->getIdTache() ?>"><?= $task->getDescription() ?></a> avant le <?= $task->getDeadline()->format("d/m/Y") ?> <a href="index.php?route=del_task&id=<?= $task->getIdTache() ?>">Supprimer</a></li>
<?php endforeach ?>

</ul>