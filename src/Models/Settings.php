<?php
/**
 * This file is used to create a settings model in the database
 *
 * @author       BrandCrock
 * @copyright(C) BrandCrock
 * @license      https://www.brandcrock.de/payment-plugins/kostenlos/lizenz
 */
namespace BrandCrockWhatsapp\Models;

use Carbon\Carbon;
use Plenty\Modules\Plugin\DataBase\Contracts\DataBase;
use Plenty\Modules\Plugin\DataBase\Contracts\Model;
use Plenty\Plugin\Log\Loggable;

/**
 * Class Settings
 *
 * @property int $id
 * @property int $clientId
 * @property int $pluginSetId
 * @property array $value
 * @property string $createdAt
 * @property string $updatedAt
 *
 * @package BrandCrock\Models
 */
class Settings extends Model
{
    use Loggable;

    public $id;
    public $clientId;
    public $pluginSetId;
    public $value = [];
    public $createdAt = '';
    public $updatedAt = '';

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return 'BrandCrock::settings';
    }

    /**
     * Insert the configuration values into settings table
     *
     * @param array $data
     *
     * @return Model
     */
    public function create($data)
    {
        $this->clientId    = $data['clientId'];
        $this->pluginSetId = $data['pluginSetId'];
        $this->createdAt   = (string)Carbon::now();
        $this->value = [
			'bc_whatsapp_enable_chat'       =>  $data['bc_whatsapp_enable_chat'] ?? '',
            'bc_whatsapp_chat_heading'      =>  $data['bc_whatsapp_chat_heading'] ?? '',
            'bc_whatsapp_chat_description'  =>  $data['bc_whatsapp_chat_description'] ?? '',
            'bc_whatsapp_mobile_number'     =>  $data['bc_whatsapp_mobile_number'] ?? '',
            'bc_whatsapp_account_name'      =>  $data['bc_whatsapp_account_name'] ?? '',
            'bc_whatsapp_account_role'      =>  $data['bc_whatsapp_account_role'] ?? '',
            'bc_whatsapp_profile_logo'      =>  $data['bc_whatsapp_profile_logo'] ?? '',
            'bc_whatsapp_open_new_tab'  	=>  $data['bc_whatsapp_open_new_tab'] ?? '',
            'bc_whatsapp_url_desktop'       =>  $data['bc_whatsapp_url_desktop'] ?? '',
            'bc_whatsapp_url_mobile'        =>  $data['bc_whatsapp_url_mobile'] ?? '',
            'bc_whatsapp_mobile_theme'      =>  $data['bc_whatsapp_mobile_theme'] ?? '',
            'bc_whatsapp_mobile_shape'      =>  $data['bc_whatsapp_mobile_shape'] ?? '',
            'bc_whatsapp_desktop_theme'     =>  $data['bc_whatsapp_desktop_theme'] ?? '',
            'bc_whatsapp_desktop_shape'     =>  $data['bc_whatsapp_desktop_shape'] ?? '',
        ];
        return $this->save();
    }

    /**
     * Update the configuration values into settings table
     *
     * @param array $data
     *
     * @return Model
     */
    public function update($data)
    {
        if(isset($data['bc_whatsapp_enable_chat'])) {
            $this->value['bc_whatsapp_enable_chat'] = $data['bc_whatsapp_enable_chat'];
        }
        if(isset($data['bc_whatsapp_chat_heading'])) {
            $this->value['bc_whatsapp_chat_heading'] = $data['bc_whatsapp_chat_heading'];
        }
        if(isset($data['bc_whatsapp_chat_description'])) {
            $this->value['bc_whatsapp_chat_description']  = $data['bc_whatsapp_chat_description'];
        }
        if(isset($data['bc_whatsapp_mobile_number'])) {
            $this->value['bc_whatsapp_mobile_number'] = $data['bc_whatsapp_mobile_number'];
        }
        if(isset($data['bc_whatsapp_account_name'])) {
            $this->value['bc_whatsapp_account_name'] = $data['bc_whatsapp_account_name'];
        }
        if(isset($data['brandcrock_webhook_testmode'])) {
            $this->value['brandcrock_webhook_testmode'] = $data['brandcrock_webhook_testmode'];
        }
        if(isset($data['brandcrock_webhook_email_to'])) {
            $this->value['brandcrock_webhook_email_to'] = $data['brandcrock_webhook_email_to'];
        }
        if(isset($data['bc_whatsapp_account_role'])) {
            $this->value['bc_whatsapp_account_role'] = $data['bc_whatsapp_account_role'];
        }
        if(isset($data['bc_whatsapp_profile_logo'])) {
            $this->value['bc_whatsapp_profile_logo'] = $data['bc_whatsapp_profile_logo'];
        }
        if(isset($data['bc_whatsapp_open_new_tab'])) {
            $this->value['bc_whatsapp_open_new_tab'] = $data['bc_whatsapp_open_new_tab'];
        }
        if(isset($data['bc_whatsapp_url_desktop'])) {
            $this->value['bc_whatsapp_url_desktop'] = $data['bc_whatsapp_url_desktop'];
        }
        if(isset($data['bc_whatsapp_url_mobile'])) {
            $this->value['bc_whatsapp_url_mobile'] = $data['bc_whatsapp_url_mobile'];
        }
        if(isset($data['bc_whatsapp_mobile_theme'])) {
            $this->value['bc_whatsapp_mobile_theme'] = $data['bc_whatsapp_mobile_theme'];
        }
        if(isset($data['brandcrock_guaranteed_sepa'])) {
            $this->value['brandcrock_guaranteed_sepa'] = $data['brandcrock_guaranteed_sepa'];
        }
        if(isset($data['bc_whatsapp_mobile_shape'])) {
            $this->value['bc_whatsapp_mobile_shape'] = $data['bc_whatsapp_mobile_shape'];
        }
        if(isset($data['bc_whatsapp_desktop_theme'])) {
            $this->value['bc_whatsapp_desktop_theme'] = $data['bc_whatsapp_desktop_theme'];
        }
        if(isset($data['bc_whatsapp_desktop_shape'])) {
            $this->value['bc_whatsapp_desktop_shape'] = $data['bc_whatsapp_desktop_shape'];
        }
        return $this->save();
    }

    /**
     * Save the configuration values into settings table
     *
     * @return Model
     */
    public function save()
    {
        /** @var DataBase $database */
        $database = pluginApp(DataBase::class);
        $this->updatedAt = (string)Carbon::now();
        return $database->save($this);
    }

    /**
     * Delete the configuration values into settings table
     *
     * @return bool
     */
    public function delete()
    {
        /** @var DataBase $database */
        $database = pluginApp(DataBase::class);
        return $database->delete($this);
    }
}
