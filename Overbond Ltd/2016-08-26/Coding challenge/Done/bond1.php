<?php

chdir(__DIR__); // makes life easier

require_once 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
use Aura\Cli\CliFactory;
use CorporateBond\Challenge\Calculator;
use League\Csv\Reader;


// If CSV document was created or is read on a Macintosh computer the following "if" helps PHP detect line ending.
if (!ini_get("auto_detect_line_endings")) {
    ini_set("auto_detect_line_endings", '1');
}

// CLI
$cliFactory = new CliFactory;
$context = $cliFactory->newContext($GLOBALS);
$getOpt = $context->getopt([
    'filename,f:',  // long option --file or short flag -f, parameter required
]);
$filename = $getOpt->get('--filename'); // both -f and --foo have the same values

// CSV
$csv = Reader::createFromPath($filename);

// CSV header
$headers = $csv->fetchOne();

// CSV data rows
$data = $csv->setOffset(1)->fetchAll(function ($value) use ($headers) {
    $combinedRow = array_combine($headers, $value);
    $combinedRow['term'] = floatval($combinedRow['term']);
    $combinedRow['yield'] = floatval($combinedRow['yield']);
    return $combinedRow;
});


$Calculator = new Calculator();
$Calculator->outputYieldSpread(
    $Calculator->calculateYieldSpread($data),
    $cliFactory
);
//echo "........ Done v1 ...........";
