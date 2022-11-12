<?php

namespace Tests\Filesystem\Directory\FileTest;

use Saeghe\FileManager\Filesystem\Directory;
use Saeghe\FileManager\Filesystem\File;
use function Saeghe\FileManager\Resolver\root;
use function Saeghe\TestRunner\Assertions\Boolean\assert_true;

test(
    title: 'it should return file for the given directory',
    case: function () {
        $directory = Directory::from_string(root() . 'Tests/PlayGround');
        $result = $directory->file('filename');

        assert_true($result instanceof File);
        assert_true(
            Directory::from_string(root() . 'Tests/PlayGround')->append('filename')->string()
            ===
            $result->path->string()
        );

        return $directory;
    }
);
