<?php

namespace Tests\File\CreateTest;

use Saeghe\FileManager\Path;
use function Saeghe\FileManager\Resolver\root;
use function Saeghe\FileManager\File\content;
use function Saeghe\FileManager\File\create;
use function Saeghe\FileManager\File\delete;
use function Saeghe\FileManager\File\exists;
use function Saeghe\FileManager\File\permission;
use function Saeghe\TestRunner\Assertions\Boolean\assert_true;

test(
    title: 'it should create file',
    case: function () {
        $file = Path::from_string(root() . 'Tests/PlayGround/sample.txt');
        assert_true(create($file, 'content in file'));
        assert_true(exists($file));
        assert_true('content in file' === content($file));
        assert_true(0664 === permission($file));

        return $file;
    },
    after: function (Path $file) {
        delete($file);
    }
);

test(
    title: 'it should create file with given permission',
    case: function () {
        $file = Path::from_string(root() . 'Tests/PlayGround/sample.txt');
        assert_true(create($file, 'content in file', 0765));
        assert_true(exists($file));
        assert_true('content in file' === content($file));
        assert_true(0765 === permission($file));

        return $file;
    },
    after: function (Path $file) {
        delete($file);
    }
);
