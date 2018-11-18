import Home from './components/Home';
import Dashboard from './components/Home/Dashboard';
import UserInfo from './components/Home/UserInfo';
import GameAccountsList from './components/Home/GameAccountsList';

export default [
    {
        path: '/home',
        component: Home,
        children: [
            {
                name: 'home.dashboard',
                path: '/',
                component: Dashboard,
            },
            {
                name: 'home.user.details',
                path: 'details',
                component: UserInfo,
            },
            {
                name: 'home.game-accounts.list',
                path: 'accounts',
                component: GameAccountsList
            }
        ]
    },


]
