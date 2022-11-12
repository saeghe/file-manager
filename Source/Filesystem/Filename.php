<?php

namespace Saeghe\FileManager\Filesystem;

use Saeghe\Datatype\Text;

class Filename extends Text
{
    public function is_valid(string $string): bool
    {
        $minimum = str_starts_with($string, '.') ? 2 : 1;

        return strlen($string) >= $minimum;
    }
}
