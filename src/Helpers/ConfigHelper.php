<?php

namespace LoyalistaIntegration\Helpers;

use LoyalistaIntegration\Core\Helpers\AbstractConfigHelper;
use Plenty\Plugin\ConfigRepository;
use Plenty\Modules\Plugin\Contracts\PluginRepositoryContract;

/**
 * Class ConfigHelper.
 */
class ConfigHelper extends AbstractConfigHelper
{
    /**
     * Product identifiers.
     */
    const PRODUCT_IDENTIFIER_ID = 'id"';
    const PRODUCT_IDENTIFIER_NUMBER = 'number';
    const PRODUCT_IDENTIFIER_VARIATION = 'variation';
    const LOYALISTA_CAMPAIGN_NAME = 'Loyalista Gutscheine';

    /**
     * Configuration enable/disable values.
     */
    const CONFIG_ENABLE_TRUE = 'true';
    const CONFIG_ENABLE_FALSE = 'false';
    const VALUE_1 = '1';
    const VALUE_0 = '0';
    const VALUE_YES = 1;
    const VALUE_NO = 0;
    const BASE_URL = 'https://api.loyalista.de';

    /**
     * @var ConfigRepository
     */
    private $config;
    private $prifix;

    /**
     * ConfigHelper constructor.
     *
     * @param ConfigRepository $config
     */
    public function __construct(ConfigRepository $config)
    {
        $this->config = $config;

        $this->prifix = $config::getPrefix();
    }

    // Added for Lolista

    /**
     * @return string
     */
    public function getPluginVersion(): string
    {
      return 0.1111;
    }

    public function getVendorID(){
        return $this->config->get(self::PLUGIN_NAME . '.vendor_id');

    }
    public function getVendorHash(){
        return $this->config->get(self::PLUGIN_NAME . '.vendor_hash');
    }

    public  function getVendorSecret(){
        return $this->config->get(self::PLUGIN_NAME .'.api_access_token');
    }

    public  function getShopID(){
        return $this->config->get(self::PLUGIN_NAME .'.shop_id');
    }


    public function getVar($var){

        return $this->config->get(self::PLUGIN_NAME   .'.'  .$var);
    }

    public function setVar($var, $value){
        $this->config->set(self::PLUGIN_NAME . '.'  . $var , $value);
    }

    public function getPrefix()
    {
        return $this->prifix;
    }







}
