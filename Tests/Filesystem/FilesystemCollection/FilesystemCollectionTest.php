<?php

namespace Tests\Filesystem\FilesystemCollection\FilesystemCollectionTest;

use Saeghe\FileManager\Filesystem\Directory;
use Saeghe\FileManager\Filesystem\File;
use Saeghe\FileManager\Filesystem\FilesystemCollection;
use Saeghe\FileManager\Filesystem\Symlink;
use function Saeghe\TestRunner\Assertions\Boolean\assert_true;

test(
    title: 'it should accept Directory, File and Symlink objects',
    case: function () {
        $directory = Directory::from_string('/');
        $file = File::from_string('/file');
        $symlink = Symlink::from_string('/symlink');

        $collection = new FilesystemCollection([$directory, $file, $symlink]);

        assert_true([$directory, $file, $symlink] === $collection->items());
    }
);
