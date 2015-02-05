<?php
$SL = require __DIR__ . '/../source/lib/bootstrap.php';
$parser = $SL['markdownParser'];
$md = file_get_contents(__DIR__ . './sample.md');

echo <<<EOF
<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Образец разметки</title>
</head>
<body>
EOF;

echo $parser->parse($md);

echo <<<EOF
</body>
</html>
EOF;
