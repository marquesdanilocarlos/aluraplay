<?php
$this->layout("layout");
?>
    <ul class="videos__container" alt="videos alura">
        <?php
        foreach ($videos as $video): ?>
            <li class="videos__item">
                <?php
                if (!$video->getImagePath()): ?>
                    <iframe width="100%" height="72%" src="<?= $video->getUrl(); ?>"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                <?php
                endif; ?>
                <?php
                if ($video->getImagePath()): ?>
                    <a href="<?= $video->getUrl(); ?>">
                        <img src="<?= $video->getImagePath() ?>" alt="image" style="width: 100%;"/>
                    </a>
                <?php
                endif; ?>
                <div class="descricao-video">
                    <img src="/img/logo.png" alt="logo canal alura">
                    <h3><?= $video->title; ?></h3>
                    <div class="acoes-video">
                        <a href="editar-video?id=<?= $video->id ?>">Editar</a>
                        <a href="deletar-video?id=<?= $video->id; ?>">Excluir</a>
                    </div>
                </div>
            </li>
        <?php
        endforeach; ?>
    </ul>