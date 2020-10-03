import axiosApiInstance from '../helpers/axiosApiInstance'


export default {

  createPersonalInfo(formData) {
    // console.log(formData);
    return axiosApiInstance.post('/api/personal_info',
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

  updatePersonalInfo(data) {
    // console.log(data);
    return axiosApiInstance.put(
      '/api/personal_infos/'.concat(data.id), data
    );
  },

  changeAvatar(formData, id) {
    // console.log(formData);
    return axiosApiInstance.post('/api/personal_info/update-avatar/'.concat(id),
      formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
          'accept': 'application/ld+json'
        }
      }
    )
  }
}