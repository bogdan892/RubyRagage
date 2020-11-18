<?php
include_once ('connect.php');
error_reporting(-1);

if(!empty($_REQUEST['DownUp'] or $_REQUEST['Downtask'] )){
    $sql="SELECT * FROM `tasks` WHERE `id` = $_REQUEST[DownUp]" ;
    $result=mysqli_query($link,$sql);
    while($row = mysqli_fetch_assoc($result)) {
        $element= $row['sort'];

    }
    $sql="SELECT * FROM `tasks` WHERE `id` = $_REQUEST[Downtask]" ;
    $result=mysqli_query($link,$sql);
    while($row = mysqli_fetch_assoc($result)) {
        $UpElement= $row['sort'];
    }
    $sql ="UPDATE `tasks` SET `sort` = $UpElement WHERE `tasks`.`id` = $_REQUEST[DownUp]";
    $result=mysqli_query($link,$sql);
    $sql ="UPDATE `tasks` SET `sort` = $element WHERE `tasks`.`id` = $_REQUEST[Downtask]";
    $result=mysqli_query($link,$sql);
    if ($result){
        updateItems();
    }
}
if(!empty($_REQUEST['TaskUp'] or $_REQUEST['Uppertask'] )){
    $sql="SELECT * FROM `tasks` WHERE `id` = $_REQUEST[TaskUp]" ;
    $result=mysqli_query($link,$sql);
    while($row = mysqli_fetch_assoc($result)) {
        $element= $row['sort'];
    }
    $sql="SELECT * FROM `tasks` WHERE `id` = $_REQUEST[Uppertask]" ;
    $result=mysqli_query($link,$sql);
    while($row = mysqli_fetch_assoc($result)) {
        $UpElement= $row['sort'];
    }

    $sql ="UPDATE `tasks` SET `sort` = $UpElement WHERE `tasks`.`id` = $_REQUEST[TaskUp]";
    $result=mysqli_query($link,$sql);
    $sql ="UPDATE `tasks` SET `sort` = $element WHERE `tasks`.`id` = $_REQUEST[Uppertask]";
    $result=mysqli_query($link,$sql);

    if ($result){
        updateItems();
    }
}

if(!empty($_REQUEST['editProject'])){
    $sql ="UPDATE `projects` SET `name` = '$_REQUEST[editProject]' WHERE `projects`.`id` = '$_REQUEST[editProjectId]'";
    $result=mysqli_query($link,$sql);
    if ($result){
        updateItems();
    }
}
//if(!empty($_REQUEST['editTask'])){
//    $sql ="UPDATE `tasks` SET `name` = '$_REQUEST[editTask]', `DATE` = '$_REQUEST[dateTask]' WHERE `tasks`.`id` = '$_REQUEST[editTaskId]'";
//    $result=mysqli_query($link,$sql);
//    if ($result){
//        updateItems();
//    }
//}
if(!empty($_REQUEST['editTask'])){
    $sql ="UPDATE `tasks` SET `name` = '$_REQUEST[editTask]'  WHERE `tasks`.`id` = '$_REQUEST[editTaskId]'";
    $result=mysqli_query($link,$sql);
    if ($result){
        updateItems();
    }
}

if(!empty($_REQUEST['statusYes'])){
    $sql="UPDATE `tasks` SET `status` = 'yes' WHERE `tasks`.`id` = '$_REQUEST[statusYes]'";
    $result=mysqli_query($link,$sql);
    if ($result){
       updateItems();
    }
}
if(!empty($_REQUEST['statusNo'])){
    $sql="UPDATE `tasks` SET `status` = 'no' WHERE `tasks`.`id` = $_REQUEST[statusNo]";
    $result=mysqli_query($link,$sql);
    if ($result){
        updateItems();
    }
}

if(!empty($_REQUEST['createTask'])){
    $ProjectDate = $_REQUEST['ProjectDate'];
    function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
    $query  = "SELECT auto_increment FROM information_schema.tables WHERE table_name='tasks';";
    $result = $link->query($query);
    while ($row = $result->fetch_assoc()) {
        $auto_increment = ($row['auto_increment']);
    }
    if(validateDate($ProjectDate)){
        $sql="INSERT INTO `tasks` (`id`, `name` ,`project_id`,`sort`,`DATE`) VALUES (NULL, '$_REQUEST[createTask]' , '$_REQUEST[ProjectID]' , '$auto_increment', '$_REQUEST[ProjectDate]');";
        $result=mysqli_query($link,$sql);
        if ($result){
            updateItems();
        }
    }else{
        echo "<p class='error'></p>";
    }
}



//UPDATE `tasks` SET `status` = 'yes' WHERE `tasks`.`id` = 26;
if(!empty($_REQUEST['createProject'])){
$sql="INSERT INTO `projects` (`id`, `name`) VALUES (NULL, '$_REQUEST[createProject]');";
$result=mysqli_query($link,$sql);
if ($result){
    updateItems();
}
}

if(!empty($_REQUEST['deleteProject'])){
    $sql="DELETE FROM `projects` WHERE `projects`.`id` = $_REQUEST[deleteProject]" ;
    $result=mysqli_query($link,$sql);
    if ($result){
        updateItems();
    }
}
if(!empty($_REQUEST['deleteTask'])){
    $sql="DELETE FROM `tasks` WHERE `tasks`.`id` = $_REQUEST[deleteTask]"  ;
    $result=mysqli_query($link,$sql);
    if ($result){
        updateItems();
    }
}


function updateItems(){
    $server = "localhost";
    $username = "bogdan892_garage";
    $password = "S6&QdaWB";
    $db = "bogdan892_garage";

    $link = mysqli_connect($server, $username, $password, $db);
    $sql="SELECT * FROM `projects` ORDER BY `id` DESC";
    $result=mysqli_query($link,$sql);
    while($row = mysqli_fetch_array($result))
    {
        $arResult['projects'][] = array(
            'id' =>   $row['id'],
            'name' =>  $row['name'],
        );

    }
    foreach ($arResult['projects'] as $key  =>$project ){
        $sql2='SELECT * FROM `tasks` WHERE `project_id` = '.$project[id].' ORDER BY `sort` DESC';
        $result=mysqli_query($link,$sql2);
        while($row = mysqli_fetch_assoc($result)) {
            $arResult['projects'][$key]['task'][] = array(
                'id' =>   $row['id'],
                'name' =>  $row['name'],
                'status' =>  $row['status'],
                'project_id' =>  $row['project_id'],
                'date' =>  $row['DATE'],
            );
        }

    }
    ?>
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
                    <form style="display: contents;" onsubmit="return addTask(this);" action="action.php" class="todo__new">
                        <input name="projectId" type="hidden" value="<?=$key['id']?>">
                        <input class="name" name="create" required type="text" placeholder="Start typing here to create a task...">
                        <input  autocomplete="off" class="date" name="date" required type="text" placeholder="Start typing here to create a task...">
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

                            <div class="todo__text">
                                <div class="text">
                                    <?=$task['name']?>
                                </div>
                                <input type="text" required class="content" value="<?=$task['name']?>">
                            </div>

                            <form class="todo__content <?if($task['status'] == 'yes'){?>checked<?}?>">
                                <p style="margin-right:  5px">
                                    <img width="15" height="15" src="icons/calendar.svg" alt="" class="">
                                </p>
                                <div class="text">
                                    <?if(!empty($task['date'])){
                                        echo $task['date'];
                                    }
                                    else{
                                        echo'Write Date';
                                    }
                                    ?>
                                </div>
                                <div class="date">
                                    <input type="text" required class="content datepicker" value="<?=$task['date']?>">
                                </div>

                                <input onclick="saveTask(this);" type="button" value="save">

                            </form>

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
    <?
}
?>