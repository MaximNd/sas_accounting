export default {
    methods: {
        /**
         *
         * @param {HTMLElement} elem
         * @param {Object} styles
         */
        setStyles(elem, styles) {
            Object.keys(styles).forEach(function (key) {
                elem.style[key] = styles[key];
            });
        }
    }
};
