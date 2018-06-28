<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "snowkeld";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";
$res = $conn->query("SELECT table_name FROM information_schema.tables
WHERE table_schema = '$database';");
while($table = $res->fetch_assoc())
{
    $model = "<?php\n# Model for table ".$table["table_name"]."\nclass ".$table["table_name"]."\n{\n";
    $cols = $conn->query("SELECT `COLUMN_NAME` 
    FROM `INFORMATION_SCHEMA`.`COLUMNS` 
    WHERE `TABLE_SCHEMA`='$database' 
        AND `TABLE_NAME`='".$table["table_name"]."';");
    while($col = $cols->fetch_assoc())
    {
        $model .= "\tpublic \$".$col["COLUMN_NAME"].";\n";
    }
    $model .= "}\n?>";
    file_put_contents("Models/".$table["table_name"].".php", $model);
    echo $model;
}
?>