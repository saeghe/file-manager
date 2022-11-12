<?php

namespace Tests\Filesystem\Directory\DeleteTest;

use Saeghe\FileManager\Filesystem\Directory;
use function Saeghe\FileManager\Resolver\root;
use function Saeghe\FileManager\Directory\exists;
use function Saeghe\TestRunner\Assertions\Boolean\assert_true;
use function Saeghe\TestRunner\Assertions\Boolean\assert_false;


test(
    title: 'it should delete a directory',
    case: function (Directory $directory) {
        $response = $directory->delete();
        assert_true($directory->path->string() === $response->path->string());
        assert_false(exists($directory));
    },
    before: function () {
        $directory = Directory::from_string(root() . 'Tests/PlayGround/DirectoryAddress');
        $directory->make();

        return $directory;
    }
);
