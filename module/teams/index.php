<?php

global $pdo;

$data = $pdo->query("SELECT * FROM teams");
$res = $data->fetchAll();


$moduleNav = '';

foreach ($res as $data) { 
    $moduleNav .= '<tr>';
    $moduleNav .= '<td class="team"><a href="./index.php?module=teams&team=' . $data['teamName'] . '">' . $data['teamName'] . '</a>
    </td>';
    $moduleNav .= '<td class="aanvoeder">Minas Abeer</td>';
    $moduleNav .= '</tr>';
}

?>

<p class="teamsintro"> Dit zijn de teams van de Rode Raketten </p> 

<table class="teamsTable">
    <tr>
        <th> Team</th>
        <th> Aanvoeder </th>
    </tr>
    <?= $moduleNav ?>
</table>

<?php

if (isset($_GET['team'])) {
    if (!empty($_GET['team'])) {
        // $path = __DIR__ . DIRECTORY_SEPARATOR . 'module' . DIRECTORY_SEPARATOR . $_GET['module'] . DIRECTORY_SEPARATOR . 'team' . DIRECTORY_SEPARATOR . $_GET['team'] . DIRECTORY_SEPARATOR . 'index.php';
        getTeamData($_GET['team']); 
    } else {
        throw new Exception('Geen team data gevonden!');
    }
}

?>