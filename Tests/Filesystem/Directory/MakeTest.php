<?php

namespace Tests\Filesystem\Directory\makeTest;

use Saeghe\FileManager\Filesystem\Directory;
use function Saeghe\FileManager\Resolver\root;
use function Saeghe\TestRunner\Assertions\Boolean\assert_true;

test(
    title: 'it should make a directory',
    case: function () {
        $directory = Directory::from_string(root() . 'Tests/PlayGround/MakeDirectory');

        $result = $directory->make();

        assert_true($result->path->string() === $directory->path->string());
        assert_true($directory->exists());
        assert_true(0775 === $directory->permission());

        return $directory;
    },
    after: function (Directory $address) {
        $address->delete();
    }
);

test(
    title: 'it should make a directory with the given permission',
    case: function () {
        $directory = Directory::from_string(root() . 'Tests/PlayGround/MakeDirectory');

        $directory->make(0777);

        assert_true($directory->exists());
        assert_true(0777 === $directory->permission());

        return $directory;
    },
    after: function (Directory $address) {
        $address->delete();
    }
);
