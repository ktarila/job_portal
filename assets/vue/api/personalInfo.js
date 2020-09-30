import axiosApiInstance from '../helpers/axiosApiInstance'


export default {

  createPersonalInfo(formData) {
    console.log(formData);
    return axiosApiInstance.post('/api/personal-info',
      formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
          'accept': 'application/ld+json'
        }
      }
    )
  },

  singlePersonalInfo(id) {
    return axiosApiInstance.get('/api/personal_infos/'.concat(id), {});
  },
}