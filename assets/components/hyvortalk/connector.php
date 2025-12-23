<?php

/*
 * This file is part of the HyvorTalk package.
 *
 * Copyright (c) MODX, LLC
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * HyvorTalk Connector
 *
 * @package hyvortalk
 */

require_once dirname(__FILE__, 4) . '/config.core.php';
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';

$corePath = $modx->getOption('hyvortalk.core_path', null, $modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/hyvortalk/');
/** @var \Service $hyvortalk */
$hyvortalk = $modx->getService(
    'hyvortalk',
    'HyvorTalk',
    $corePath . 'model/hyvortalk/',
    [
        'core_path' => $corePath
    ]
);

$action = $_REQUEST['action'] ?? null;
// replace namespace action with processor e.g. MatDave\HyvorTalk\Processors\ElementCategories\GetList => mgr/element_categories/getlist
if ($action) {
    $action = str_replace('\\', '/', strtolower(str_replace('MatDave\\HyvorTalk\\Processors\\', '', $action)));
    $action = preg_replace('/([a-z])([A-Z])/', '$1_$2', $action);
    $action = preg_replace('/([A-Z])([A-Z])([a-z])/', '$1_$2$3', $action);
    $actionArray = explode('/', $action);
    $last = array_pop($actionArray);
    $actionArray[] = str_replace('_', '', $last);
    $action = implode('/', $actionArray);
}

$modx->request->handleRequest(
    [
        'processors_path' => $hyvortalk->getOption('processorsPath', [], $corePath . 'processors/'),
        'location' => '',
        'action' => $action
    ]
);
