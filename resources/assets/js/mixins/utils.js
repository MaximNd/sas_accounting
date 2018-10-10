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
        isString(value) {
            return typeof value === 'string';
        },
        // Returns if a value is null
        isNull (value) {
            return value === null;
        },
        // Returns if a value is really a number
        isNumber (value) {
            return typeof value === 'number' && isFinite(value);
        },
        // Returns if a value is undefined
        isUndefined (value) {
            return typeof value === 'undefined';
        },
        addTwoFloats(fl1, fl2) {
            return parseFloat((fl1 + fl2).toFixed(2));
        },
        subtractTwoFloats(fl1, fl2) {
            return parseFloat((fl1 - fl2).toFixed(2));
        },
        multiplyTwoFloats(fl1, fl2) {
            return parseFloat((fl1 * fl2).toFixed(2));
        },
        declOfNum(number, titles) {
            const cases = [2, 0, 1, 1, 1, 2];
            return titles[ (number%100>4 && number%100<20)? 2 : cases[(number%10<5)?number%10:5] ];
        }
    }
};
