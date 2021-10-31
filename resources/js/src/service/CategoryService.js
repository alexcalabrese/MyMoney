import axios from 'axios';

export default class CategoryService {

    getCategories(){
        return axios.get('/api/categories').then(res => res.data);
    }
    
    getTree(){
        return axios.get('/api/categories/tree').then(res => res.data.data);
    }    
}
