<?php

namespace Tests\File\ContentTest;

use Saeghe\FileManager\Path;
use function Saeghe\FileManager\Resolver\root;
use function Saeghe\FileManager\File\content;
use function Saeghe\FileManager\File\delete;
use function Saeghe\TestRunner\Assertions\Boolean\assert_true;

test(
    title: 'it should get file content',
    case: function (Path $file) {
        assert_true('sample text' === content($file));

        return $file;
    },
    before: function () {
        $file = Path::from_string(root() . 'Tests/PlayGround/sample.txt');
        file_put_contents($file, 'sample text');

        return $file;
    },
    after: function (Path $file) {
        delete($file);
    }
);
