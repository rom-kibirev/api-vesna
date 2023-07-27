import axios from "axios";

const TestRequests = (props) => {

    const categoriesGet = () => {

        console.log('\n get', );

        axios.get('https://httpbin.org/get').then(response => {
            console.log('\n ', response);
        }).catch(error => console.log('\n error', error));
    };

    return (
        <div>
            <button onClick={categoriesGet}>Получить список категорий</button>
        </div>
    );
}

export default TestRequests;