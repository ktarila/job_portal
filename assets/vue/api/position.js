import axiosApiInstance from '../helpers/axiosApiInstance'
import moment from 'moment'

export default {

  allPositions(allParams) {
    return axiosApiInstance.get('/api/positions', {
      params: allParams
    });
  },
  newPosition(data) {
    // console.log(data);
    return axiosApiInstance.post(
      '/api/positions', {
        name: data.title,
        country: data.country['@id'],
        state: data.state['@id'],
        deadline: moment(data.deadline).format('YYYY-MM-DD'),
        description: data.description
      }
    );
  },
  updatePosition(data) {
    // console.log(data);
    return axiosApiInstance.put(
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
    return axiosApiInstance.get('/api/positions/'.concat(id), {});
  },
  removePosition(payload, csrf_token) {
    return axiosApiInstance.delete('/api/positions/'.concat(payload.id), { params: { token: csrf_token } });
  },
  changeCover(formData) {
    //console.log(formData);
    return axiosApiInstance.post('/api/position_media',
      formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
          'accept': 'application/ld+json'
        }
      }
    )
  }
}