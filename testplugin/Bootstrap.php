<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of testplugin
 *
 * @author magnuskruschwitz
 */
class Shopware_Plugins_Frontend_testplugin_Bootstrap extends Shopware_Components_Plugin_Bootstrap
{
    public function getInfo(){
        return array(
            'label' => 'test',
            'author' => 'Magnus Kruschwitz',
            'copyright' => '(c) by Magnus Kruschwitz',
            'link' => 'http://magnuskruschwitz.de'
        );
    }
    
    public function getVersion() {
        $info = json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'plugin.json'), true);

        if ($info) {
            return $info['currentVersion'];
        } else {
            throw new Exception('The plugin has an invalid version file.');
        }
    }
    
    
    public function install(){
        $this->subscribeEvent(
            'Enlight_Controller_Action_PostDispatch',
            'onPostDispatch'
        );
        return true;
    }
    
    public function onPostDispatch(Enlight_Event_EventArgs $args)
    {
        $view = $args->getSubject()->View();
        $request = $args->getSubject()->Request();
        $response = $args->getSubject()->Response();

        if (!$request->isDispatched()
            || $response->isException()
            || $request->getModuleName() != 'frontend'
        ) {
            return;
        }
        
        echo '<pre>';
        //print_r ($request->getControllerName());
        //var_dump(get_class_methods($request)); //--> coole Funktion um die Inhalte herauszufinden
        var_dump(Shopware()->DB()->select('*')->from('s_articles'));
        //var_dump(get_class_vars($response)); // --> coole Funktion um die Inhalte herauszufinden
        die();
        $view->assign('testvariable','dies ist ein test');
        
    }
}
