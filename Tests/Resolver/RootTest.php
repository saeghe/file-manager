<?php

namespace Tests\Resolver\RootTest;

use function Saeghe\FileManager\Resolver\root;
use function Saeghe\FileManager\Resolver\realpath;
use function Saeghe\TestRunner\Assertions\Boolean\assert_true;

test(
    title: 'it should return path to root',
    case: function () {
        assert_true(realpath(__DIR__ . '/../..') . DIRECTORY_SEPARATOR === root());
    }
);
