<?php

/**
 * HyvorTalk
 *
 * @package hyvortalk
 * @subpackage hyvortalk
 *
 * @var $modx
 * @var $scriptProperties array
 */

if (empty($modx->version)) {
    $modx->getVersionData();
}

$version = (int) $modx->version['version'];

if ($version > 2) {
    $ht = new \MatDave\HyvorTalk\Service($modx, $scriptProperties);
} else {
    $corePath = $modx->getOption('hyvortalk.core_path', null, $modx->getOption('core_path') . 'components/hyvortalk/');
    $ht = $modx->getService('hyvortalk', 'HyvorTalk', $corePath . 'model/hyvortalk/', $scriptProperties);
}

$class = '\\MatDave\\HyvorTalk\\Elements\\Events\\' . $modx->event->name;

if (class_exists($class))
{
    $event = new $class($ht, $scriptProperties);
    $event->run();
} else {
    $modx->log(\xPDO::LOG_LEVEL_ERROR, 'Event class not found: ' . $class);
}
