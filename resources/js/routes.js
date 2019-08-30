import Home from './components/Home';
import History from './components/History';
import Favorite from './components/Favorite';
import NotFound from './components/NotFound';
import Login from './components/Login';

export default {
    mode: 'history',

    routes: [
        {
            path: '*',
            component: NotFound
        },
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
        {
            path: '/history',
            name: 'history',
            component: History
        },
        {
            path: '/favorite',
            name: 'favorite',
            component: Favorite
        },
    ]
};