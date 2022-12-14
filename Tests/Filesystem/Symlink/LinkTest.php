<?php

namespace Tests\Filesystem\Symlink\LinkTest;

use Saeghe\FileManager\Filesystem\File;
use Saeghe\FileManager\Filesystem\Symlink;
use function file_exists;
use function readlink;
use function Saeghe\FileManager\Resolver\root;
use function Saeghe\TestRunner\Assertions\Boolean\assert_true;

test(
    title: 'it should link a symlink',
    case: function (File $file, Symlink $symlink) {
        $response = $symlink->link($file);
        assert_true($symlink->path->string() === $response->path->string());
        assert_true($file->exists());
        assert_true(file_exists($symlink));
        assert_true(readlink($symlink) === $file->path->string());

        return [$file, $symlink];
    },
    before: function () {
        $file = File::from_string(root() . 'Tests/PlayGround/File');
        $file->create('');
        $symlink = Symlink::from_string(root() . 'Tests/PlayGround/Symlink');

        return [$file, $symlink];
    },
    after: function (File $file, Symlink $symlink) {
        $symlink->delete();
        $file->delete();
    },
);
