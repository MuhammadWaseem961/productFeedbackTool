// axios.js (or any other name)
import axios from 'axios';
import store from "../stores/index"

const axiosInstance = axios.create({
  baseURL: store.state.apiUrl, // Set your API base URL
  headers: {
    'token': store.state.user.token || '', // user authorization token
    'id': store.state.user.id || '', // login user id
  },
});

export default axiosInstance;