<?php

namespace Tests\Filesystem\Filename\SymlinkTest;

use Saeghe\FileManager\Filesystem\Directory;
use Saeghe\FileManager\Filesystem\Filename;
use Saeghe\FileManager\Filesystem\Symlink;
use function Saeghe\TestRunner\Assertions\Boolean\assert_true;

test(
    title: 'it should return symlink by the filename on the given root',
    case: function () {
        $filename = new Filename('symlink');
        $result = $filename->symlink(Directory::from_string('/home/user'));

        assert_true($result instanceof Symlink);
        assert_true('/home/user/symlink' === $result->path->string());
    }
);
