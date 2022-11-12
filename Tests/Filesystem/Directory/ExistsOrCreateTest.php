<?php

namespace Tests\Filesystem\Directory\ExistsOrCreate;

use Saeghe\FileManager\Filesystem\Directory;
use function Saeghe\FileManager\Resolver\root;
use function Saeghe\TestRunner\Assertions\Boolean\assert_true;

test(
    title: 'it should return true when directory exists',
    case: function (Directory $directory) {
        $result = $directory->exists_or_create();

        assert_true($result->path->string() === $directory->path->string());
        assert_true($result instanceof Directory);

        return $directory;
    },
    before: function () {
        $directory = Directory::from_string(root() . 'Tests/PlayGround/ExistsOrCreate');
        $directory->make();

        return $directory;
    },
    after: function (Directory $directory) {
        $directory->delete();
    }
);

test(
    title: 'it should create and return true when directory not exists',
    case: function () {
        $directory = Directory::from_string(root() . 'Tests/PlayGround/ExistsOrCreate');

        $result = $directory->exists_or_create();

        assert_true($result->path->string() === $directory->path->string());
        assert_true($directory->exists());

        return $directory;
    },
    after: function (Directory $directory) {
        $directory->delete();
    }
);
