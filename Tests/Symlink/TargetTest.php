<?php

namespace Tests\Symlink\LinkTest;

use Saeghe\FileManager\Path;
use function Saeghe\FileManager\Resolver\root;
use function Saeghe\FileManager\Symlink\link;
use function Saeghe\FileManager\Symlink\target;
use function Saeghe\FileManager\File\create;
use function Saeghe\FileManager\File\delete;
use function Saeghe\TestRunner\Assertions\Boolean\assert_true;

test(
    title: 'it should return target path to the link',
    case: function (Path $file, Path $link) {
        assert_true($file->string() === target($link));

        return [$file, $link];
    },
    before: function () {
        $file = Path::from_string(root() . 'Tests/PlayGround/LinkSource');
        create($file, 'file content');
        $link = $file->parent()->append('symlink');
        link($file, $link);

        return [$file, $link];
    },
    after: function (Path $file, Path $link) {
        unlink($link);
        delete($file);
    }
);
