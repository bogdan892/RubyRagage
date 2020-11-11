<?
error_reporting(-1);


//mysql://b362ce4c067b0b:20d49d73@us-cdbr-east-02.cleardb.com/heroku_d4ded68e9f3eab1?reconnect=true
$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = "localhost";
$username = "bogdan892_garage";
$password = "S6&QdaWB";
$db = "bogdan892_garage";

$link = mysqli_connect($server, $username, $password, $db);


//mysqli_select_db($db);
echo '<br>';
if (!$link) {
    echo 'Connected failure<br>';
}else
echo 'Connected successfully<br>';


//$sql = "CREATE TABLE projects  (
//id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
//name VARCHAR(30) NOT NULL,
//status enum('no','yes') NOT NULL,
//project_id int(11) NOT NULL
//)";


//if (mysqli_query($link, $sql)) {
//    echo "Table MyGuests created successfully";
//} else {
//    echo "Error creating table: " . mysqli_error($link);
//}




?>
