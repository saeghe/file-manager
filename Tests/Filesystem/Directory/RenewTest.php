<?php

namespace Tests\Filesystem\Directory\RenewTest;

use Saeghe\FileManager\Filesystem\Directory;
use function Saeghe\FileManager\Resolver\root;
use function Saeghe\TestRunner\Assertions\Boolean\assert_true;
use function Saeghe\TestRunner\Assertions\Boolean\assert_false;

test(
    title: 'it should clean directory when directory exists',
    case: function (Directory $directory) {
        $result = $directory->renew();

        assert_true($result->path->string() === $directory->path->string());
        assert_true($directory->exists());
        assert_false($directory->file('file.txt')->exists());

        return $directory;
    },
    before: function () {
        $directory = Directory::from_string(root() . 'Tests/PlayGround/Renew');
        $directory->make();
        $directory->file('file.txt')->create('content');

        return $directory;
    },
    after: function (Directory $directory) {
        $directory->delete_recursive();
    }
);

test(
    title: 'it should create the directory when directory not exists',
    case: function () {
        $directory = Directory::from_string(root() . 'Tests/PlayGround/Renew');

        $directory->renew();
        assert_true($directory->exists());

        return $directory;
    },
    after: function (Directory $directory) {
        $directory->delete_recursive();
    }
);
