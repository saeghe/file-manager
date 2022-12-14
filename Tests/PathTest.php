<?php

namespace Tests\PathTest;

use Exception;
use InvalidArgumentException;
use Saeghe\FileManager\Path;
use Saeghe\FileManager\Filesystem\Directory;
use Saeghe\FileManager\Filesystem\File;
use Saeghe\FileManager\Filesystem\Symlink;
use function Saeghe\TestRunner\Assertions\Boolean\assert_true;
use function Saeghe\TestRunner\Assertions\Boolean\assert_false;

test(
    title: 'it should create path from string',
    case: function () {
        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            Path::from_string('\user\home/directory     ')->string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            Path::from_string('     \user\home/directory     ')->string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            Path::from_string('\user\home/directory')->string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            Path::from_string('\user\\\\home//directory')->string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            Path::from_string('\user\\\\home//directory/')->string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'middle-directory' . DIRECTORY_SEPARATOR . 'directory'
            ===
            Path::from_string('\user\home\../middle-directory\directory')->string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'middle-directory' . DIRECTORY_SEPARATOR . 'directory'
            ===
            Path::from_string('\user\home\.././middle-directory/directory')->string()
        );
    }
);

test(
    title: 'it should create path by calling fromString method',
    case: function () {
        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            Path::from_string('\user\home/directory')->string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            Path::from_string('\user\\\\home///directory')->string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            Path::from_string('\user\\\\home///directory/')->string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'middle-directory' . DIRECTORY_SEPARATOR . 'directory'
            ===
            Path::from_string('\user\home\../middle-directory\directory')->string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'middle-directory' . DIRECTORY_SEPARATOR . 'directory'
            ===
            Path::from_string('\user\home\.././middle-directory/directory')->string()
        );
    }
);

test(
    title: 'it should append and return a new path instance',
    case: function () {
        $path = Path::from_string('/user/home');
        assert_true($path->append('directory') instanceof Path);
        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            $path->append('directory')->string()
            &&
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home'
            ===
            $path->string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            Path::from_string('/user/home')->append('\directory')->string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            Path::from_string('/user/home')->append('\directory\\')->string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory' . DIRECTORY_SEPARATOR . 'filename.extension'
            ===
            Path::from_string('\user/home')->append('directory\filename.extension')->string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory' . DIRECTORY_SEPARATOR . 'filename.extension'
            ===
            Path::from_string('\user/home')->append('directory\filename.extension/')->string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory' . DIRECTORY_SEPARATOR . 'filename.extension'
            ===
            Path::from_string('\user////home')->append('directory\\\\filename.extension')->string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'directory' . DIRECTORY_SEPARATOR . 'filename.extension'
            ===
            Path::from_string('\user/home/..\./')->append('./another-directory/../directory\\\\filename.extension')->string()
        );
    }
);

test(
    title: 'it should return new instance of parent directory for the given path',
    case: function () {
        $path = Path::from_string('/user/home/directory/filename.extension');

        assert_true(
            $path->parent() instanceof Directory
            &&
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            $path->parent()->path->string()
            &&
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory' . DIRECTORY_SEPARATOR . 'filename.extension'
            ===
            $path->string()
        );
    }
);

test(
    title: 'it should check if the given file exists',
    case: function () {
        assert_true(Path::from_string(__FILE__)->exists());
        assert_false(Path::from_string(__FILE__)->append('not_exists.txt')->exists());

        assert_true(Path::from_string(__DIR__)->exists());
        assert_false(Path::from_string(__DIR__)->append('not_exists')->exists());
    }
);

test(
    title: 'it should detect the leaf',
    case: function () {
        assert_true(Path::from_string('/')->string() === Path::from_string('/')->leaf(), 'root leaf is not detected');
        assert_true('PathTest.php' === Path::from_string(__FILE__)->leaf(), 'leaf for file is not detected');
        assert_true('Tests' === Path::from_string(__DIR__)->leaf(), 'leaf for directory is not detected');
    }
);

test(
    title: 'it should return sibling',
    case: function () {
        $address = Path::from_string('/root/user/home/item');
        $sibling = $address->sibling('sibling');

        assert_true($sibling instanceof Path);
        assert_true($address->parent()->append('sibling')->string() === $sibling->string());
    }
);

test(
    title: 'it should convert to file',
    case: function () {
        $address = Path::from_string('/root/user/home/file.txt');
        $file = $address->as_file();

        assert_true($file instanceof File);
        assert_true($address->string() === $file->path->string());
    }
);

test(
    title: 'it should convert to directory',
    case: function () {
        $address = Path::from_string('/root/user/home/directory');
        $directory = $address->as_directory();

        assert_true($directory instanceof Directory);
        assert_true($address->string() === $directory->path->string());
    }
);

test(
    title: 'it should convert to symlink',
    case: function () {
        $address = Path::from_string('/root/user/home/file.txt');
        $symlink = $address->as_symlink();

        assert_true($symlink instanceof Symlink);
        assert_true($address->string() === $symlink->path->string());
    }
);

test(
    title: 'it should not accept empty string',
    case: function () {
        try {
            new Path('');
            assert_true(false, 'code should not reach to this point');
        } catch (Exception $exception) {
            assert_true($exception instanceof InvalidArgumentException);
            assert_true('Invalid string passed to path.' === $exception->getMessage());
        }
    }
);

test(
    title: 'it should accept linux format path',
    case: function () {
        $path = new Path('/root/file');
        assert_true('/root/file' === $path->string());
    }
);

test(
    title: 'it should not accept linux path if it does not start with root directory',
    case: function () {
        try {
            new Path('root');
            assert_true(false, 'code should not reach to this point');
        } catch (Exception $exception) {
            assert_true($exception instanceof InvalidArgumentException);
            assert_true('Invalid string passed to path.' === $exception->getMessage());
        }
    }
);


test(
    title: 'it should accept windows format path',
    case: function () {
        $path = new Path('c:\windows\system32');
        assert_true('c:\windows\system32' === $path->string());
    }
);

test(
    title: 'it should not accept windows path if it does not start with drive letter',
    case: function () {
        try {
            new Path('ftp:\\');
            assert_true(false, 'code should not reach to this point');
        } catch (Exception $exception) {
            assert_true($exception instanceof InvalidArgumentException);
            assert_true('Invalid string passed to path.' === $exception->getMessage());
        }
    }
);

test(
    title: 'it should relocate path directory',
    case: function () {
        $path = new Path('/home/user1/directory/filename');
        $relocate = $path->relocate('/home/user1/directory', '/home/user2/directory/../another-directory');

        assert_true($relocate instanceof Path);
        assert_true('/home/user2/another-directory/filename');
    }
);
