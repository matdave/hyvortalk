<?php

if (!class_exists('HyvorTalkMembershipsInputRender')) {
    class HyvorTalkMembershipsInputRender extends \modTemplateVarInputRender
    {
        public function getTemplate()
        {
            $corePath = $this->modx->getOption(
                'hyvortalk.core_path',
                null,
                $this->modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/hyvortalk/'
            );

            return $corePath . 'elements/tvs/input/tpl/hyvortalkmemberships.render.tpl';
        }
        public function process($value, array $params = [])
        {
            return $value;
        }

        public function render($value,array $params = array()) {
            // load js
            if (!$this->modx->version) {
                $this->modx->getVersionData();
            }
            $version = (int) $this->modx->version['version'];
            if ($version > 2) {
                $this->hyvortalk = $this->modx->services->get('hyvortalk');
            } else {
                $corePath = $this->modx->getOption(
                    'hyvortalk.core_path',
                    null,
                    $this->modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/hyvortalk/'
                );
                $this->hyvortalk = $this->modx->getService(
                    'hyvortalk',
                    'HyvorTalk',
                    $corePath . 'model/hyvortalk/',
                    [
                        'core_path' => $corePath
                    ]
                );
            }
            $this->modx->controller->addCss($this->hyvortalk->getOption('cssUrl') . 'mgr.css');
            $this->modx->controller->addLastJavascript($this->hyvortalk->getOption('jsUrl') . 'mgr/utils/combo.js');
            $this->modx->controller->addJavascript($this->hyvortalk->getOption('jsUrl') . 'mgr/hyvortalk.js');
            $this->modx->controller->addHtml('
            <script type="text/javascript">
                Ext.onReady(function() {
                    hyvortalk.config = '.$this->modx->toJSON($this->hyvortalk->config).';
                });
            </script>
        ');
            return parent::render($value, $params);
        }

        public function getLexiconTopics()
        {
            return ['hyvortalk:default'];
        }
    }
}

return 'HyvorTalkMembershipsInputRender';