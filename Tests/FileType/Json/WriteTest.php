<?php

namespace Tests\FileType\Json\WriteTest;

use Saeghe\FileManager\Path;
use function Saeghe\FileManager\Resolver\root;
use function Saeghe\FileManager\Directory\clean;
use function Saeghe\FileManager\FileType\Json\to_array;
use function Saeghe\FileManager\FileType\Json\write;
use function Saeghe\TestRunner\Assertions\Boolean\assert_true;

test(
    title: 'it should write associated array to json file',
    case: function () {
        $file = Path::from_string(root() . 'Tests/PlayGround/File');
        write($file, ['foo' => 'bar']);
        assert_true(['foo' => 'bar'] === to_array($file));

        return $file;
    },
    after: function (Path $file) {
        clean($file->parent());
    }
);
