var HyvorTalk = function (config) {
    config = config || {};
    HyvorTalk.superclass.constructor.call(this, config);
};
Ext.extend(HyvorTalk, Ext.Component, {

    page: {},
    window: {},
    grid: {},
    tree: {},
    panel: {},
    combo: {},
    field: {},
    config: {},

});
Ext.reg('hyvortalk', HyvorTalk);
hyvortalk = new HyvorTalk();
