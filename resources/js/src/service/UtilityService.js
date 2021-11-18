import axios from 'axios';

export default class UtilityService {
    formatCurrency(value, type) {
        return (
            type +
            value.toLocaleString("it-IT", { style: "currency", currency: "EUR" })
        );
    }

    formatDate(date) {
        return [date.getMonth() + 1] + "-" + date.getFullYear();
    }

    toJSONLocal(date) {
        var local = new Date(date);
        local.setMinutes(date.getMinutes() - date.getTimezoneOffset());
        return local.toJSON().slice(0, 10);
    }

    getCurrentMonth() {
        const today = new Date();

        return today;
    }

    removeYear(date) {
        return date.slice(0, 5);
    }

    revertDateString(str){
        return str.split('-').reverse().join('-');
    }
}