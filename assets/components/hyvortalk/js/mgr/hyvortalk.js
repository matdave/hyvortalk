var \Matdave\HyvorTalk = function (config) {
    config = config || {};
    \Matdave\HyvorTalk.superclass.constructor.call(this, config);
};
Ext.extend(\Matdave\HyvorTalk, Ext.Component, {

    page: {},
    window: {},
    grid: {},
    tree: {},
    panel: {},
    combo: {},
    field: {},
    config: {},

});
Ext.reg('hyvortalk', \Matdave\HyvorTalk);
hyvortalk = new \Matdave\HyvorTalk();
