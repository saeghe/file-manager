<?php

namespace Tests\Filesystem\File\LinesTest;

use Saeghe\FileManager\Filesystem\File;
use function Saeghe\FileManager\Resolver\root;
use function Saeghe\TestRunner\Assertions\Boolean\assert_true;

test(
    title: 'it should read file\'s lines',
    case: function (File $file) {
        foreach ($file->lines() as $n => $line) {
            if ($n === 0) {
                assert_true('First line.' . PHP_EOL === $line, 'First line does not match in file lines.');
            }
            if ($n === 1) {
                assert_true('Second line.' === $line, 'First line does not match in file lines.');
            }
        }

        return $file;
    },
    before: function () {
        $file = File::from_string(root() . 'Tests/PlayGround/NewFile.txt');
        $file->create('First line.' . PHP_EOL . 'Second line.');

        return $file;
    },
    after: function (File $file) {
        $file->delete();
    }
);
