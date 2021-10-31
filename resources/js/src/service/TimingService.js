import axios from 'axios';

export default class TimingService {

    getTimings(){
        return axios.get('/api/timings').then(res => res.data);
    }
    
    getTree(){
        return axios.get('/api/timings/tree').then(res => res.data.data);
    }    
}
