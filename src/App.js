import React, { useState, useEffect } from 'react';
import axios from 'axios';
import categoryData from './test_category.json';
import goodsData from './test_goods.json';

const App = () => {

    const [username, setUsername] = useState('');
    const [password, setPassword] = useState('');
    const [data, setData] = useState ();
    const [filename, setFilename] = useState ();

    const apiUrl = 'https://runtec-shop.com/api';

    const postHandler = (type) => {

        const jsonData = type === 'category' ? categoryData : goodsData;
        const data = {
            username: username,
            password: password,
            json: JSON.stringify(jsonData),
            type: type
        };
        const headers= {
            'Accept': 'application/json, text/plain, */*',
            'Content-Type': 'application/x-www-form-urlencoded'
        };

        axios.post(`${apiUrl}/index.php`, data, {headers: headers})
            .then(response => {
                console.log(`\n `, response);
                setFilename(response.data.filename);
            })
            .catch(error => console.log(`\n error`, error))
    };

    useEffect(() => {
        if (filename) axios.get(`https://runtec-shop.com/${filename}`)
            .then(response => {
                // Записать данные в состояние setData
                setData(response.data);
            })
            .catch(error => {
                console.error('Произошла ошибка:', error);
                // Обработка возможных ошибок при выполнении запроса
            });
    }, [filename]);

    return (
        <div style={{padding: '10px'}}>
            <div>
                <h2>Отправка запросов</h2>
                <div>
                    <input
                        type="text"
                        placeholder="Имя пользователя"
                        value={username}
                        onChange={(e) => setUsername(e.target.value)}
                    />
                </div>
                <div>
                    <input
                        type="password"
                        placeholder="Пароль"
                        value={password}
                        onChange={(e) => setPassword(e.target.value)}
                    />
                </div>
                <div>
                    <button onClick={() => postHandler('goods')}>Отправить данные по товарам</button>
                </div>
                <div>
                    <button onClick={() => postHandler('category')}>Отправить данные по категориям</button>
                </div>
            </div>

            {data &&
                <div>
                    <h2>Данные успешно сохранены</h2>
                    <a href={`https://runtec-shop.com/${filename}`} target="_blank" rel="noopener noreferrer">Посмотреть файл</a>
                    {data.map((d, i) => <pre key={i}>{JSON.stringify(d, null, 2)}</pre>)}
                </div>
            }
        </div>
    );
};

export default App;
