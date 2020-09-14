import axios from 'axios';

export default {

  allCountries(allParams) {
    return axios.get('/api/countries', {
      params: allParams
    });
  }
}