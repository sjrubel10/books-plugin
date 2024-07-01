<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitb9ccd95bd1f46663a18fa05ca64243cb
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInitb9ccd95bd1f46663a18fa05ca64243cb', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitb9ccd95bd1f46663a18fa05ca64243cb', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitb9ccd95bd1f46663a18fa05ca64243cb::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
