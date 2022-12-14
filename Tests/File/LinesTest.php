<?php

namespace Tests\File\LinesTest;

use Saeghe\FileManager\Path;
use Saeghe\FileManager\File;
use function Saeghe\FileManager\Resolver\root;
use function Saeghe\TestRunner\Assertions\Boolean\assert_true;

test(
    title: 'it should read file\'s lines',
    case: function (Path $file) {
        $results = [];

        foreach (File\lines($file) as $n => $line) {
            $results[$n] = $line;
        }

        assert_true([0 => 'First line.' . PHP_EOL, 1 => 'Second line.'] === $results);

        return $file;
    },
    before: function () {
        $file = Path::from_string(root() . 'Tests/PlayGround/NewFile.txt');
        File\create($file, 'First line.' . PHP_EOL . 'Second line.');

        return $file;
    },
    after: function (Path $file) {
        File\delete($file);
    }
);
