<?php require_once __DIR__ . '/../source/lib/vendor/autoload.php';

use Rs\Json\Patch;
use Rs\Json\Patch\InvalidPatchDocumentJsonException;
use Rs\Json\Patch\InvalidTargetDocumentJsonException;
use Rs\Json\Patch\InvalidOperationException;

try {
    // $targetDocument = '{"a":{"b":["c","d","e"]}}';
    $targetDocument = '{"id": 1, "name": "some Name", "parentId":null}';
    // $targetDocument = '{"id": 1, "name": "some Name"}';
    print_r($targetDocument);
    echo PHP_EOL;

    $patchDocument = '[
        {"op":"add", "path":"/parentId", "value":100}
    ]';
    /*print_r($patchDocument);
    echo PHP_EOL;*/
    /*$patchDocument = '[
        {"op":"add", "path":"/a/d", "value":["a","b"]},
        {"op":"test", "path":"/a/d/-", "value":"b"},
        {"op":"remove", "path":"/a/d/-"},
        {"op":"test", "path":"/a/d/-", "value":"a"},
        {"op":"add", "path":"/a/d/-", "value":"b"},
        {"op":"test", "path":"/a/d", "value":["a","b"]},
        {"op":"move", "path":"/a/c", "from":"/a/d"},
        {"op":"test", "path":"/a/c", "value":["a","b"]},
        {"op":"copy", "path":"/a/e", "from":"/a/c"},
        {"op":"test", "path":"/a/e", "value":["a","b"]},
        {"op":"replace", "path":"/a/e", "value":["a"]},
        {"op":"test", "path":"/a/e", "value":["a"]}
    ]';
*/
    $patch = new Patch($targetDocument, $patchDocument);
    $patchedDocument = $patch->apply(); // {"a":{"b":["c","d","e"],"c":["a","b"],"e":["a"]}}

    // print_r($targetDocument);
    print_r($patchedDocument);
    echo PHP_EOL;
} catch (InvalidPatchDocumentJsonException $e) {
    // Will be thrown when using invalid JSON in a patch document
    echo "Will be thrown when using invalid JSON in a patch document";
} catch (InvalidTargetDocumentJsonException $e) {
    // Will be thrown when using invalid JSON in a target document
    echo "Will be thrown when using invalid JSON in a target document";
} catch (InvalidOperationException $e) {
    // Will be thrown when using an invalid JSON Pointer operation (i.e. missing property)
    echo "Will be thrown when using an invalid JSON Pointer operation (i.e. missing property)";
}
