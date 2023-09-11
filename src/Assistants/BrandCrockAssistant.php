<?php
/**
 * This file is used for creating the configuration for the plugin
 *
 * @author       BrandCrock GMBH
 * @copyright(C) BrandCrock
 * @license      https://www.brandcrock.de/payment-plugins/kostenlos/lizenz
 */

namespace BrandCrockWhatsapp\Assistants;

use BrandCrockWhatsapp\Assistants\SettingsHandlers\BrandCrockAssistantSettingsHandler;
use Plenty\Modules\Wizard\Services\WizardProvider;
use Plenty\Modules\System\Contracts\WebstoreRepositoryContract;
use Plenty\Plugin\Application;


/**
 * Class BrandCrockAssistant
 *
 * @package BrandCrock\Assistants
 */
class BrandCrockAssistant extends WizardProvider
{


    /**
     * @var WebstoreRepositoryContract
     */
    private $webstoreRepository;

    /**
     * @var $mainWebstore
     */
    private $mainWebstore;

    /**
     * @var $webstoreValues
    */
    private $webstoreValues;

     /**
     * @var $getIcon
     */
     private $getIcon;

     /**
     * @var $getMainWebstore
     */
     private $getMainWebstore;

     /**
     * @var $getWebstoreListForm
     */
     private $getWebstoreListForm;

     /**
     * @var $createGeneralConfiguration
     */
     private $createGeneralConfiguration;

    /**
    * @var $createAccountConfiguration
    */
    private $createAccountConfiguration;

    /**
    * @var $createURLConfiguration
    */
    private $createURLConfiguration;

    /**
    * @var $createButtonStyleMobileConfiguration
    */
    private $createButtonStyleMobileConfiguration;

    /**
    * @var $createButtonStyleDesktopConfiguration
    */
    private $createButtonStyleDesktopConfiguration;

    /**
    * Constructor.
    *
    * @param WebstoreRepositoryContract $webstoreRepository
    */
    public function __construct(WebstoreRepositoryContract $webstoreRepository)
    {
        $this->webstoreRepository   = $webstoreRepository;
    }

    protected function structure()
    {
        $config =
        [
            "title" => 'BrandCrockAssistant.brandcrockAssistantTitle',
            "shortDescription" => 'BrandCrockAssistant.brandcrockAssistantShortDescription',
            "iconPath" => $this->getIcon(),
            "settingsHandlerClass" => BrandCrockAssistantSettingsHandler::class,
            "translationNamespace" => 'BrandCrockWhatsapp',
            "key" => 'template-brandcrock-assistant',
            "topics" => ['template'],
            "priority" => 999,
            "options" =>
            [
                'clientId' =>
                [
                    'type'          => 'select',
                    'defaultValue'  => $this->getMainWebstore(),
                    'options'       => [
                                        'name'          => 'BrandCrockAssistant.clientId',
                                        'required'      => true,
                                        'listBoxValues' => $this->getWebstoreListForm(),
                                       ],
                ],
            ],
            "steps" => []
        ];

       $config = $this->createGeneralConfiguration($config);
       $config = $this->createAccountConfiguration($config);
       $config = $this->createURLConfiguration($config);
       $config = $this->createButtonStyleMobileConfiguration($config);
       $config = $this->createButtonStyleDesktopConfiguration($config);
       return $config;
    }

   /**
     * Load BrandCrock Icon
     *
     * @return string
     */
    protected function getIcon()
    {
        $app = pluginApp(Application::class);
        $icon = $app->getUrlPath('BrandCrockWhatsapp').'/images/brandcrock_icon.png';
        return $icon;
    }

    /**
     * Load main web store configuration
     *
     * @return string
     */
    private function getMainWebstore()
    {
        if($this->mainWebstore === null) {
            $this->mainWebstore = $this->webstoreRepository->findById(0)->storeIdentifier;
        }
        return $this->mainWebstore;
    }

    /**
     * Get the shop list
     *
     * @return array
     */
    private function getWebstoreListForm()
    {
        if($this->webstoreValues === null) {
            $webstores = $this->webstoreRepository->loadAll();
            $this->webstoreValues = [];
            /** @var Webstore $webstore */
            foreach($webstores as $webstore) {
                $this->webstoreValues[] = [
                    "caption" => $webstore->name,
                    "value" => $webstore->storeIdentifier,
                ];
            }
        }
        return $this->webstoreValues;
    }

    /**
    * Create the Genaral configurations
    *
    * @param array $config
    *
    * @return array
    */
    public function createGeneralConfiguration($config)
    {
        $config['steps']['brandcrockGeneralConf'] =
        [
            "title" => 'BrandCrockAssistant.GeneralConf',
            "sections" => [
                [
                    "title"         => 'BrandCrockAssistant.GeneralConf',
                    "description"   => 'BrandCrockAssistant.GeneralConfDesc',
                    "form"          =>
                    [
                        'enableChat' =>
                        [
                            'type'         => 'checkbox',
                            'defaultValue' => true,
                            'options'   => [
                                            'name'  => 'BrandCrockAssistant.enableChat'
                                           ]
                        ],

             'chatHeading' =>
                        [
                            'type'          => 'text',
                            'defaultValue'  => 'Whatsapp Chat',
                            'options'       => [
                                            'name'      => 'BrandCrockAssistant.chatHeading',
                                            'required'  => true,
                            'maxLength'     => 30
                                           ]
                        ],

                        'chatDescription' =>
                        [
                            'type'          => 'text',
                            'defaultValue'  => 'Our repersents team admin has chat below',
                            'options'       => [
                                            'name'      => 'BrandCrockAssistant.chatDescription',
                                            'required'  => true,
                            'maxLength'     => 70
                                           ]
                        ],

                    ]
                ]
            ]
        ];
        return $config;
    }


    /**
    * Create the Account configurations
    *
    * @param array $config
    *
    * @return array
    */
    public function createAccountConfiguration($config)
    {
        $config['steps']['brandcrockAccountConf'] =
        [
            "title" => 'BrandCrockAssistant.brandcrockWebhookConf',
            "sections" => [
                [
                    "title"         => 'BrandCrockAssistant.brandcrockWebhookConf',
                    "description"   => '',
                    "form"          =>
                    [
                        'mobileNumber' =>
                        [
                            'type'          => 'text',
                            'defaultValue'  => '8754754860',
                            'options'       => [
                                            'name'  => 'BrandCrockAssistant.mobileNumber',
                                            'required'  => true
                                           ]
                        ],

                        'accountName' =>
                        [
                            'type'          => 'text',
                            'defaultValue'  => 'Devon Convey',
                            'options'       => [
                                            'name'      => 'BrandCrockAssistant.accountName',
                                            'required'  => true
                                           ]
                        ],

                        'accountRole' =>
                        [
                            'type'          => 'text',
                            'defaultValue'  => 'Manager',
                            'options'       => [
                                            'name'      => 'BrandCrockAssistant.accountRole',
                                            'required'  => true,
                                           ]
                        ],

                        'profileLogo' =>
                        [
                            'type'      => 'file',

                            'options'   => [
                                            'name'              => 'BrandCrockAssistant.profile',
                                            'showPreview'       => true,
                                            'allowedExtensions' => ['svg', 'png', 'jpg', 'jpeg'],
                                            'allowFolders'      => false,
                                            'required'  => true,
                                           ]
                        ],
                    ]
                ]
            ]
        ];
        return $config;
    }

    /**
    * Create the URL configurations
    *
    * @param array $config
    *
    * @return array
    */
    public function createURLConfiguration($config)
    {
        $config['steps']['brandcrockURLConf'] =
        [
            "title" => 'BrandCrockAssistant.brandcrockURLConf',
            "sections" => [
                [
                    "title"         => 'BrandCrockAssistant.brandcrockURLConf',
                    "description"   => 'BrandCrockAssistant.brandcrockURLConfDesc',
                    "form"          =>
                    [
                        'openNewTab' =>
                        [
                            'type'         => 'checkbox',
                            'defaultValue' => true,
                            'options'   => [
                                            'name'  => 'BrandCrockAssistant.openNewTab'
                                           ]
                        ],

                        'URLforDesktop' =>
                        [
                            'type'          => 'select',
                            'defaultValue'  => 'web',
                            'options'       => [
                                                'name'          => 'BrandCrockAssistant.URLforDesktop',
                                                'listBoxValues' => [
                                                                        [
                                                                            'caption' => 'Web',
                                                                            'value'   => 'web'
                                                                        ],

                                                                        [
                                                                            'caption' => 'API',
                                                                            'value'   => 'api'
                                                                        ],

                                                                        [
                                                                            'caption' => 'Universal',
                                                                            'value'   => 'universal'
                                                                        ],
                                                                    ],
                                               ]
                        ],

                        'URLforMobile' =>
                        [
                            'type'          => 'select',
                            'defaultValue'  => 'universal',
                            'options'       => [
                                                'name'          => 'BrandCrockAssistant.URLforMobile',
                                                'listBoxValues' => [
                                                                        [   'caption' => 'Universal',
                                                                            'value'   => 'universal'
                                                                        ],

                                                                        [
                                                                            'caption' => 'API',
                                                                            'value'   => 'api'
                                                                        ],

                                                                        [
                                                                            'caption' => 'Web',
                                                                            'value'   => 'web'
                                                                        ],
                                                                    ],
                                               ]
                        ],

                    ]
                ]
            ]
        ];
        return $config;
    }


    /**
    * Create the button style for configurations
    *
    * @param array $config
    *
    * @return array
    */
    public function createButtonStyleMobileConfiguration($config)
    {
        $config['steps']['brandcrockButtonStyleMobileConf'] =
        [
            "title" => 'BrandCrockAssistant.brandcrockButtonStyleMobileConf',
            "sections" => [
                [
                    "title"         => 'BrandCrockAssistant.brandcrockButtonStyleMobileConf',
                    "description"   => '',
                    "form"          =>
                    [
                        'mobileTheme' =>
                        [
                            'type'          => 'select',
                            'defaultValue'  => 'green',
                            'options'       => [
                                                'name'          => 'BrandCrockAssistant.mobileTheme',
                                                'listBoxValues' => [
                                                                        [   'caption' => 'Green',
                                                                            'value'   => 'green'
                                                                        ],

                                                                        [
                                                                            'caption' => 'White',
                                                                            'value'   => 'white'
                                                                        ],
                                                                    ],
                                               ]
                        ],

                        'mobileShape' =>
                        [
                            'type'          => 'select',
                            'defaultValue'  => 'circle',
                            'options'       => [
                                                'name'          => 'BrandCrockAssistant.mobileShape',
                                                'listBoxValues' => [
                                                                        [   'caption' => 'Circle',
                                                                            'value'   => 'circle'
                                                                        ],

                                                                        [
                                                                            'caption' => 'Rectangle',
                                                                            'value'   => 'rectangle'
                                                                        ],
                                                                    ],
                                               ]
                        ],

                    ]
                ]
            ]
        ];
        return $config;
    }

    /**
    * Create the button style for desktop configurations
    *
    * @param array $config
    *
    * @return array
    */
    public function createButtonStyleDesktopConfiguration($config)
    {
        $config['steps']['brandcrockButtonStyleDesktopConf'] =
        [
            "title" => 'BrandCrockAssistant.brandcrockButtonStyleDesktopConf',
            "sections" => [
                [
                    "title"         => 'BrandCrockAssistant.brandcrockButtonStyleDesktopConf',
                    "description"   => '',
                    "form"          =>
                    [
                        'desktopTheme' =>
                        [
                            'type'          => 'select',
                            'defaultValue'  => 'green',
                            'options'       => [
                                                'name'          => 'BrandCrockAssistant.desktopTheme',
                                                'listBoxValues' => [
                                                                        [   'caption' => 'Green',
                                                                            'value'   => 'green'
                                                                        ],

                                                                        [
                                                                            'caption' => 'White',
                                                                            'value'   => 'white'
                                                                        ],
                                                                    ],
                                               ]
                        ],

                        'desktopShape' =>
                        [
                            'type'          => 'select',
                            'defaultValue'  => 'circle',
                            'options'       => [
                                                'name'          => 'BrandCrockAssistant.desktopShape',
                                                'listBoxValues' => [
                                                                        [   'caption' => 'Circle',
                                                                            'value'   => 'circle'
                                                                        ],

                                                                        [
                                                                            'caption' => 'Rectangle',
                                                                            'value'   => 'rectangle'
                                                                        ],
                                                                    ],
                                               ]
                        ],

                    ]
                ]
            ]
        ];
        return $config;
    }

}
