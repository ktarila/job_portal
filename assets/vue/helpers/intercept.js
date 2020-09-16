import axios from "axios";
import createAuthRefreshInterceptor from "axios-auth-refresh";
import store from '../store'

const client = axios.create({
  baseURL: '',
  headers: {
    "Content-Type": "application/json",
  },
  timeout: 100000,
});

// const refreshAuthLogic = failedRequest =>
//     axios
//     .post($ { API_BASE }
//         /api/v1 / token / refresh, {
//             refreshtoken: localStorage.getItem("refreshtoken"),
//         })
//     .then(tokenRefreshResponse => {
//         localStorage.setItem("accesstoken", tokenRefreshResponse.data.data.AccessToken)
//         localStorage.setItem("refreshtoken", tokenRefreshResponse.data.data.RefreshToken)

//         failedRequest.response.config.headers.Authorization = `Bearer ${tokenRefreshResponse.data.AccessToken}`;
//         return Promise.resolve();
//     });

const refreshAuthLogic = failedRequest => {
  let refreshToken = store.getters['refreshToken'];
  store.dispatch('logout')
    
  return axios.post('/api/token/refresh', {
    refresh_token: refreshToken, pauseInstanceWhileRefreshing: true
  })
    .then(tokenRefreshResponse => {
      store.dispatch('refresh', tokenRefreshResponse)
      failedRequest.response.config.headers['Authorization'] = 'Bearer ' + tokenRefreshResponse.data.token;
      return Promise.resolve()
    })
}
createAuthRefreshInterceptor(client, refreshAuthLogic);

if (store.getters['isAuthenticated']) {
  client.interceptors.request.use(
    config => {
      const token = localStorage.getItem("token");
      if (token) {
        config.headers.Authorization = `Bearer ${token}`;
      }
      return config;
    },
    err => {
      return Promise.reject(err);
    }
  );
}

client.interceptors.response.use(
  response => {
    return response;
  },
  error => {
    if (error && error.response && error.response.status === 401) {
      return Promise.reject(error);
    }

    if (error.response.status !== 401) {
      return new Promise((resolve, reject) => {
        reject(error);
      });
    }
  }
);

const request = async options => {
  const onSuccess = response => {
    return response;
  };

  const onError = error => {
    console.log(error)
    return Promise.reject(error.response || error.message);
  };

  try {
    const response = await client(options);
    return onSuccess(response);
  } catch (error) {
    return onError(error);
  }
};

export default request;