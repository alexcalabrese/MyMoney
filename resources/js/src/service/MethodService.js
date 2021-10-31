import axios from 'axios';

export default class MethodService {

    getCategories(){
        return axios.get('/api/methods').then(res => res.data);
    }
    
    getTree(){
        return axios.get('/api/methods/tree').then(res => res.data.data);
    }    
}
