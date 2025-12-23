<?php

if (!class_exists('HyvorTalkMembershipsOutputRender')) {
    class HyvorTalkMembershipsOutputRender extends \modTemplateVarOutputRender
    {
        public function process($value, array $params = [])
        {
            return $value;
        }
    }
}

return 'HyvorTalkMembershipsOutputRender';