<?php
declare(strict_types=1);
/**
 * @by ProfStep, inc. 23.12.2020
 * @website: https://profstep.com
 **/

/**
 * @param array $target (associate array)
 * @param array $fields (list of fields)
 * @return array
 */

function extractFields(array $target, array $fields): array {
    $arrayResult = [];

    foreach ($fields as $field) {
        $arrayResult[$field] = !is_null($target[$field])?trim($target[$field]):'';
    }

    return $arrayResult;
}