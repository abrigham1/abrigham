let axios = require('axios');
global.axios = axios;

// mock the IntersectionObserver
global.IntersectionObserver = class IntersectionObserver {
    constructor() {}

    disconnect() {
        return null;
    }

    observe() {
        return null;
    }

    takeRecords() {
        return null;
    }

    unobserve() {
        return null;
    }
};
