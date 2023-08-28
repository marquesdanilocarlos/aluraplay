<?php

require_once __DIR__ . "/vendor/autoload.php";

use Aluraplay\Database\Connection;

$connection = Connection::getInstance();
$query = "SELECT * FROM videos";
$stmt = $connection->prepare($query);
$stmt->execute();

$videos = $stmt->fetchAll();

?>

<?php require_once __DIR__ . "/header.php"; ?>

<ul class="videos__container" alt="videos alura">
    <?php
    foreach ($videos as $video): ?>
        <?php
        if (!str_starts_with($video["url"], "https://")) {
            $video["url"] = "https://www.youtube.com/embed/ABzDOSQkhTM?si=KH74DtTOQYT7Od1D";
        } ?>
        <li class="videos__item">
            <iframe width="100%" height="72%" src="<?= $video["url"]; ?>"
                    title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
            <div class="descricao-video">
                <img src="./img/logo.png" alt="logo canal alura">
                <h3><?= $video["title"]; ?></h3>
                <div class="acoes-video">
                    <a href="editar-video?id=<?= $video["id"]?>">Editar</a>
                    <a href="delete-video.php?id=<?= $video["id"]; ?>">Excluir</a>
                </div>
            </div>
        </li>
    <?php
    endforeach; ?>
</ul>
<?php require_once __DIR__ . "/footer.php"; ?>