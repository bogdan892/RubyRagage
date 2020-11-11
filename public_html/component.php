<?
if($link)
{
    $sql="SELECT * FROM `projects` ORDER BY `id` DESC";
    $result=mysqli_query($link,$sql);
    while($row = mysqli_fetch_array($result))
    {
        $arResult['projects'][] = array(
            'id' =>   $row['id'],
            'name' =>  $row['name'],
        );

    }
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
        );
    }
}
?>