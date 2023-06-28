<?php
    require 'config.php';

    function getTeamData($team) {
        global $pdo;

        $data = $pdo->prepare("SELECT teamData, img FROM teams WHERE teamName = :team");
        $data->bindParam(':team', $team);
        $data->execute();
        $res = $data->fetchAll();

        foreach ($res as $row) {
            echo  "<p>" . $row['teamData'] . "</p>";
            if (isset($row["img"])) {
                echo "<img src='$row[img]' width='125' height='125'>";
            } else {
                echo "No image";
            }
        }
    }

    function getContent($page) 
    {
        global $pdo;

        $data = $pdo->query("SELECT content.page_content, content.img FROM content JOIN module ON content.moduleID = module.moduleID WHERE module.pagina = '$page';");
        $res = $data->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($res as $index => $row) {
            echo '<p>' . $row['page_content'] . '</p>';
        }
    }

    function rrmdir($src) {
        $dir = opendir($src);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                $full = $src . '/' . $file;
                if ( is_dir($full) ) {
                    rrmdir($full);
                }
                else {
                    unlink($full);
                }
            }
        }
        closedir($dir);
        rmdir($src);
    }
?>