import {useEffect} from "react";
import axios from "axios";


const PHPdirect = (props) => {

    useEffect(() => {

        const login = 'runtec@local.local';
        const password = '1tzjabSQ';
        const command = 'goods';

        axios.get(`http://testapi.runtec.rom-kibirev.ru/?login=${login}&password=${password}&command=${command}`, {
            responseType: 'json'
        })
            .then(response => {
                console.log(response.data); // Вывод полученных данных в консоль
            })
            .catch(error => {
                console.error(error);
            });
    },[]);

    return (
        <div>PHPdirect</div>
    );
}

export default PHPdirect;