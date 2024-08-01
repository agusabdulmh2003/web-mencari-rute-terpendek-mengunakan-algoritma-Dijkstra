<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>mencari rute pendek</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>mencari rute terpendek Pemalang</h1>
        <form action="index.php" method="post">
            <label for="start">Awal:</label>
            <select id="start" name="start" required>
                <option value="0">Pemalang</option>
                <option value="1">Taman</option>
                <option value="2">Petarukan</option>
                <option value="3">Bodeh</option>      
            </select>
            <label for="end">Akhir:</label>
            <select id="end" name="end" required>
                <option value="0">Pemalang</option>
                <option value="1">Taman</option>
                <option value="2">Petarukan</option>
                <option value="3">Bodeh</option>
            </select>
            <button type="submit">mulai</button>
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            require 'graph.php';
            $start = (int)$_POST['start'];
            $end = (int)$_POST['end'];

            $graph = new Graph('graf.txt');  //data jarak lokasi
            $graph->dijkstra($start);
            $graph->printPath($end);
        }
        ?>
    </div>
</body>
</html>
