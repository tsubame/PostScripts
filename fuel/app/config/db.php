<?php
/**
 * Fuel is a fast, lightweight, community driven PHP 5.4+ framework.
 *
 * @package    Fuel
 * @version    1.8.2
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2019 Fuel Development Team
 * @link       https://fuelphp.com
 */

/**
 * -----------------------------------------------------------------------------
 *  Global database settings
 * -----------------------------------------------------------------------------
 *
 *  Set database configurations here to override environment specific
 *  configurations
 *
 */

return array(

    // 使用する設定
    'active' => 'testdb',
    //'active' => 'default',

    /**
     * Base config, just need to set the DSN, username and password in env. config.
     */
    'default' => array(
        'type'        => 'mysql',
        'connection' => array(
            'hostname'   => 'db01.lsv.jp',
            'database'   => 'taltal3014script',
            'username'   => 'taltal3014@db01.lsv.jp',
            'password'   => 'mill0716',
            'persistent' => True,
        ),    
        'table_prefix' => '',
        'charset'      => 'utf8',
        'caching'      => false,
        'profiling'    => false,
    ),

    
    'redis' => array(
        'default' => array(
            'hostname'  => '127.0.0.1',
            'port'      => 6379,
        )
    ),

    'testdb' => array(
        'type'   => 'mysqli',
        'connection' => array(
            'hostname'   => 'db01.lsv.jp',   
            'database'   => 'taltal3014script',
            'username'   => 'taltal3014',//'hideki', //'taltal3014_sc@sv1.php.xdomain.ne.jp',
            'password'   => 'mill0716', //'mill0716',
            'persistent' => FALSE,
        ),
        'table_prefix' => '',
        'charset'      => 'utf8',
        'caching'      => false,
        'profiling'    => true,
    ),

    /*
    'testdb' => array(
        'type'   => 'mysqli',
        'connection' => array(
            'hostname'   => 'localhost',
            'port'       => '8889',   //'8889'         
            'database'   => 'taltal3014script',
            'username'   => 'hideki', //'taltal3014_sc@sv1.php.xdomain.ne.jp',
            'password'   => 'mill0716', //'mill0716',
            'persistent' => FALSE,
        ),
        'table_prefix' => '',
        'charset'      => 'utf8',
        'caching'      => false,
        'profiling'    => true,
    ),
    */
);
