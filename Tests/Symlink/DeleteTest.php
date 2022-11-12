<?php

namespace Tests\Symlink\DeleteTest;

use Saeghe\FileManager\Path;
use Saeghe\FileManager\File;
use function Saeghe\FileManager\Resolver\root;
use function Saeghe\FileManager\Symlink\link;
use function Saeghe\FileManager\Symlink\delete;
use function Saeghe\TestRunner\Assertions\Boolean\assert_true;
use function Saeghe\TestRunner\Assertions\Boolean\assert_false;

test(
    title: 'it should delete the link',
    case: function (Path $file, Path $link) {
        assert_true(delete($link));
        assert_true($file->exists());
        assert_false($link->exists());

        return $file;
    },
    before: function () {
        $file = Path::from_string(root() . 'Tests/PlayGround/LinkSource');
        File\create($file, 'file content');
        $link = $file->parent()->append('symlink');
        link($file->as_file(), $link);

        return [$file, $link];
    },
    after: function (Path $file) {
        File\delete($file);
    }
);
