export default {
    methods: {
        /**
         *
         * @param {String} value
         * @param {Object} objToUpdate
         * @param {String} key
         */
        replaceComma(value, objToUpdate, key, validationKey = key) {
            const val = value.replace(/,/i, '.').trim();
            this.$set(objToUpdate, key, val);
            this.$validator.validate(validationKey, objToUpdate[key]);
        },
    }
};
