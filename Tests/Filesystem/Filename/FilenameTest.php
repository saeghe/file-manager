<?php

namespace Tests\Filesystem\Filename\FilenameTest;

use Saeghe\Datatype\Text;
use Saeghe\FileManager\Filesystem\Filename;
use function Saeghe\TestRunner\Assertions\Boolean\assert_true;

test(
    title: 'it implements Text datatype',
    case: function () {
        $filename = new Filename('a');
        assert_true($filename instanceof Text);
        assert_true('a' === $filename->string());
    }
);
