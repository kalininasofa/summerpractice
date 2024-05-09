<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insurance  Database</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <a href="index.php">Запросы в бд</a>
        <a href="showtable.php">Посмотреть бд</a>
    </header>

    <h1>Insurance Database</h1>

    <form action="result.php" method="post">
        <label for="query">Выберите запрос:</label>
        <select name="query" id="query">
            <option value="0" disabled selected>Выберите запрос</option>
            <option value="1">1. Вывести иформацию о клиентах с некоторой фамилией.</option>
            <option value="2">2. Вывести информацию о страховых агентах, процент вознаграждения которых находится в диапазоне.</option>
            <option value="3">3. Вывести информацию о договорах, где сумма страхования не меньше n руб.</option>
            <option value="4">4. Вывести информацию о страховых агентах с некоторой фамилией.</option>
            <option value="5">5. Вывести информацию о договорах, заключенных в некоторый период времени.</option>
            <option value="6">6. Вывести размеры страховой премии.</option>
            <option value="7">7. Вывести среднее значение суммы страхования.</option>
            <option value="8">8. Вывести минимальное и максимальное значения сумма страхования.</option>
            <option value="9">9. Вывести информацию о клиентах со скидкой.</option>
        </select>
        <br>

        <?php
        include("dbconnect.php");

        // 1
        $sql_query = "SELECT * FROM CLIENTS;";
        $stmt = $db->prepare($sql_query);
        $stmt->execute();
        $clients = $stmt->fetchAll();
        ?>

        <div id="inputs"></div>

        <input type="submit" name="submit" value="submit">
    </form>

    <script>
        document.getElementById("query").addEventListener("change", function() {
            var query = this.value;
            var inputsDiv = document.getElementById("inputs");
            inputsDiv.innerHTML = "";

            if (query === "1") {
                inputsDiv.innerHTML = `
                    <label for="client_lastname">Фамилия:</label>
                    <input type="text" name="client_lastname" id="client_lastname" required>
                    <br>
                `;
            } else if (query === "2") {
                inputsDiv.innerHTML = `
                    <label for="min_commission">Нижний диапазон:</label>
                    <input type="number" name="min_commission" id="min_commission" min="0" required>
                    <br>
                    <label for="max_commission">Верхний диапазон:</label>
                    <input type="number" name="max_commission" id="max_commission" min="0" required>
                    <br>
                `;
            } else if (query === "3") {
                inputsDiv.innerHTML = `
                    <label for="insurance_amount">Минимальная сумма страхования:</label>
                    <input type="number" name="insurance_amount" id="insurance_amount" min="0" required>
                    <br>
                `;
            } else if (query === "4") {
                inputsDiv.innerHTML = `
                    <label for="agent_lastname">Фамилия:</label>
                    <input type="text" name="agent_lastname" id="agent_lastname" required>
                    <br>
                `;
            } else if (query === "5") {
                inputsDiv.innerHTML = `
                    <label for="min_date">Нижний диапазон:</label>
                    <input type="date" name="min_date" id="min_date" required>
                    <br>
                    <br>
                    <label for="max_date">Верхний диапазон:</label>
                    <input type="date" name="max_date" id="max_date" required>
                    <br>
                    <br>
                `;
            } else if (query === "9") {
                inputsDiv.innerHTML = `
                    <label for="discount">Процент скидки:</label>
                    <input type="text" name="discount" id="discount" required>
                    <br>
                `;
            }
        });

        document.addEventListener("DOMContentLoaded", function() {
        var query = document.getElementById("query").value;
        var inputsDiv = document.getElementById("inputs");

        if (query === "1") {
                inputsDiv.innerHTML = `
                    <label for="client_lastname">Фамилия:</label>
                    <input type="text" name="client_lastname" id="client_lastname" required>
                    <br>
                `;
            } else if (query === "2") {
                inputsDiv.innerHTML = `
                    <label for="min_commission">Нижний диапазон:</label>
                    <input type="number" name="min_commission" id="min_commission" min="0" required>
                    <br>
                    <label for="max_commission">Верхний диапазон:</label>
                    <input type="number" name="max_commission" id="max_commission" min="0" required>
                    <br>
                `;
            } else if (query === "3") {
                inputsDiv.innerHTML = `
                    <label for="insurance_amount">Минимальная сумма страхования:</label>
                    <input type="number" name="insurance_amount" id="insurance_amount" min="0" required>
                    <br>
                `;
            } else if (query === "4") {
                inputsDiv.innerHTML = `
                    <label for="agent_lastname">Фамилия:</label>
                    <input type="text" name="agent_lastname" id="agent_lastname" required>
                    <br>
                `;
            } else if (query === "5") {
                inputsDiv.innerHTML = `
                    <label for="min_date">Нижний диапазон:</label>
                    <input type="date" name="min_date" id="min_date" required>
                    <br>
                    <label for="max_date">Верхний диапазон:</label>
                    <input type="date" name="max_date" id="max_date" required>
                    <br>
                `;
            } else if (query === "6") {
                inputsDiv.innerHTML = `
                    <label for="contract_date">Дата заключения договора:</label>
                    <input type="date" name="contract_date" id="contract_date" required>
                    <label for="client_name">ФИО клиента:</label>
                    <select name="client_name" id="client_name" required>
                        <?php foreach ($clients as $client): ?>
                            <option value="<?php echo $client['client_id']; ?>"><?php echo $client['client_name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="insurance_amount">Сумма страхования:</label>
                    <input type="number" name="insurance_amount" id="insurance_amount" min="0" required>
                    <br>
                `;
            } else if (query === "9") {
                inputsDiv.innerHTML = `
                    <label for="discount">Процент скидки:</label>
                    <input type="text" name="discount" id="discount" required>
                    <br>
                `;
            }
        });
    </script>
</body>
</html>
