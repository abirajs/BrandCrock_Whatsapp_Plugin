<?php
/**
 * This file is used for registering the BrandCrock payment methods
 * and Event procedures
 *
 * @author       BrandCrock
 * @copyright(C) BrandCrock
 * @license      https://www.brandcrock.de/payment-plugins/kostenlos/lizenz
 */
namespace BrandCrockWhatsapp\Providers;

use BrandCrockWhatsapp\Assistants\BrandCrockAssistant;
use Plenty\Plugin\ServiceProvider;
use Plenty\Modules\Wizard\Contracts\WizardContainerContract;

class BrandCrockServiceProvider extends ServiceProvider
{
	/**
	* Boot additional services for the payment method
	 *
	*/
	public function boot()
	{
	     // Set the BrandCrock Assistant
	     pluginApp(WizardContainerContract::class)->register('template-brandcrock-assistant', BrandCrockAssistant::class);
	}
}
