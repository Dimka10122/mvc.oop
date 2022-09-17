<?php
/** @var array $allPages */
$userInfo = new \Model\Includes\UserInfo();
?>

<div class="roles-block">
    <?php if ($userInfo->canUser('control_pages')) :?>
        <form>
            <div class="control-panel">
                <div class="control-panel-item">
                    <select class="custom-select" name="change_pages_controller">
                        <option name="controller_field" value="select_option" disabled selected>Select Option</option>
                        <option name="controller_field" value="delete">Delete</option>
                    </select>
                </div>
                <div class="control-panel-item">
                    <button type="button" class="btn btn-primary select-action">Select All</button>
                    <button type="button" class="btn btn-warning select-action">Unselect All</button>
                    <button type="submit" class="btn btn-success" name="apply_select_action">Apply</button>
                </div>
            </div>
        </form>
        <hr>
    <?php endif;?>
    <table class="roles-table">
        <tr class="table-head-row">
            <th class="roles-table-row-head">Title</th>
            <th class="roles-table-row-head">Url</th>
            <?php if ($userInfo->canUser('control_pages')) : ?>
                <th class="roles-table-row-head">Action</th>
                <th class="roles-table-row-head"></th>
            <?php endif;?>
        </tr>
        <?php    foreach ($allPages as $pages) : ?>
            <tr class="roles-table-row ">
                <td class="roles-table-row-data bold"><?= $pages["title"]?></td>
                <td class="roles-table-row-data ">
                    <a href="<?=BASE_URL . $pages["url_key"]?>"><?= $pages["url_key"]?></a>
                </td>

                <?php if ($userInfo->canUser('control_pages')) : ?>
                    <td class="roles-table-row-data">
                        <a class="btn btn-danger" href="<?=BASE_URL?>pages<?=BASE_URL . $pages["id"] . BASE_URL?>delete" >Delete</a>
                        <form action="<?=BASE_URL?>pages<?= BASE_URL . $pages["id"] . BASE_URL?>edit" method="POST">
                            <input type="hidden" name="page_id_data" value="<?= $pages["id"]?>">
                            <input type="hidden" name="page_title_data" value="<?= $pages["title"]?>">
                            <input type="hidden" name="page_url_key_data" value="<?= $pages["url_key"]?>">
                            <button class="btn btn-primary" name="edit_page" type="submit">Edit</button>
                        </form>
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

<script src="assets/js/scripts/modules/select.js"></script>