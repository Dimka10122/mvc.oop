<?php
/** @var array $events */
?>

<div class="control-panel">
    <div class="control-panel-item">
        <select class="custom-select" name="change_user_controller">
            <option name="controller_field" value="select_option" disabled selected>
                <?=__('Select Option')?>
            </option>
            <?php foreach ($events as $eventValue => $eventName) : ?>
                <option name="controller_field" value="<?=$eventValue?>">
                    <?=__($eventName)?>
                </option>
            <?php endforeach;?>
        </select>
    </div>

    <div class="control-panel-item control-panel-item-right">
        <div class="select-dropdown">
            <span class="nav-link dropdown-toggle"
                  id="navbarDropdown"
                  role="button"
                  data-bind="click: dropdownViewModel.switchDropdown, text: dropdownViewModel.action">
                <?=__('Select List')?>
            </span>
            <div class="dropdown-menu"
                 aria-labelledby="navbarDropdown"
                 data-bind="visible: dropdownViewModel.isActive, foreach: dropdownViewModel.actions">
                <span class="nav-link dropdown-item"
                      data-bind="
                          text: $data,
                          click: function(e) {
                               $parent.dropdownViewModel.chooseAction(e) ?
                                    $parent.dropdownViewModel.selectMoreItems($parent.paginationViewModel.allItems()) :
                                    $parent.dropdownViewModel.selectMoreItems($parent.paginationViewModel.currentItems())
                          }"></span>
            </div>
        </div>
        <button name="select-action" type="submit" class="btn btn-success"><?=__('Apply')?></button>
    </div>
</div>

<!--$parent.dropdownViewModel.getItems($parent.paginationViewModel.allItems) :-->
<!--$parent.dropdownViewModel.getItems($parent.paginationViewModel.currentItems),-->
<!--                         -->