import axios from 'axios';

export default class LabelService {

    getCategories() {
        return axios.get('/api/labels').then(res => res.data);
    }

    getTree() {
        return axios.get('/api/labels/tree').then(res => res.data.data);
    }
}