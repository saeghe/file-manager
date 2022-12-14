<?php

namespace Tests\Symlink\LinkTest;

use Saeghe\FileManager\Path;
use function Saeghe\FileManager\Resolver\root;
use function Saeghe\FileManager\Symlink\link;
use function Saeghe\FileManager\File\create;
use function Saeghe\FileManager\File\delete;
use function Saeghe\TestRunner\Assertions\Boolean\assert_true;

test(
    title: 'it should create a link to the given source',
    case: function (Path $file) {
        $link = $file->parent()->append('symlink');

        assert_true(link($file, $link));
        assert_true($file->string() === readlink($link));

        return [$file, $link];
    },
    before: function () {
        $file = Path::from_string(root() . 'Tests/PlayGround/LinkSource');
        create($file, 'file content');

        return $file;
    },
    after: function (Path $file, Path $link) {
        unlink($link);
        delete($file);
    }
);
