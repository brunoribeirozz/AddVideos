<?php

use Alura\Mvc\Entity\Video;

require_once __DIR__ . '/inicio-html.php';
/** @var Video[] $videoList */
?>

<ul class="videos__container">
    <?php foreach ($videoList as $video): ?>
        <li class="videos__item">
            <?php if ($video->getFilePath() !== null): ?>
            <a href="<?= $video->url;  ?>">
                <img src="/img/uploads/<?= $video->getFilePath(); ?>" alt="" style="width: 100%"/>
            </a>
                <a href="/remover-thumbnail?id=<?= $video->id; ?>" onclick="return confirm('Tem certeza que quer remover a thumb?');" class="botao_remover">Remover Thumbnail</a>


            <?php else: ?>
            <iframe width="100%" height="72%" src="<?= $video->url; ?>"
                    title="YouTube video player"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>

            <?php endif; ?>
            <div class="descricao-video">
                <h3><?= $video->title; ?></h3>
                <div class="acoes-video">
                    <a href="/editar-video?id=<?= $video->id; ?>">Editar</a>
                    <a href="/remover-video?id=<?= $video->id; ?>">Excluir</a>
                </div>
            </div>
        </li>
    <?php endforeach; ?>
</ul>

<?php require_once __DIR__ . '/fim-html.php';