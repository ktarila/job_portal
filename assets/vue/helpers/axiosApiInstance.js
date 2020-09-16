import axios from 'axios'
import store from '../store'
import router from '../router'
import createAuthRefreshInterceptor from 'axios-auth-refresh';

const axiosApiInstance = axios.create({baseURL: ''});

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
createAuthRefreshInterceptor(axiosApiInstance, refreshAuthLogic);

if (store.getters['isAuthenticated']) {
  axiosApiInstance.interceptors.request.use(
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

axiosApiInstance.interceptors.response.use(
  response => {
    return response;
  },
  error => {
    if (error && error.response && error.response.status === 401) {
      // 401 error redirect to login
      router.push({path: '/ads/login'})
      
      return Promise.reject(error);
    }

    if (error.response.status !== 401) {
      return new Promise((resolve, reject) => {
        reject(error);
      });
    }
  }
);



export default axiosApiInstance;