<?php

namespace Tests\Directory\PreserveCopyRecursiveTest;

use Saeghe\FileManager\Path;
use Saeghe\FileManager\Directory;
use function Saeghe\FileManager\Directory\preserve_copy_recursively;
use function Saeghe\FileManager\File\exists;
use function Saeghe\FileManager\File\permission;
use function Saeghe\FileManager\Resolver\root;
use function Saeghe\TestRunner\Assertions\Boolean\assert_true;

test(
    title: 'it should copy directory recursively by preserving permission',
    case: function (Path $origin, Path $destination) {
        $result = preserve_copy_recursively($origin, $destination);

        $origin_directory = $origin->as_directory();
        $copied_directory = $destination->as_directory();

        assert_true($result, 'preserve_copy_recursive is not working!');
        assert_true(Directory\exists($origin_directory));
        assert_true(Directory\exists($copied_directory));
        assert_true(Directory\exists($copied_directory->subdirectory('subdirectory')), 'subdirectory not exists');
        assert_true(
            Directory\permission($origin_directory->subdirectory('subdirectory'))
            ===
            Directory\permission($copied_directory->subdirectory('subdirectory')),
            'subdirectory permission is wrong'
        );
        assert_true(exists($copied_directory->file('filename.txt')), 'file in copied directory not exists');
        assert_true(
            permission($origin_directory->file('filename.txt'))
            ===
            permission($copied_directory->file('filename.txt')),
            'file permission is wrong in copied directory'
        );
        assert_true(exists($copied_directory->subdirectory('subdirectory')->file('.another-file')), 'file in subdirectory not exists');
        assert_true(
            permission($origin_directory->subdirectory('subdirectory')->file('.another-file'))
            ===
            permission($copied_directory->subdirectory('subdirectory')->file('.another-file')),
            'permission for file in subdirectory is wrong'
        );
    },
    before: function () {
        $origin = Path::from_string(root() . 'Tests/PlayGround/Origin');
        Directory\make_recursive($origin);
        $origin->as_directory()->file('filename.txt')->create('content', 0667);
        $origin->as_directory()->subdirectory('subdirectory')->make(0750);
        $origin->as_directory()->subdirectory('subdirectory')->file('.another-file')->create('', 0666);
        $destination = Path::from_string(root() . 'Tests/PlayGround/Destination');
        Directory\make($destination);

        return [$origin, $destination];
    },
    after: function () {
        Directory\clean(root() . 'Tests/PlayGround');
    }
);
