<?php
/* By Abdullah As-Sadeed */
if(file_exists("DataBase_Details.php")) {
require_once "DataBase_Details.php";
$connection = mysqli_connect($hostname_port, $username, $password, $database);
mysqli_set_charset($connection, $character_set);
if(isset($_GET["download"])) {
$file_name = $database . ".html";
header("Content-Disposition: attachment; filename=$file_name");
};
echo '<!DOCTYPE html>
<html>
<head>
<title>' . $database . '</title>
<style>
table {
border: 1px solid black;
margin-top: 100px;
margin-right: auto;
margin-left: auto;
}
th {
border: 1px solid black;
padding: 3px;
}
td {
border: 1px solid black;
padding: 3px;
text-align: center;
}
</style>
</head>
<body>
';
$tables_query = mysqli_query($connection, "SHOW TABLE STATUS;");
while($table = mysqli_fetch_row($tables_query)) {
$table = $table[0];
echo "<table>
<tbody>
<caption>" . $table . "</caption>
<tr>";
$data_query = mysqli_query($connection, "SELECT * FROM `$table`;");
while ($field = mysqli_fetch_field($data_query)) {
printf("
<th>%s</th>", $field -> name);
};
echo "
</tr>";
while($data = mysqli_fetch_row($data_query)) {
echo "
<tr>";
$counter = 0;
while($counter < mysqli_field_count($connection)) {
if (is_null($data)) {
echo "
<td>
<small>
<i>NULL</i>
</small>
</td>";
} else {
printf("
<td>%s</td>", $data[$counter]);
};
$counter++;
};
echo "
</tr>";
};
echo '
<tr>
<td colspan="' . mysqli_field_count($connection) . '">Entry count: ' . mysqli_num_rows($data_query) . "</td>
</tr>
</tbody>
</table>
";
};
echo "
</body>
</html>";
mysqli_close($connection);
} else {
echo 'The "DataBase_Details.php" file could not be found !';
};
exit();
?>