<?php

namespace Tests\Directory\DeleteTest;

use Saeghe\FileManager\Path;
use Saeghe\FileManager\Directory;
use function Saeghe\FileManager\Resolver\root;
use function Saeghe\TestRunner\Assertions\Boolean\assert_false;

test(
    title: 'it should delete the given directory',
    case: function (Path $directory) {
        Directory\delete($directory);

        assert_false(Directory\exists($directory));
    },
    before: function () {
        $directory = Path::from_string(root() . 'Tests/PlayGround/DeleteDirectory');
        mkdir($directory);

        return $directory;
    }
);
