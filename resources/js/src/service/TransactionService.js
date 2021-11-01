import axios from 'axios';

export default class TransactionService {

    getTotalCosts(currentMonth){
        return axios.get('/api/transactions/totalCosts', {
            params: {
                date: currentMonth
            }
        }).then(res => res.data);
    }
    
    getTotalEarnings(currentMonth){
        return axios.get('/api/transactions/totalEarnings', {
            params: {
                date: currentMonth
            }
        }).then(res => res.data);
    }

    getTotalBalance(currentMonth){
        return axios.get('/api/transactions/totalBalance', {
            params: {
                date: currentMonth
            }
        }).then(res => res.data);
    }

    getTransactions() {
        return axios.get('/api/transactions').then(res => res.data.data);
    }    

    getMonthTransactions(currentMonth) {
        return axios.get('/api/transactions/months', {
            params: {
                date: currentMonth
            }
        }).then(res => res.data.data);
    }    
}
