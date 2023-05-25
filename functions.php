<?php
    require 'config.php';

    function getTeamData($team) {
        global $pdo;

        $data = $pdo->prepare("SELECT teamData FROM teams WHERE teamName = :team");
        $data->bindParam(':team', $team);
        $data->execute();
        $res = $data->fetchAll();

        foreach ($res as $row) {
            echo  "<p>" . $row['teamData'] . "</p>";
        }
    }

?>