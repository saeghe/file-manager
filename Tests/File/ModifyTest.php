<?php

namespace Tests\File\ModifyTest;

use Saeghe\FileManager\Path;
use function Saeghe\FileManager\Resolver\root;
use function Saeghe\FileManager\File\content;
use function Saeghe\FileManager\File\create;
use function Saeghe\FileManager\File\modify;
use function Saeghe\FileManager\File\delete;
use function Saeghe\FileManager\File\exists;
use function Saeghe\TestRunner\Assertions\Boolean\assert_true;

test(
    title: 'it should modify file',
    case: function (Path $file) {
        assert_true(modify($file, 'content in file'));
        assert_true(exists($file));
        assert_true('content in file' === content($file));

        return $file;
    },
    before: function () {
        $file = Path::from_string(root() . 'Tests/PlayGround/sample.txt');
        create($file, 'create content');

        return $file;
    },
    after: function (Path $file) {
        delete($file);
    }
);
