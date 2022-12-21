<?php

namespace Tests\Filesystem\Filename\DirectoryTest;

use Saeghe\FileManager\Filesystem\Directory;
use Saeghe\FileManager\Filesystem\Filename;
use function Saeghe\TestRunner\Assertions\Boolean\assert_true;

test(
    title: 'it should return subdirectory by the filename on the given root',
    case: function () {
        $filename = new Filename('subdirectory');
        $result = $filename->directory(Directory::from_string('/home/user'));

        assert_true($result instanceof Directory);
        assert_true('/home/user/subdirectory' === $result->path->string());
    }
);
