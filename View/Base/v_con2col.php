<?php
/** @var TYPE_NAME $title
  * @var TYPE_NAME $left
  * @var TYPE_NAME $content */
?>

<div class="row">
    <aside class="col col-12 col-md-3">
        <?= $left?>
    </aside>
    <main class="col col-12 col-md-9">
        <h1><?= $title?></h1>
        <hr>
        <?= $content?>
    </main>
</div>