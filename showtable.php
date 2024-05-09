<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Tables</title>
    <link rel="stylesheet" href="table.css">
</head>
<body>
    <header>
        <a href="index.php">Запросы в бд</a>
        <a href="showtable.php">Посмотреть бд</a>
    </header>
    <div class="maincontent">
<?php
include 'dbconnect.php';

try {
    $tables = array("CLIENTS", "AGENTS", "INSURANCE", "CONTRACTS");

    foreach ($tables as $table_name) {
        echo "<h2>$table_name</h2>";

        $content_query = "SELECT * FROM $table_name";
        $content_result = $db->query($content_query);

        if ($content_result->rowCount() > 0) {
            echo "<table>";
            echo "<tr>";
            $columns = [];
            while ($row = $content_result->fetch(PDO::FETCH_ASSOC)) {
                if (empty($columns)) {
                    echo "<tr>";
                    foreach ($row as $key => $value) {
                        echo "<th>$key</th>";
                        $columns[] = $key;
                    }
                    echo "</tr>";
                }

                if ($table_name === "CONTRACTS") {
                    $row = replaceIdsWithNames($db, $row, "client_id", "CLIENTS", "client_name");
                    $row = replaceIdsWithNames($db, $row, "agent_id", "AGENTS", "agent_name");
                }

                echo "<tr>";
                foreach ($columns as $column) {
                    echo "<td>" . $row[$column] . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Table is empty.";
        }
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

function replaceIdsWithNames($db, $row, $id_column, $table_name, $name_column) {
    $id = $row[$id_column];
    $query = "SELECT $name_column FROM $table_name WHERE $id_column = :id";
    $statement = $db->prepare($query);
    $statement->bindParam(":id", $id);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $name = $result[$name_column];
    $row[$id_column] = $name;
    return $row;
}
?>

</div>
</body>
</html>
