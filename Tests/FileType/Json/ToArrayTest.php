<?php

namespace Tests\FileType\Json\ToArrayTest;

use Saeghe\FileManager\Path;
use function Saeghe\FileManager\Resolver\root;
use function Saeghe\FileManager\Directory\clean;
use function Saeghe\FileManager\FileType\Json\to_array;
use function Saeghe\TestRunner\Assertions\Boolean\assert_true;

test(
    title: 'it should return associated array from json file',
    case: function (Path $file) {
        assert_true(['foo' => 'bar'] === to_array($file));

        return $file;
    },
    before: function () {
        $file = Path::from_string(root() . 'Tests/PlayGround/File');
        file_put_contents($file, json_encode(['foo' => 'bar']));

        return $file;
    },
    after: function (Path $file) {
        clean($file->parent());
    }
);
