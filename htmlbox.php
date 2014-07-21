<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

class Htmlbox extends Module
{
    function __construct()
    {
        $this->name = 'htmlbox';
        $this->tab = 'Others';
        $this->version = '1.0';
        $this->author = 'www.bwlab.it';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.5', 'max' => '1.5.9');

        parent::__construct();

        $this->displayName = $this->l('Html Box in SideBar');
        $this->description = $this->l('View simple html in sidebar');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

    }

    /**
     * installazione modulo
     * @return bool
     */
    public function install()
    {


        if (!parent::install()) {
            return false;
        }


        try {

            $sqls[] = "";
            foreach ($sqls as $query) {

                if (!Db::getInstance()->Execute($query)) {

                    $this->uninstall();
                    return false;

                }

            }
        } catch (Exception $e) {
//            log
        }


        Configuration::updateValue('HTMLBOX_CONFIG_SALUTO', 'Ciao mondo');

        return true
        && $this->registerHook('displayLeftColumn');
    }

    /**
     * disinstallazione modulo
     * @return bool
     */
    public function uninstall()
    {

        if (!parent::uninstall()) {
            return false;
        }

        try {
            $sqls[] = "";
            foreach ($sqls as $query) {

                Db::getInstance()->Execute($query);

            }
        } catch (Exception $e) {
            //log ?
        }

        Configuration::deleteByName('HTMLBOX_CONFIG');

        $this->unregisterHook('displayLeft');
        return true;
    }

    public function hookDisplayLeftColumn($params)
    {
        $saluto = Configuration::get('HTMLBOX_CONFIG_SALUTO');

        $this->context->smarty->assign('variabile_saluto_template', $saluto);

        return $this->display(__FILE__, 'box.tpl');
    }

}