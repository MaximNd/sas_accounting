export default {
    methods: {
        /**
         *
         * @param {HTMLElement} elem
         * @param {Object} styles
         */
        // Returns if a value is an object
        isObject(value) {
            return !!value && typeof value === 'object' && value.constructor === Object;
        },
        // Returns if a value is null
        isNull (value) {
            return value === null;
        },
        // Returns if a value is undefined
        isUndefined (value) {
            return typeof value === 'undefined';
        },
        addTwoFloats(fl1, fl2) {
            return parseFloat((fl1 + fl2).toFixed(2));
        },
        multiplyTwoFloats(fl1, fl2) {
            return parseFloat((fl1 * fl2).toFixed(2));
        }
    }
};
