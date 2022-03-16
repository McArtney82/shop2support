<?php

declare(strict_types=1);

namespace App\Utils;

/**
 * Class Path
 * @package App\Utils
 */
class Path
{
    /**
     * Get dist directory URI.
     *
     * @return string
     */
    public static function distURI(): string
    {
        return get_template_directory_uri().'/dist';
    }

    /**
     * @return string
     */
    public static function servicesURI(): string
    {
        return get_template_directory_uri().'/App/Services';
    }
}
