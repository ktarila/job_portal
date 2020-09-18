import axios from 'axios';
import axiosApiInstance from '../helpers/axiosApiInstance'

export default {

  allPositions(allParams) {
    return axiosApiInstance.get('/api/positions', {
      params: allParams
    });
  },
  newPosition(data) {
    //console.log(data);
    return axios.post(
      '/api/positions', {
        csrf_token: data.csrf_token,
        title: data.title,
        isbn: data.isbn,
        description: data.description,
        year: parseInt(data.year)
      }
    );
  },
  updatePosition(data) {
    // console.log(data);
    return axios.put(
      '/api/positions/'.concat(data.id), {
        csrf_token: data.csrf_token,
        title: data.title,
        isbn: data.isbn,
        description: data.description,
        id: data.id,
        year: parseInt(data.year)
      }
    );
  },
  singlePosition(id) {
    return axios.get('/api/positions/'.concat(id), {});
  },
  removePosition(payload, csrf_token) {
    return axios.delete('/api/positions/'.concat(payload.id), { params: { token: csrf_token } });
  },
  changeCover(formData) {
    //console.log(formData);
    return axios.post('/api/position_media',
      formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
          'accept': 'application/ld+json'
        }
      }
    )
  }
}