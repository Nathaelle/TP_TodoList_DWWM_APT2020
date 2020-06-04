<?php
$tasks = $view["datas"]["tasks"];

?>

<h1>Mon espace</h1>

<p>
    <a href="deconnect">Me déconnecter</a>
</p>

<form action="<?= isset($view['datas']['task'])? "mod_task" : "insert_tache"; ?>" method="post" enctype="multipart/form-data">
    <div>
        <label for="description">Description</label>
        <input type="text" id="description" name="description" value="<?= isset($view['datas']['task'])? $view['datas']['task']->getDescription() : ""; ?>">
    </div>
    <div>
        <label for="deadline">Avant le </label>
        <input type="date" id="deadline" name="deadline" value="<?= isset($view['datas']['task'])? $view['datas']['task']->getDeadline()->format("Y-m-d") : ""; ?>">
    </div>
    <div>
        <label for="image">Illustration </label>
        <input type="file" id="image" name="image" value="">
    </div>
    <?= isset($view['datas']['task'])? "<input type='hidden' name='id_tache' value='".$view['datas']['task']->getIdTache()."'>" : ""; ?>
    <input type="submit" value="<?= isset($view['datas']['task'])? "Modifier" : "Ajouter"; ?>">
</form>

<h2>Liste des choses à faire :</h2>
<ul>
    
<?php foreach($tasks as $task): ?>
    <li><img src="img/<?= $task->getImage() ?>" alt="" style="width: 50px; height: 50px; margin: 5px; margin-bottom: -10px;"><a href="membre-<?= $task->getIdTache() ?>"><?= $task->getDescription() ?></a> avant le <?= $task->getDeadline()->format("d/m/Y") ?> <a href="del_task-<?= $task->getIdTache() ?>">Supprimer</a></li>
<?php endforeach ?>

</ul>