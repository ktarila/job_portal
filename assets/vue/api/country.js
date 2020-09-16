import axiosApiInstance from '../helpers/axiosApiInstance'

export default {

  allCountries(allParams) {
    return axiosApiInstance.get('/api/countries', {
      params: allParams
    });
  }
}