function getMany(url, parameters = null) {
    let urlParameters = parameters ? "?" + urlEncodeParameters(parameters) : "";
    return fetch(url + urlParameters)
        .then(response => {
            return new Promise((success) => {
                if (200 === response.status) {
                    response.json().then(data => {
                        success({
                            data: data,
                            count: response.headers.get('X-Total-Count')
                        });
                    });
                } else if (204 === response.status) {
                    success({
                        data: [],
                        count: 0
                    });
                } else {
                    logError(response);
                }
            });
        });
}

function getOne(url, parameters = null) {
    let urlParameters = parameters ? "?" + urlEncodeParameters(parameters) : "";
    return fetch(url + urlParameters)
        .then(response => {
            return new Promise((success) => {
                if (200 === response.status) {
                    success(response.json());
                } else if (404 === response.status) {
                    success(null);
                } else {
                    logError(response);
                }
            });
        });
}

function post(url, parameters) {
    return postAndPut('POST', url, parameters);
}

function put(url, parameters) {
    return postAndPut('PUT', url, parameters);
}

function postAndPut(action, url, parameters) {
    return fetch(url, {
        method: action,
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: urlEncodeParameters(parameters)
    })
        .then(response => {
            return new Promise((success, error) => {
                true === response.ok ? success(response.json()) : error(response.json());
            });
        });
}

function deleteOne() {
    return fetch(url + "/" + id, {
        method: 'DELETE',
    })
        .then(response => {
            return new Promise((success) => {
                if (200 === response.status) {
                    success(response.json());
                } else if (204 === response.status) {
                    success([]);
                } else {
                    logError(response);
                }
            });
        });
}

function logError(response) {
    console.log('An error as occurred (code: ' + response.status + ')');
}

function urlEncodeParameters(parametersBag) {
    if (null === parametersBag) {
        return "";
    }

    var parameters = [];
    Object.keys(parametersBag).map(function(key) {
        let parameter = null;
        let value     = parametersBag[key];

        if (Array.isArray(parametersBag[key])) {
            parameter = value.join();
        } else {
            parameter = value;
        }

        if (undefined !== value && '' !== value) {
            parameters.push(key + "=" + parameter);
        }
    });

    return parameters.join('&')
}

const ApiClient = {
    getMany, getOne, post, put, deleteOne
};

export default ApiClient;