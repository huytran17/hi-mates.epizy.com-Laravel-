window.isbusy = false;
var cancelTokenSource = axios.CancelToken.source();

axios.defaults.headers.common['Charset'] = 'utf-8';

axios.interceptors.request.use((config) => {
    if (!window.isbusy) {
        window.isbusy = true;
        NProgress.start();
        //remove previous cancel tokens if has any
        if (cancelTokenSource) cancelTokenSource = axios.CancelToken.source();
        config.cancelToken = cancelTokenSource.token;
        return config;
    } else {
        cancelTokenSource.cancel('request not available');
        return config;
    }
}, (error) => {
    window.isbusy = false;
    cancelTokenSource.cancel('request failed');
    return Promise.reject(error);
});

axios.interceptors.response.use((response) => {
    NProgress.done();
    //NProgress.remove();
    window.isbusy = false;
    return response;
}, (error) => {
    window.isbusy = false;
    return Promise.reject(error);
});