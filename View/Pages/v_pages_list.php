<?php
/**
 * @var array $allPages
 * @var stdClass $userInfo
 */
?>

<div class="roles-block">
    <?php if ($userInfo->canUser('control_pages')) {
        $events = [
            'edit' => 'Edit',
            'delete' => 'Delete'
        ];
        include 'template/selectMenu.php';
    }?>
    <table class="roles-table">
        <tr class="table-head-row">
            <th class="roles-table-row-head"><?=__('Title')?></th>
            <th class="roles-table-row-head"><?=__('Url')?></th>
            <?php if ($userInfo->canUser('control_pages')) : ?>
                <th class="roles-table-row-head"><?=__('Action')?></th>
                <th class="roles-table-row-head"></th>
            <?php endif;?>
        </tr>
        <?php foreach ($allPages as $pages) : ?>
            <tr class="roles-table-row ">
                <td class="roles-table-row-data bold"><?= $pages["title"]?></td>
                <td class="roles-table-row-data ">
                    <a href="<?=BASE_URL . $pages["url_key"]?>"><?= $pages["url_key"]?></a>
                </td>
                <?php if ($userInfo->canUser('control_pages')) : ?>
                    <td class="roles-table-row-data">
                        <a class="btn btn-danger"
                           href="<?=BASE_URL?>pages<?=BASE_URL . $pages["id"] . BASE_URL?>delete"><?=__('Delete')?>
                        </a>
                        <br>
                        <a class="btn btn-primary mt-2"
                           href="<?=BASE_URL?>pages<?= BASE_URL . $pages["id"] . BASE_URL?>edit"><?=__('Edit')?>
                        </a>
                    </td>
                    <td class="roles-table-row-data">
                        <div class="admin-roles-controller">
                            <input class="controller-select-field" type="checkbox" name="page-info-select[]" id="page_id_<?= $pages["id"]?>" value="<?= $pages["id"]?>">
                        </div>
                    </td>
                <?php endif;?>
            </tr>
        <?php endforeach;?>
    </table>
</div>

<!--<script src="assets/js/scripts/modules/select.js"></script>-->