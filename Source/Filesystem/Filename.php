<?php

namespace Saeghe\FileManager\Filesystem;

use Saeghe\Datatype\Text;

class Filename extends Text
{
    public function directory(Directory $root): Directory
    {
        return $root->subdirectory($this);
    }

    public function file(Directory $root): File
    {
        return $root->file($this);
    }

    public function symlink(Directory $root): Symlink
    {
        return $root->symlink($this);
    }
}
