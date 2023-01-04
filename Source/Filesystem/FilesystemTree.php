<?php

namespace Saeghe\FileManager\Filesystem;

use Saeghe\Datatype\Tree;

class FilesystemTree extends Tree
{
    public function files(): FilesystemCollection
    {
        return new FilesystemCollection(
            $this->vertices()->filter(fn (Directory|File|Symlink $object) => $object instanceof File)->values()
        );
    }
}
