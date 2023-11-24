(function () {
    var settings = window.wc.wcSettings.getSetting('simplepay-gateway_data', {});
    var label = window.wp.htmlEntities.decodeEntities(settings.title) || 'SimplePay';
    var Content = function () {
        return window.wp.htmlEntities.decodeEntities(settings.description || '');
    };

    window.wc.wcBlocksRegistry.registerPaymentMethod({
        name: 'simplepay-gateway',
        label: React.createElement('img', {
            src: settings.icon,
            alt: window.wp.htmlEntities.decodeEntities(settings.title || 'SimplePay'),
        }),
        content: Object(window.wp.element.createElement)(Content, null),
        edit: Object(window.wp.element.createElement)(Content, null),
        canMakePayment: function () {
            return true;
        },
        ariaLabel: label,
        supports: {
            features: settings.supports,
        },
    });
})();
