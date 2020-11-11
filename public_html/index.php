<?
//pass = %O2Xs17Z
include_once ('connect.php');
include_once ('component.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TODO</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/main.css">
</head>

<body>
<div class="projects">
    <form id="addProject" onsubmit="return addProject(this);" action="action.php" class="todo__new">
        <input name="create" type="text" required placeholder="Start typing here to create a Project...">
        <button>Add Project</button>
    </form>
</div>

<div class="container">
    <?
    foreach ($arResult['projects'] as $key ){
    ?>
        <div class="todo" id="<?=$key['id']?>">
            <div class="todo__header">
                <img src="icons/calendar.svg" alt="" class="todo__logo">
                <div style="flex: auto" class="todo__title">
                    <div class="text"><?=$key['name']?></div>
                    <input type="text" value="<?=$key['name']?>">
                    <input onclick="saveProject(this);" type="button" value="save">
                </div>
                <img width="45px" onclick="editProject(this)" class="todo__pencil" src="icons/pencil.svg" alt="">
                <img  width="45px" onclick="deleteProject(this)" class="todo__delete" src="icons/delete.svg" alt="">
            </div>
            <div class="todo__add">
                <div class="todo__plus"></div>
                <form onsubmit="return addTask(this);" action="action.php" class="todo__new">
                    <input name="projectId" type="hidden" value="<?=$key['id']?>">
                    <input name="create" required type="text" placeholder="Start typing here to create a task...">
                    <button>Add Task</button>
                </form>
            </div>
            <div class="todo__list">
                    <?foreach ($key['task'] as $task){
                        ?>
                        <div class="todo__item" id="<?=$task['id']?>">
                            <div class="todo__checkbox">
                                <input onchange="return chageStatus($(this))" <?if($task['status'] == 'yes'){?>checked<?}?> name="chageStatus" type="checkbox">
                            </div>
                            <div class="todo__content <?if($task['status'] == 'yes'){?>checked<?}?>">
                                <div class="text"> <?=$task['name']?></div>
                                <input type="text" required class="content" value="<?=$task['name']?>">
                                <input onclick="saveTask(this);" type="button" value="save">
                            </div>

                            <div class="todo__hidden">
                                <div class="todo__arrows hidden__item">
                                    <img onclick="TaskUp(this)" src="icons/arrow_up.svg" alt="">
                                    <img onclick="TaskDown(this)" src="icons/arrow_down.svg" alt="">
                                </div>
                                <div onclick="editTask(this);"> <img class="todo__pencil hidden__item" src="icons/pencil.svg" alt=""></div>
                                <div onclick="deleteItems(this);">  <img class="todo__delete hidden__item" src="icons/delete.svg" alt=""></div>
                            </div>
                        </div>
                        <?
                    }?>
            </div>
        </div>
    <?}?>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="/js/main.js"></script>
</body>

</html>