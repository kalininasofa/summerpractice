<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Query Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }
        .maincontent {
            padding: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }
        header {
            background-color: #ffae00;
            color: white;
            padding: 10px 0;
            text-align: center;
        }
        header a {
            display: inline-block;
            padding: 10px 20px;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        header a:hover {
            background-color: #bd8815;
        }

    </style>
</head>
<body>
    <header>
        <a href="index.php">Запросы в бд</a>
        <a href="showtable.php">Посмотреть бд</a>
    </header>
    <div class="maincontent">
<?php

include("dbconnect.php");

$query = $_POST['query'];

if ($query === "1") {
   
    $client_lastname = $_POST['client_lastname'];
    
    $sql_query = "SELECT * FROM CLIENTS WHERE client_name LIKE ?;";
    
    $stmt = $db->prepare($sql_query);
    $stmt->execute([$client_lastname]);
    
    $result = $stmt->fetchAll();
    
    if (count($result) > 0) {
        echo "<table>";
        echo "<tr>";
        echo "<th>ID</th>";
        echo "<th>ФИО клиента</th>";
        echo "<th>Размер скидки (%)</th>";
        echo "</tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row['client_id'] . "</th>";
            echo "<td>" . $row['client_name'] . "</td>";
            echo "<td>" . $row['discount'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Ничего не найдено.";
    }
    
} elseif ($query === "2") {

    $min_commission = $_POST['min_commission'];
    $max_commission = $_POST['max_commission'];
    
    $sql_query = "SELECT * FROM AGENTS WHERE commission BETWEEN ? AND ?;";

    $stmt = $db->prepare($sql_query);
    $stmt->execute([$min_commission, $max_commission]);

    $result = $stmt->fetchAll();

    if (count($result) > 0) {
        echo "<table>";
        echo "<tr>";
        echo "<th>ID</th>";
        echo "<th>ФИО агента</th>";
        echo "<th>Размер комиссионных (%)</th>";
        echo "</tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row['agent_id'] . "</th>";
            echo "<td>" . $row['agent_name'] . "</td>";
            echo "<td>" . $row['commission'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Ничего не найдено.";
    }

} elseif ($query === "3") {
    
    $insurance_amount = $_POST['insurance_amount'];
    
    $sql_query = "SELECT * FROM CONTRACTS WHERE insurance_amount >= ?";

    $stmt = $db->prepare($sql_query);
    $stmt->execute([$insurance_amount]);

    $result = $stmt->fetchAll();

    $sql_query = "SELECT * FROM CLIENTS";
    $stmt = $db->prepare($sql_query);
    $stmt->execute();
    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $client_names = [];
    foreach ($clients as $client) {
        $client_names[$client['client_id']] = $client['client_name'];
    }

    $sql_query = "SELECT * FROM AGENTS";
    $stmt = $db->prepare($sql_query);
    $stmt->execute();
    $agents = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $agent_names = [];
    foreach ($agents as $agent) {
        $agent_names[$agent['agent_id']] = $agent['agent_name'];
    }

    $sql_query = "SELECT * FROM INSURANCE";
    $stmt = $db->prepare($sql_query);
    $stmt->execute();
    $insurances = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $insurance_names = [];
    foreach ($insurances as $insurance) {
        $insurance_names[$insurance['insurance_id']] = $insurance['insurance_name'];
    }

    if (count($result) > 0) {
        echo "<table>";
        echo "<tr>";
        echo "<th>ID</th>";
        echo "<th>ФИО клиента</th>";
        echo "<th>ФИО агента</th>";
        echo "<th>Страховая сумма</th>";
        echo "<th>Вид страховки</th>";
        echo "<th>Дата начала страхования</th>";
        echo "</tr>";
        
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row['contract_id'] . "</td>";
            echo "<td>" . $client_names[$row['client_id']] . "</td>";
            echo "<td>" . $agent_names[$row['agent_id']] . "</td>";
            echo "<td>" . $row['insurance_amount'] . "</td>";
            echo "<td>" . $insurance_names[$row['insurance_id']] . "</td>";
            echo "<td>" . $row['contract_date'] . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    } else {
        echo "Ничего не найдено.";
    }

} elseif ($query === "4") {
    
    $agent_lastname = $_POST['agent_lastname'];
    
    $sql_query = "SELECT * FROM AGENTS WHERE agent_name LIKE ?;";

    $stmt = $db->prepare($sql_query);
    $stmt->execute([$agent_lastname]);

    $result = $stmt->fetchAll();

    if (count($result) > 0) {
        echo "<table>";
        echo "<tr>";
        echo "<th>ID</th>";
        echo "<th>ФИО агента</th>";
        echo "<th>Размер комиссионных (%)</th>";
        echo "</tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row['agent_id'] . "</th>";
            echo "<td>" . $row['agent_name'] . "</td>";
            echo "<td>" . $row['commission'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {    
        echo "Ничего не найдено.";
    }

} elseif ($query === "5") {
    
    $min_date = $_POST['min_date'];
    $max_date = $_POST['max_date'];
    
    $sql_query = "SELECT * FROM CONTRACTS WHERE contract_date BETWEEN ? AND ?";

    $stmt = $db->prepare($sql_query);
    $stmt->execute([$min_date, $max_date]);

    $result = $stmt->fetchAll();

    $sql_query = "SELECT * FROM CLIENTS";
    $stmt = $db->prepare($sql_query);
    $stmt->execute();
    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $client_names = [];
    foreach ($clients as $client) {
        $client_names[$client['client_id']] = $client['client_name'];
    }

    $sql_query = "SELECT * FROM AGENTS";
    $stmt = $db->prepare($sql_query);
    $stmt->execute();
    $agents = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $agent_names = [];
    foreach ($agents as $agent) {
        $agent_names[$agent['agent_id']] = $agent['agent_name'];
    }

    $sql_query = "SELECT * FROM INSURANCE";
    $stmt = $db->prepare($sql_query);
    $stmt->execute();
    $insurances = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $insurance_names = [];
    foreach ($insurances as $insurance) {
        $insurance_names[$insurance['insurance_id']] = $insurance['insurance_name'];
    }

    if (count($result) > 0) {
        echo "<table>";
        echo "<tr>";
        echo "<th>ID</th>";
        echo "<th>ФИО клиента</th>";
        echo "<th>ФИО агента</th>";
        echo "<th>Страховая сумма</th>";
        echo "<th>Вид страховки</th>";
        echo "<th>Дата начала страхования</th>";
        echo "</tr>";
        
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row['contract_id'] . "</td>";
            echo "<td>" . $client_names[$row['client_id']] . "</td>";
            echo "<td>" . $agent_names[$row['agent_id']] . "</td>";
            echo "<td>" . $row['insurance_amount'] . "</td>";
            echo "<td>" . $insurance_names[$row['insurance_id']] . "</td>";
            echo "<td>" . $row['contract_date'] . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    } else {    
        echo "Ничего не найдено.";
    }

} elseif ($query === "6") {

    $sql_query = "SELECT
        C.contract_date, CL.client_name, C.insurance_amount, 
        (C.insurance_amount * (I.tariff - CL.discount)) AS Insurance_Premium
        FROM CONTRACTS C
        JOIN CLIENTS CL ON C.client_id = CL.client_id
        JOIN INSURANCE I ON C.insurance_id = I.insurance_id;
    ";

    $stmt = $db->prepare($sql_query);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<table>";
    echo "<tr>";
    echo "<th>Дата начала страхования</th>";
    echo "<th>ФИО клиента</th>";
    echo "<th>Сумма страхования</th>";
    echo "<th>Страховая премия</th>";
    echo "</tr>";

    foreach ($result as $row) {
        echo "<tr>";
        echo "<td>" . $row['contract_date'] . "</td>";
        echo "<td>" . $row['client_name'] . "</td>";
        echo "<td>" . $row['insurance_amount'] . "</td>";
        echo "<td>" . abs($row['Insurance_Premium']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
    
} elseif ($query === "7") {

    $sql_query = "SELECT A.agent_name, AVG(C.insurance_amount) AS avg_insurance_amount
        FROM CONTRACTS C
        JOIN AGENTS A ON C.agent_id = A.agent_id
        GROUP BY A.agent_name;
    ";

    $stmt = $db->prepare($sql_query);
    $stmt->execute();

    $result = $stmt->fetchAll();

    echo "<table>";
    echo "<tr>";
    echo "<th>ФИО агента</th>";
    echo "<th>Средняя сумма страхования</th>";
    echo "</tr>";

    foreach ($result as $row) {
        echo "<tr>";
        echo "<td>" . $row['agent_name'] . "</td>";
        echo "<td>" . $row['avg_insurance_amount'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";

} elseif ($query === "8") {
    
    $sql_query = "SELECT 
    contract_date, MIN(insurance_amount) AS min_insurance_amount, MAX(insurance_amount) AS max_insurance_amount
    FROM CONTRACTS
    GROUP BY contract_date;
    ";

    $stmt = $db->prepare($sql_query);
    $stmt->execute();

    $result = $stmt->fetchAll();

    echo "<table>";
    echo "<tr>";
    echo "<th>Дата начала страхования</th>";
    echo "<th>Минимальная сумма страхования</th>";
    echo "<th>Максимальная сумма страхования</th>";
    echo "</tr>";

    foreach ($result as $row) {
        echo "<tr>";
        echo "<td>" . $row['contract_date'] . "</td>";
        echo "<td>" . $row['min_insurance_amount'] . "</td>";
        echo "<td>" . $row['max_insurance_amount'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} elseif ($query === "9") {
    
    $discount = $_POST['discount'];

    $sql_query = "SELECT * FROM CLIENTS WHERE discount = ?;";

    $stmt = $db->prepare($sql_query);
    $stmt->execute([$discount]);

    $result = $stmt->fetchAll();

    if (count($result) > 0) {
        echo "<table>";
        echo "<tr>";
        echo "<th>ID</th>";
        echo "<th>ФИО клиента</th>";
        echo "<th>Размер скидки (%)</th>";
        echo "</tr>";

        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row['client_id'] . "</td>";
            echo "<td>" . $row['client_name'] . "</td>";
            echo "<td>" . $row['discount'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "Ничего не найдено.";
    }
}
?>
</div>
</body>
</html>