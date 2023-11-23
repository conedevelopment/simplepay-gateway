(function () {
    const settings = window.wc.wcSettings.getSetting('simplepay-gateway_data', {});
    const label = window.wp.htmlEntities.decodeEntities(settings.title) || 'SimplePay';
    const Content = () => {
        return window.wp.htmlEntities.decodeEntities(settings.description || '');
    };
    const SimplePayCheckout = {
        name: 'simplepay-gateway',
        label: React.createElement('img', {
            src: `${settings.icon}`,
            alt: window.wp.htmlEntities.decodeEntities(settings.title || 'SimplePay'),
        }),
        content: Object(window.wp.element.createElement)(Content, null),
        edit: Object(window.wp.element.createElement)(Content, null),
        canMakePayment: () => true,
        ariaLabel: label,
        supports: {
            features: settings.supports,
        },
    };
    window.wc.wcBlocksRegistry.registerPaymentMethod(SimplePayCheckout);
})();