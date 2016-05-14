<?php

namespace Address\Helpers;

use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use \Illuminate\View\Factory;
use \Illuminate\View\View;
use \Illuminate\View\FileViewFinder;
use \Illuminate\View\Compilers\BladeCompiler;
use \Illuminate\View\Engines\CompilerEngine;
use \Illuminate\View\Engines\EngineResolver;
use Illuminate\Config\FileLoader;
use Illuminate\Config\Repository;
use Illuminate\Filesystem\Filesystem;

class FormHelper
{
    /**
     * @param $formAction
     * @param $configDir
     * @param $viewPath
     * @param $viewName
     * @return string
     */
    public static function renderView($formAction, $configDir, $viewPath, $viewName)
    {
        $configDir = !empty($configDir) ? $configDir : __DIR__.'/../../config';
        $configArray = require $configDir.'/config.php';

        $config = new Repository();

        foreach($configArray as $key=>$value){
            $config->set('config.'.$key, $value);
        }

        // this path needs to be array
        $FileViewFinder = new FileViewFinder(new Filesystem, [$viewPath]);

        // use blade instead of phpengine
        // pass in filesystem object and cache path
        $compiler = new BladeCompiler(new Filesystem(), $config->get('config.compiledDirectory'));
        $BladeEngine = new CompilerEngine($compiler);

        // create a dispatcher
        $dispatcher = new Dispatcher(new Container);

        // build the factory
        $factory = new Factory(new EngineResolver, $FileViewFinder, $dispatcher);

        // this path needs to be string
        $view = new View($factory, $BladeEngine, $viewName, $viewPath, ['action' => $formAction]);

        return $view->render();
    }

    /**
     * This function renders the full civic address form
     * @param string $formAction
     * @return string
     */
    public static function renderCivicAddressFullForm($formAction, $configDir)
    {
        $viewName = 'civicAddressFullForm';
        $viewPath = __DIR__ . '/../Views/civicAddressFullForm.blade.php';

        $configDir = !empty($configDir) ? $configDir : __DIR__ . '/../../config';

        return self::renderView($formAction, $configDir, $viewPath, $viewName);
    }

    /**
     * This function renders the simple civic address form
     * @param string $formAction
     * @return string
     */
    public static function renderCivicAddressSimpleForm($formAction, $configDir)
    {
        $viewName = 'civicAddressSimpleForm';
        $viewPath = __DIR__ . '/../Views/civicAddressSimpleForm.blade.php';

        $configDir = !empty($configDir) ? $configDir : __DIR__ . '/../../config';

        return self::renderView($formAction, $configDir, $viewPath, $viewName);
    }

    /**
     * This function renders the pobox address form
     * @param string $formAction
     * @return string
     */
    public static function renderPOBOXAddressForm($formAction, $configDir)
    {
        $viewName = 'poboxAddressForm';
        $viewPath = __DIR__ . '/../Views/poboxAddressForm.blade.php';

        $configDir = !empty($configDir) ? $configDir : __DIR__ . '/../../config';

        return self::renderView($formAction, $configDir, $viewPath, $viewName);
    }

    /**
     * This function renders the rural address form
     * @param string $formAction
     * @return string
     */
    public static function renderRuralAddressForm($formAction, $configDir)
    {
        $viewName = 'poboxAddressForm';
        $viewPath = __DIR__ . '/../Views/ruralAddressForm.blade.php';

        $configDir = !empty($configDir) ? $configDir : __DIR__ . '/../../config';

        return self::renderView($formAction, $configDir, $viewPath, $viewName);
    }
}