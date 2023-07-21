<?php
/**
 * This file is used for creating custom Settings table
 *
 * @author       BrandCrock
 * @copyright(C) BrandCrock
 * @license      https://www.brandcrock.de/payment-plugins/kostenlos/lizenz
 */
namespace BrandCrock\Migrations;

use BrandCrock\Models\Settings;
use Plenty\Modules\Plugin\DataBase\Contracts\Migrate;

/**
 * Class CreateSettingsTable
 *
 * @package BrandCrock\Migrations
 */
class CreateSettingsTable
{
    /**
     * Create transaction log table
     *
     * @param Migrate $migrate
     */
    public function run(Migrate $migrate)
    {
        $migrate->createTable(Settings::class);
    }
}
