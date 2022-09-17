<?php /** @var array $pageData */
foreach ($pageData as $page) : ?>
    <h1><?= $page['title']?></h1>
    <p><?= $page['content']?></p>
<?php endforeach;?>
