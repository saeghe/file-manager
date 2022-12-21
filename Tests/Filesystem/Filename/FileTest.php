<?php

namespace Tests\Filesystem\Filename\FileTest;

use Saeghe\FileManager\Filesystem\Directory;
use Saeghe\FileManager\Filesystem\File;
use Saeghe\FileManager\Filesystem\Filename;
use function Saeghe\TestRunner\Assertions\Boolean\assert_true;

test(
    title: 'it should return file by the filename on the given root',
    case: function () {
        $filename = new Filename('filename');
        $result = $filename->file(Directory::from_string('/home/user'));

        assert_true($result instanceof File);
        assert_true('/home/user/filename' === $result->path->string());
    }
);
