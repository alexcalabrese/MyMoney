import axios from 'axios';

export default class CategoryService {

    getCategories(){
        return axios.get('/api/categories').then(res => res.data);
    }

    getCategoriesLabels(){
        return axios.get('/api/categories').then(res => res.data.data);
    }
    
    getTree(){
        return axios.get('/api/categories/tree').then(res => res.data.data);
    }    
}
