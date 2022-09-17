<?php
/** @var string $statsData */
/** @var array $statsTypes */
/** @var array $statsTimes */
/** @var array $fields */
?>

<form action="" method="POST">
    <div class="row control-panel">
        <div class="col-6 text-center control-panel-item">
            <div class="card-block">
                <select class="custom-select mb-2" name="change_chart_controller">
                    <?php foreach ($statsTypes as $key => $value) :?>
                        <option name="controller_field" value="<?= $key?>" <?php if(in_array($key ,$fields)): ?>selected<?endif?>>
                            <?= $value?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <select class="custom-select" name="change_time_gap_controller">
                    <?php foreach ($statsTimes as $key => $value) :?>
                        <option name="controller_field" value="<?= $key?>" <?php if(in_array($key ,$fields)): ?>selected<?endif?>>
                            <?= $value?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <br>
                <button type="submit" class="mt-3 btn btn-success" name="apply_request">Apply</button>
            </div>
        </div>
        <div class="col-6 control-panel-item">
            <canvas id="chart-field"></canvas>
        </div>
    </div>
    <hr>
</form>

<script>
    require([
        'assets/js/scripts/modules/stats'
    ], function (stats) {
        stats(<?= $statsData[0]["count"]?>)
    });
</script>