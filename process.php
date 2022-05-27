<?php

function parseGivenLineBySeparator($line, $index, $separator){
    return trim(preg_replace('/\s\s+/', '', explode($separator, $line)[$index]));
}

$inputFile = fopen("input/input.txt", "r") or die("Unable to open file!");
$lines = [];
$lineCount = 0;
while (!feof($inputFile)) {
    $lines[] = fgets($inputFile);
    $lineCount++;
}
$dom = new DOMDocument();
$dom->encoding = 'utf-8';
$dom->xmlVersion = '1.0';
$dom->formatOutput = true;
$outputFilePath = 'output/output.xml';

$order = $dom->createElement('order');
$header = $dom->createElement('header');

for ($index = 0; $index < count(explode(";", $lines[0])); $index++) {
    $childNode = $dom->createElement(
        parseGivenLineBySeparator($lines[0], $index, ";"),
        parseGivenLineBySeparator($lines[1], $index, ";")
    );
    $header->appendChild($childNode);
}
$linesTag = $dom->createElement('lines');
for ($line = 3; $line < $lineCount; $line++) {
    $lineTag = $dom->createElement('line');
    for ($index = 0; $index < count(explode(";", $lines[2])); $index++) {
        $childNode = $dom->createElement(
            parseGivenLineBySeparator($lines[2], $index, ";"),
            parseGivenLineBySeparator($lines[$line], $index, ";")
        );
        $lineTag->appendChild($childNode);
    }
    $linesTag->appendChild($lineTag);
}

$order->appendChild($header);
$order->appendChild($linesTag);
$dom->appendChild($order);
$dom->save($outputFilePath);

echo "$outputFilePath has been successfully created";
