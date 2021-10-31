import axios from 'axios';

export default class StateService {

    getStates(){
        return axios.get('/api/states').then(res => res.data);
    }
    
    getTree(){
        return axios.get('/api/states/tree').then(res => res.data.data);
    }    
}
