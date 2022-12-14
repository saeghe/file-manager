<?php

namespace Tests\Filesystem\Directory\DeleteRecursiveTest;

use Saeghe\FileManager\Filesystem\Directory;
use function Saeghe\FileManager\Resolver\root;
use function Saeghe\FileManager\Directory\exists;
use function Saeghe\TestRunner\Assertions\Boolean\assert_true;
use function Saeghe\TestRunner\Assertions\Boolean\assert_false;

test(
    title: 'it should delete a directory recursively',
    case: function (Directory $directory, Directory $subdirectory) {
        $response = $directory->delete_recursive();
        assert_true($directory->path->string() === $response->path->string());
        assert_false(exists($directory));
        assert_false(exists($subdirectory));

        return $directory;
    },
    before: function () {
        $directory = Directory::from_string(root() . 'Tests/PlayGround/DirectoryAddress');
        $subdirectory = Directory::from_string(root() . 'Tests/PlayGround/DirectoryAddress/Subdirectory');
        $subdirectory->make_recursive();

        return [$directory, $subdirectory];
    }
);
