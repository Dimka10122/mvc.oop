<?php

declare(strict_types=1);
/**
 * @by ProfStep, inc. 23.12.2020
 * @website: https://profstep.com
 **/


/**
 * @function will translate from file mask en_{ln}.csv
 * @param string $string
 * @return string
 */
function __(string $string): string
{
    $ln = $_GET['ln'] ?? false;
    $file = "en_$ln.csv";

    if ($ln && $_SESSION['ln'] != $ln || !isset($_SESSION['translate'])) {
        if (file_exists($file)) {
            $_SESSION['ln'] = $ln;
            $_SESSION['translate'] = file($file);
        } else {
            unset($_SESSION['translate']);
        }
    }

    if ($_SESSION['translate'] && is_array($_SESSION['translate'])) {
        foreach ($_SESSION['translate'] as $line) {
            if (strpos($line, $string . "|") === 0) {
                return explode("|", $line)[1] ?? $string;
            }
        }
        //file_put_contents('translate.log', $string.PHP_EOL , FILE_APPEND | LOCK_EX);
    }

    return $string;
}