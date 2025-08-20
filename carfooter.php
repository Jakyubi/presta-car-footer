<?php
if(!defined('_PS_VERSION_')){
    exit;
}


class CarFooter extends Module
{
    public function __construct()
    {
        $this->name = 'carfooter';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'abc';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.7.0.0',
            'max' => _PS_VERSION_
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->trans('Car footer', [], 'Modules.Carfooter.Admin');
        $this->description = $this->trans('Show footer for car parts site', [], 'Modules.Carfooter.Admin');
        $this->confirmUninstall = $this->trans('Are you sure to uninstall?', [], 'Modules.Carfooter.Admin');

        if(!Configuration::get('CARFOOTER_MODULE_NAME')){
            $this->warning = $this->trans('No name provided', [], 'Modules.Carfooter.Admin');
        }
    }

    public function install()
    {
        return (
            parent::install()
            && $this->registerHook('displayFooter')
            && $this->registerHook('actionFrontControllerSetMedia')
            && Configuration::updateValue('CARFOOTER_MODULE_NAME', 'Car footer')
        );
    }

    public function uninstall()
    {
        return(
            parent::uninstall()
            && Configuration::deleteByName('CARFOOTER_MODULE_NAME')
        );
    }

    public function hookActionFrontControllerSetMedia($params)
    {
        $this->context->controller->registerStylesheet(
            'style-car-footer',
            'modules/'.$this->name.'/dist/css/style.css',
            ['media'=>'all', 'priority' => 150]
        );
    }

    public function hookDisplayFooter($params)
    {
        return $this->display(__FILE__, 'views/templates/hook/frontFooter.tpl');
    }



}