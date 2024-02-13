<?php
use System\Console\Prompt;

use function System\Console\ok;
use function System\Console\style;
use function System\Console\warn;

require __DIR__ . './vendor/autoload.php';

$input = file_get_contents(__DIR__ . '/data_individu.json');
$niks = json_decode($input, true);

$belum_input = file_get_contents(__DIR__ . '/belum_asik.json');
$belum_input = json_decode($belum_input, true);

do {
    $input = new Prompt(style('Cari nik?')->newLines()->push(' >')->textRed()->push(' '));

    $print = $input->text(function ($input) use ($niks, &$belum_input) {
        if (strlen($input) !== 16) {
            return warn('nik salah');
        }

        detail($input);

        if ( in_array($input, $niks)) {
            return ok('ada');
        }

        return warn('tidak ada');
    });

    $print->out(false);
} while (true);

function detail(string $nik) {
    $hari  = (int) \System\Text\Str::slice($nik, 6, 2);
    $bulan = \System\Text\Str::slice($nik, 8,2);
    $tahun = 2000 + (int) \System\Text\Str::slice($nik, 10,2);

    $date = now()->day($hari >= 40 ? $hari - 40 : $hari)->month($bulan)->year($tahun)->format("d/m/Y") . PHP_EOL;
    $jk = $hari >= 40 ? "perempuan" : "laki-laki";

    style($jk)->textYellow()->push('     ')->push($date)->textDim()->out(false);
}