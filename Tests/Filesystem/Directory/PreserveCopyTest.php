<?php

namespace Tests\Filesystem\Directory\PreserveCopyTest;

use Saeghe\FileManager\Filesystem\Directory;
use function Saeghe\FileManager\Resolver\root;
use function Saeghe\TestRunner\Assertions\Boolean\assert_true;

test(
    title: 'it should copy directory by preserving permission',
    case: function (Directory $origin, Directory $destination) {
        $copied_directory = $destination->subdirectory($origin->leaf());
        $result = $origin->preserve_copy($copied_directory);

        assert_true($result->path->string() === $origin->path->string());
        assert_true($copied_directory->exists());
        assert_true($origin->permission() === $copied_directory->permission());

        return [$origin, $destination];
    },
    before: function () {
        $origin = Directory::from_string(root() . 'Tests/PlayGround/Origin/PreserveCopy');
        $origin->make_recursive();
        $destination = Directory::from_string(root() . 'Tests/PlayGround/Destination');
        $destination->make();

        return [$origin, $destination];
    },
    after: function (Directory $origin, Directory $destination) {
        $origin->parent()->delete_recursive();
        $destination->delete_recursive();
    }
);

test(
    title: 'it should copy directory by preserving permission with any permission',
    case: function (Directory $origin, Directory $destination) {
        $copied_directory = $destination->subdirectory($origin->leaf());
        $origin->preserve_copy($copied_directory);

        assert_true($copied_directory->exists());
        assert_true(0777 === $copied_directory->permission());

        return [$origin, $destination];
    },
    before: function () {
        $origin = Directory::from_string(root() . 'Tests/PlayGround/Origin/PreserveCopy');
        $origin->make_recursive(0777);
        $destination = Directory::from_string(root() . 'Tests/PlayGround/Destination');
        $destination->make();

        return [$origin, $destination];
    },
    after: function (Directory $origin, Directory $destination) {
        $origin->parent()->delete_recursive();
        $destination->delete_recursive();
    }
);
