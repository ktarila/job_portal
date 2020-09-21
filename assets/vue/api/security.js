// import axiosApiInstance from '../helpers/axiosApiInstance'
import axios from 'axios'

export default {
  login (email, password) {
    return axios.post(
      '/api/login_check',
      {
        'email': email,
        'password': password
      }
    );
  },
}