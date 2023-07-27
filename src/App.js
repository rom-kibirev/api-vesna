import React, { useState } from 'react';
import axios from 'axios';

const App = () => {

    const [userUrl,setUserUrl] = useState('http://testapi.runtec.rom-kibirev.ru');
    const [username, setUsername] = useState();
    const [password, setPassword] = useState();
    const [message, setMessage] = useState('');
    const [showButtons, setShowButtons] = useState(false);
    const [data, setData] = useState ();

    const apiUrl = 'https://www.runtec-shop.com/api/';
    const handleLogin = async (e) => {
        e.preventDefault();
        try {
            const response = await axios.post(`${apiUrl}`, {
                username: username,
                password: password,
                test: "test"
            }, {headers: {
                    'Accept': 'application/json, text/plain, */*',
                    'Content-Type': 'application/x-www-form-urlencoded'
            }});
            setMessage(response.data.message);
            setShowButtons(response.data.showButtons);
        } catch (error) {
            setMessage('Ошибка авторизации');
            setShowButtons(false);
        }
    };
    const handleGetData = async (command) => {
        try {
            const response = await axios.get(`${apiUrl}?command=${command}&url=${userUrl}`, {
                withCredentials: true, // Включение передачи куки
                auth: {
                    username: username,
                    password: password
                },
            });

            setData(response.data);

            console.log(response.data);
        } catch (error) {
            console.log('Ошибка при получении данных');
        }
    };
    const handlePostData = (command) => {

        const data = {
            json: [],
            command: command,
        };

        const config = {
            auth: {
                username: username,
                password: password,
            },
            // withCredentials: true,
        };


        axios.post(`${apiUrl}post.php`, JSON.stringify(data), config)
            .then(response => {
                console.log('Ответ от сервера:', response.data);
            })
            .catch(error => {
                console.error('Ошибка при отправке запроса:', error);
            });
    };

    console.log('\n ', userUrl);

    return (
        <div style={{padding: '10px'}}>
            <h1>Модуль авторизации и отправки запросов</h1>
            <form onSubmit={handleLogin}>
                <input
                    type="text"
                    placeholder="Имя пользователя"
                    value={username}
                    onChange={(e) => setUsername(e.target.value)}
                />
                <input
                    type="password"
                    placeholder="Пароль"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                />
                <button type="submit">Войти</button>
            </form>
            <p>{message}</p>
            {showButtons && (
                <div>
                    <h2>GET запросы</h2>
                    <input
                        type="text"
                        name="userUrl"
                        value={userUrl}
                        onChange={(e) => setUserUrl(e.target.value)}
                    />
                    <button onClick={() => handleGetData('goods')}>Данные по товарам</button>
                    <button onClick={() => handleGetData('category')}>Данные по категориям</button>
                    <hr />

                    <h2>POST запросы</h2>
                    <button onClick={() => handlePostData('goods')}>Данные по товарам</button>
                    <button onClick={() => handlePostData('category')}>Данные по категориям</button>
                </div>
            )}
            {data && data.map((d,i) =>
                <pre key={i}>{JSON.stringify(d, null, 2)}</pre>
            )}
        </div>
    );
};

export default App;
