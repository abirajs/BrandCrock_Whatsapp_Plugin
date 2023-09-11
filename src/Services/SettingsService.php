<?php
/**
 * This file is used for retrieving, and updating settings data in the
 * BrandCrock custom Settings table
 *
 * @author       BrandCrock GMBH
 * @copyright(C) BrandCrock
 * @license      https://www.brandcrock.de/payment-plugins/kostenlos/lizenz
 */
namespace BrandCrockWhatsapp\Services;

use BrandCrockWhatsapp\Models\Settings;
use Carbon\Carbon;
use Plenty\Modules\Plugin\DataBase\Contracts\DataBase;
use Plenty\Modules\Plugin\PluginSet\Contracts\PluginSetRepositoryContract;
use Plenty\Plugin\Application;
use Plenty\Plugin\Log\Loggable;

/**
 * Class SettingsService
 *
 * @package BrandCrock\Services\SettingsService
 */
class SettingsService
{
    use Loggable;

    /**
     * @var DataBase
     */
    protected $database;

    /**
     * Constructor.
     *
     * @param DataBase $database
     */
    public function __construct(DataBase $database)
    {
        $this->database = $database;
    }

    /**
     * Get BrandCrock configuration
     *
     * @param  int $clientId
     * @param  int $pluginSetId
     *
     * @return array
     */
    public function getSettings($clientId = null, $pluginSetId = null)
    {
        if(is_null($clientId)) {
            /** @var Application $application */
            $application = pluginApp(Application::class);
            $clientId = $application->getPlentyId();
        }
        if(is_null($pluginSetId)) {
            /** @var PluginSetRepositoryContract $pluginSetRepositoryContract */
            $pluginSetRepositoryContract = pluginApp(PluginSetRepositoryContract::class);
            $pluginSetId = $pluginSetRepositoryContract->getCurrentPluginSetId();
        }
        /** @var Settings[] setting variable */
        $settings = $this->database->query(Settings::class)->where('clientId', '=', $clientId)
                                  ->where('pluginSetId', '=', $pluginSetId)
                                  ->get();
        return $settings[0];
    }

    /**
     * Create or Update BrandCrock Configurations values
     *
     * @param array $data
     * @param int $clientId
     * @param int $pluginSetId
     *
     * @return array
     */
    public function updateSettings($data, $clientId, $pluginSetId)
    {
        $brandcrockSettings = $this->getSettings($clientId, $pluginSetId);
        if(!$brandcrockSettings instanceof Settings) {
            /** @var Settings $settings */
            $brandcrockSettings = pluginApp(Settings::class);
            $brandcrockSettings->clientId = $clientId;
            $brandcrockSettings->pluginSetId = $pluginSetId;
            $brandcrockSettings->createdAt = (string)Carbon::now();
        }
        $brandcrockSettings = $brandcrockSettings->update($data);
        return $brandcrockSettings;
    }

    /**
     * Get the individual configurations values
     *
     * @param string $settingsKey
     * @param string $paymentKey
     * @param int $clientId
     * @param int $pluginSetId
     *
     * @return mixed
*/
    public function getPaymentSettingsValue($settingsKey, $paymentKey = null, $clientId = null, $pluginSetId = null)
    {

        $settings = $this->getSettings($clientId, $pluginSetId);
        if(!is_null($settings)) {
            if(!empty($paymentKey) && isset($settings->value[$paymentKey])) {
                return $settings->value[$paymentKey][$settingsKey];
            } else {
                return $settings->value[$settingsKey];
            }
        }
            return null;
    }

}
