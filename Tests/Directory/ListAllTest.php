<?php

namespace Tests\Directory\ListAllTest;

use Saeghe\FileManager\Path;
use Saeghe\FileManager\Directory;
use Saeghe\FileManager\File;
use function Saeghe\FileManager\Resolver\root;
use function Saeghe\TestRunner\Assertions\Boolean\assert_true;

test(
    title: 'it should return list of files and sub directories in the given directory contain hidden files',
    case: function (Path $directory) {
        assert_true(
            ['.hidden.txt', 'sample.txt', 'sub-directory'] === Directory\ls_all($directory),
            'Directory list all is not working properly.'
        );

        return $directory;
    },
    before: function () {
        $directory = Path::from_string(root() . 'Tests/PlayGround/Directory');
        Directory\make($directory);
        Directory\make($directory->append('sub-directory'));
        File\create($directory->append('sample.txt'), '');
        File\create($directory->append('.hidden.txt'), '');

        return $directory;
    },
    after: function (Path $directory) {
        Directory\delete_recursive($directory);
    }
);

test(
    title: 'it should return empty array when directory is empty',
    case: function (Path $directory) {
        assert_true(
            [] === Directory\ls_all($directory),
            'Directory list all is not working properly.'
        );

        return $directory;
    },
    before: function () {
        $directory = Path::from_string(root() . 'Tests/PlayGround/Directory');
        Directory\make($directory);

        return $directory;
    },
    after: function (Path $directory) {
        Directory\delete_recursive($directory);
    }
);
