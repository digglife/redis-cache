<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class EnvVarTest extends TestCase
{
    /**
     * Ensure that setting WP_REDIS_IGBINARY env var to the string "false"
     * defines the constant as boolean false (not truthy).
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testWpRedisIgbinaryEnvVarFalseString(): void
    {
        putenv('WP_REDIS_IGBINARY=false');

        wp_cache_init();

        $this->assertTrue(defined('WP_REDIS_IGBINARY'), 'WP_REDIS_IGBINARY should be defined from env var');
        $this->assertFalse(WP_REDIS_IGBINARY, 'WP_REDIS_IGBINARY env var "false" should define constant as boolean false');
    }

    /**
     * Ensure that setting WP_REDIS_IGBINARY env var to the string "true"
     * defines the constant as boolean true.
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testWpRedisIgbinaryEnvVarTrueString(): void
    {
        putenv('WP_REDIS_IGBINARY=true');

        wp_cache_init();

        $this->assertTrue(defined('WP_REDIS_IGBINARY'), 'WP_REDIS_IGBINARY should be defined from env var');
        $this->assertTrue(WP_REDIS_IGBINARY, 'WP_REDIS_IGBINARY env var "true" should define constant as boolean true');
    }

    /**
     * Ensure that an empty WP_REDIS_IGBINARY env var does not define the constant.
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testWpRedisIgbinaryEnvVarEmptyString(): void
    {
        putenv('WP_REDIS_IGBINARY=');

        wp_cache_init();

        $this->assertFalse(defined('WP_REDIS_IGBINARY'), 'Empty WP_REDIS_IGBINARY env var should not define the constant');
    }

    /**
     * Ensure that setting WP_REDIS_SELECTIVE_FLUSH env var to the string "false"
     * defines the constant as boolean false (not truthy).
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testWpRedisSelectiveFlushEnvVarFalseString(): void
    {
        putenv('WP_REDIS_SELECTIVE_FLUSH=false');

        wp_cache_init();

        $this->assertTrue(defined('WP_REDIS_SELECTIVE_FLUSH'), 'WP_REDIS_SELECTIVE_FLUSH should be defined from env var');
        $this->assertFalse(WP_REDIS_SELECTIVE_FLUSH, 'WP_REDIS_SELECTIVE_FLUSH env var "false" should define constant as boolean false');
    }

    /**
     * Ensure that setting WP_REDIS_SELECTIVE_FLUSH env var to the string "true"
     * defines the constant as boolean true.
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testWpRedisSelectiveFlushEnvVarTrueString(): void
    {
        putenv('WP_REDIS_SELECTIVE_FLUSH=true');

        wp_cache_init();

        $this->assertTrue(defined('WP_REDIS_SELECTIVE_FLUSH'), 'WP_REDIS_SELECTIVE_FLUSH should be defined from env var');
        $this->assertTrue(WP_REDIS_SELECTIVE_FLUSH, 'WP_REDIS_SELECTIVE_FLUSH env var "true" should define constant as boolean true');
    }

    /**
     * Ensure that WP_REDIS_IGBINARY constant set to the string "false" does not
     * enable igbinary serialization in WP_Object_Cache.
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testUseIgbinaryFalseWhenConstantIsStringFalse(): void
    {
        define('WP_REDIS_IGBINARY', 'false');

        $cache = new \WP_Object_Cache();

        $property = new \ReflectionProperty(\WP_Object_Cache::class, 'use_igbinary');
        $property->setAccessible(true);

        $this->assertFalse($property->getValue($cache), 'use_igbinary should be false when WP_REDIS_IGBINARY is the string "false"');
    }

    /**
     * Ensure that WP_REDIS_IGBINARY constant set to boolean false does not
     * enable igbinary serialization in WP_Object_Cache.
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testUseIgbinaryFalseWhenConstantIsBooleanFalse(): void
    {
        define('WP_REDIS_IGBINARY', false);

        $cache = new \WP_Object_Cache();

        $property = new \ReflectionProperty(\WP_Object_Cache::class, 'use_igbinary');
        $property->setAccessible(true);

        $this->assertFalse($property->getValue($cache), 'use_igbinary should be false when WP_REDIS_IGBINARY is boolean false');
    }
}
