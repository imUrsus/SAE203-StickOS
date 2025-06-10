<?php
// $dir est la variable qui va contient le chemin dans 'uploads/' 
// $files est un tableau qui contient tous les fichiers dans uploads
//
// SI VALIDE :  il faudra aller chercher dans les differentes sections d'entreprise --//
// EX : RH, Direction, manager, salarie... donc il faudra aller chercher plus loin dans l'arbo
require_once '../includes/login.php';
if (!is_logged_in()) {
    header("Location: login.php");
    exit;
}
// Fonction pour calculer la taille d’un dossier
function folderSize($dir) {
    $size = 0;
    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS)) as $file) {
        if ($file->isFile()) {
            $size += $file->getSize();
        }
    }
    return $size;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Gestionnaire de fichiers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<h2>Fichiers partagés (.csv / .txt)</h2>

<?php
// === BARRE UTILISATION DISQUE PAR PÔLE === //
$totalLimit = 10 * 1024 * 1024 * 1024; // 5 Go
$baseDir = 'uploads/';
$poles = [
    'depts/hr',
    'depts/it',
    'depts/management',
    'public',
    'private' 
];

$usage = [];

foreach ($poles as $pole) {
    $path = $baseDir . $pole . '/';
    $usage[$pole] = is_dir($path) ? folderSize($path) : 0;
}

$totalUsed = array_sum($usage);
$colors = ['bg-primary', 'bg-success', 'bg-warning', 'bg-danger', 'bg-dark', 'bg-info'];
?>

<h4 class="mb-3">Espace utilisé par pôle</h4>

<div class="progress mb-2" style="height: 30px;">
    <?php
    $i = 0;
    foreach ($usage as $pole => $size) {
        $percent = ($totalLimit > 0) ? ($size / $totalLimit) * 100 : 0;
        if ($percent < 1 && $size > 0) $percent = 1; // minimum visible
        $mo = round($size / (1024 * 1024), 1);
        $style = "width: {$percent}%; min-width: 2px;";
        $tooltip = "$pole : {$mo} Mo";
        echo "<div class='progress-bar {$colors[$i % count($colors)]}' role='progressbar' style='$style' title='$tooltip'></div>";
        $i++;
    }
    ?>
</div>

<ul class="list-group mb-3">
    <?php
    $i = 0;
    foreach ($usage as $pole => $size) {
        $mo = round($size / (1024 * 1024), 1);
        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
        echo "<span><span class='badge {$colors[$i % count($colors)]} me-2'>&nbsp;</span>$pole</span>";
        echo "<span>{$mo} Mo</span>";
        echo "</li>";
        $i++;
    }
    ?>
</ul>

<p><strong>Total utilisé :</strong> <?= round($totalUsed / (1024 * 1024), 1) ?> Mo / 5120 Mo</p>

<ul class="list-group mb-4">
<?php
$dir = 'uploads/';

if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}

$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

foreach ($rii as $file) {
    if ($file->isDir()) continue;

    $relativePath = str_replace('\\', '/', substr($file->getPathname(), strlen($dir)));
    $urlPath = urlencode($relativePath);
    
    echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
    echo "<span>$relativePath</span>";
$buttons = "";

if (has_permission('view')) {
    $buttons .= "<a class='btn btn-sm btn-primary' href='download.php?file=$urlPath'>Télécharger</a>";
}

if (has_permission('delete')) {
    $buttons .= "<a class='btn btn-sm btn-danger ms-2' href='delete.php?file=$urlPath'>Supprimer</a>";
}

if ($buttons !== "") {
    echo "<span class='d-flex'>$buttons</span>"; // evite balise html vide si aucune permission
}

    echo "</li>";
}
?>
</ul>
<?php if (has_permission('upload')): ?>
<form action="upload.php" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label class="form-label">Fichier (.csv ou .txt)</label>
        <input type="file" name="file" accept=".csv,.txt" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Destination</label>
        <select name="upload_target" class="form-select" required>
            <option value="public">Public</option>
            <option value="private">Privé (utilisateur)</option>
            <option value="depts">Département (RH/IT/Management)</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Uploader</button>
</form>
<?php endif; ?>

</body>
</html>
