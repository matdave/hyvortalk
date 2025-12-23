<?php

namespace MatDave\HyvorTalk\Elements\Events;

use MatDave\MODXPackage\Elements\Event\Event;

class OnTVInputRenderList extends Event
{
    public function run()
    {
        $corePath = $this->modx->getOption('hyvortalk.core_path', null, $this->modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/hyvortalk/');
        $this->modx->event->output($corePath . 'elements/tvs/input/');
    }
}