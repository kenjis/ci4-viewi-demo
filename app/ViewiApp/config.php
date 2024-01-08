<?php

use Viewi\AppConfig;

$d = DIRECTORY_SEPARATOR;
$viewiAppPath = __DIR__ . $d;
$componentsPath =  $viewiAppPath . 'Components';
$buildPath = $viewiAppPath . 'build';
$jsPath = $viewiAppPath . 'js';
$assetsSourcePath = $viewiAppPath . 'assets';
$publicPath = __DIR__ . $d . '..' . $d . '..' . $d . 'public';
$assetsPublicUrl = '';

return (new AppConfig('ci4'))
    ->buildTo($buildPath)
    ->buildFrom($componentsPath)
    ->withJsEntry($jsPath)
    ->putAssetsTo($publicPath)
    ->assetsPublicUrl($assetsPublicUrl)
    ->withAssets($assetsSourcePath)
    ->combine(false)
    ->minify(false)
    ->developmentMode(true)
    ->buildJsSourceCode()
    ->watchWithNPM(true);
