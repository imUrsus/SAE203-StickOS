<?php
include_once "includes/template.php";
settings(title:"Gestionnaire de fichiers");
// $dir est la variable qui contient le chemin vers 'uploads/'
// $files est un tableau qui contient tous les fichiers dans uploads
// SI VALIDE : il faudra aller chercher dans les différentes sections d'entreprise
// EX : RH, Direction, manager, salarié...

session_start();
$_SESSION['role'] = 'admin';
require_once(__DIR__ . '/includes/clients/functions.php');
require_once(__DIR__ . '/includes/template.php');
// Redirige si l'utilisateur n'a pas de rôle valide
$role = strtolower($_SESSION['role'] ?? '');
$allowed_roles = ['admin', 'manager', 'direction', 'salarie'];

// Permissions en fonction du rôle
$can_view = in_array($role, ['admin', 'manager', 'direction', 'salarie']);
$can_upload = in_array($role, ['admin', 'manager', 'direction']);
$can_delete = in_array($role, ['admin', 'manager']);
// Fonction récursive pour calculer la taille totale d’un dossier
function folderSizeRecursive($dir) {
    $size = 0;
    if (!is_dir($dir)) return 0;
    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS)) as $file) {
        if ($file->isFile()) $size += $file->getSize();
    }
    return $size;
}
head(); 
?>

<h2>Fichiers partagés (.csv / .txt)</h2>
<?php
$totalLimit = 10 * 1024 * 1024 * 1024; // 10 Go
$baseDir = 'includes/drive/uploads/';
$poles = ['depts/hr', 'depts/it', 'depts/management', 'public', 'private'];
$poleLabels = [
    'depts/hr' => 'Ressources Humaines',
    'depts/it' => 'Informatique',
    'depts/management' => 'Direction',
    'public' => 'Partage Public',
    'private' => 'Partage Privé'
];
$usage = [];
foreach ($poles as $pole) {
    $path = $baseDir . $pole . '/';
    $usage[$pole] = folderSizeRecursive($path);
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
        if ($percent < 1 && $size > 0) $percent = 1;
        $mo = round($size / (1024 * 1024), 1);
        $style = "width: {$percent}%; min-width: 2px;";
        $tooltip = "{$poleLabels[$pole]} : {$mo} Mo";
        echo "<div class='progress-bar {$colors[$i % count($colors)]}' role='progressbar' style='$style' title='$tooltip'></div>";
        $i++;
    }
    ?>
</div>

<ul class="list-group mb-3">
    <?php
    $i = 0;
    foreach ($usage as $pole => $size) {
        $label = $poleLabels[$pole] ?? $pole;
        $mo = round($size / (1024 * 1024), 1);
        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
        echo "<span><span class='badge {$colors[$i % count($colors)]} me-2'>&nbsp;</span>$label</span>";
        echo "<span>{$mo} Mo</span>";
        echo "</li>";
        $i++;
    }
    ?>
</ul>

<p><strong>Total utilisé :</strong> <?= round($totalUsed / (1024 * 1024), 1) ?> Mo / 10 240 Mo</p>

<ul class="list-group mb-4">
<?php
$dir = 'includes/drive/uploads/';
if (!is_dir($dir)) mkdir($dir, 0777, true);
$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS));

foreach ($rii as $file) {
    if ($file->isDir()) continue;

    $relativePath = str_replace('\\', '/', substr($file->getPathname(), strlen($dir)));
    $urlPath = urlencode($relativePath);

    $cleanLabel = preg_replace_callback('#^(depts/(hr|it|management)|private|public)#', function ($matches) use ($poleLabels) {
        return $poleLabels[$matches[1]] ?? $matches[1];
    }, $relativePath);

    echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
    echo "<span>$cleanLabel</span>";

    $buttons = "";
    if ($can_view) {
        $buttons .= "<a class='btn btn-sm btn-primary' href='includes/drive/download.php?file=$urlPath'>Télécharger</a>";
    }
    if ($can_delete) {
        $buttons .= "<a class='btn btn-sm btn-danger ms-2' href='includes/drive/delete.php?file=$urlPath'>Supprimer</a>";
    }
    if ($buttons !== "") {
        echo "<span class='d-flex'>$buttons</span>";
    }

    echo "</li>";
}
?>
</ul>
<?php if ($can_upload): ?>
<form action="includes/drive/upload.php" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label class="form-label">Fichier (.csv ou .txt)</label>
        <input type="file" name="file" accept=".csv,.txt" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Destination</label>
        <select name="upload_target" class="form-select" required>
            <option value="public">Partage Public</option>
            <option value="private">Partage Privé</option>
            <option value="depts">Département (RH/IT/Management)</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Uploader</button>
</form>
<?php endif;
foot(); ?>
</body>
</html>
