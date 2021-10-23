import axios from 'axios';

export default class TransactionService {

    getTotalCosts(){
        return axios.get('/api/transactions/totalCosts').then(res => res.data);
    }
    
    getTotalEarnings(){
        return axios.get('/api/transactions/totalEarnings').then(res => res.data);
    }

    getTotalBalance(){
        return axios.get('/api/transactions/totalBalance').then(res => res.data);
    }

    getTransactions() {
		return axios.get('/api/transactions').then(res => res.data.data);
    }
    
}
