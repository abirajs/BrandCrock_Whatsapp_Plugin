<?php
/**
 * This file is used to save all data created during 
 * the assistant process
 *
 * @author       BrandCrock
 * @copyright(C) BrandCrock
 * @license      https://www.brandcrock.de/payment-plugins/kostenlos/lizenz
 */
namespace BrandCrockWhatsapp\Assistants\SettingsHandlers;

use BrandCrockWhatsapp\Services\SettingsService;
use Plenty\Modules\Plugin\PluginSet\Contracts\PluginSetRepositoryContract;
use Plenty\Modules\Wizard\Contracts\WizardSettingsHandler;

/**
 * Class BrandCrockAssistantSettingsHandler
 *
 * @package BrandCrock\Assistants\SettingsHandlers
 */
class BrandCrockAssistantSettingsHandler implements WizardSettingsHandler
{
    public function handle(array $postData)
    {
        /** @var PluginSetRepositoryContract $pluginSetRepo */
        $pluginSetRepo = pluginApp(PluginSetRepositoryContract::class);
        $clientId = $postData['data']['clientId'];
        $pluginSetId = $pluginSetRepo->getCurrentPluginSetId();
        $data = $postData['data'];
        // BrandCrock global and webhook configurations values
        $brandcrockSettings=[
            'bc_whatsapp_enable_chat'       =>  $data['enableChat'] ?? '',
            'bc_whatsapp_chat_heading'      =>  $data['chatHeading'] ?? '',
            'bc_whatsapp_chat_description'  =>  $data['chatDescription'] ?? '',
            'bc_whatsapp_mobile_number'     =>  $data['mobileNumber'] ?? '',
            'bc_whatsapp_account_name'      =>  $data['accountName'] ?? '',
            'bc_whatsapp_account_role'      =>  $data['accountRole'] ?? '',
            'bc_whatsapp_profile_logo'      =>  $data['profileLogo'] ?? '',
            'bc_whatsapp_open_new_tab'  	=>  $data['openNewTab'] ?? '',
            'bc_whatsapp_url_desktop'       =>  $data['URLforDesktop'] ?? '',
            'bc_whatsapp_url_mobile'        =>  $data['URLforMobile'] ?? '',
            'bc_whatsapp_mobile_theme'      =>  $data['mobileTheme'] ?? '',
            'bc_whatsapp_mobile_shape'      =>  $data['mobileShape'] ?? '',
            'bc_whatsapp_desktop_theme'     =>  $data['desktopTheme'] ?? '',
            'bc_whatsapp_desktop_shape'     =>  $data['desktopShape'] ?? '',
        ];

        /** @var SettingsService $settingsService */
        $settingsService=pluginApp(SettingsService::class);
        $settingsService->updateSettings($brandcrockSettings, $clientId, $pluginSetId);
        return true;
    }
}
