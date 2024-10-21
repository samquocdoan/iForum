"use strict";

async function asyncFetch(url, options = {}) {
    const controller = new AbortController();
    const { signal } = controller;
    const timeout = options.timeout || 10000;

    const fetchOptions = {
        method: options.method || 'GET',
        Headers: {
            'Content-Type': 'application/json',
            ...options.headers
        },
        body: options.method === 'POST' || options.method === 'PUT' ? JSON.stringify(options.body) : null,
        signal
    }

    const timeoutId = setTimeout(() => controller.abort(), timeout);

    try {
        const response = await fetch(url, fetchOptions);
        const result = await response.json();
        clearTimeout(timeoutId);

        if (response.ok) {
            return result.data;
        } else {
            return result.error;
        }

    } catch(e) {
        throw e;
    }
}