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
                echo "<img src='img/$row[img]' width='125' height='125'>";
            } else {
                echo "No image";
            }
        }
    }

    function getContent($page) 
    {
        global $pdo;

        $stmt = $pdo->prepare("SELECT page_content FROM content JOIN module ON content.moduleID = module.moduleID WHERE module.pagina = :page");
        $stmt->bindParam(':page', $page);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result === false) {
            echo "<p>No content found for $page</p>";
            return;
        }

        $content = $result['page_content'];

        echo $content;
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