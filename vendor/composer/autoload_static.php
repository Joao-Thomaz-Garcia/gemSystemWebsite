<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitdca71c471a4c190a74446e177f3fa457
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Stripe\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Stripe\\' => 
        array (
            0 => __DIR__ . '/..' . '/stripe/stripe-php/lib',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitdca71c471a4c190a74446e177f3fa457::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitdca71c471a4c190a74446e177f3fa457::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitdca71c471a4c190a74446e177f3fa457::$classMap;

        }, null, ClassLoader::class);
    }
}
