import Home from './components/Home';
import Dashboard from './components/Home/Dashboard';
import UserInfo from './components/Home/UserInfo';
import GameAccountsList from './components/Home/GameAccountsList';
import Community from "./components/Community";
import CommunityThreads from "./components/Community/CommunityThreads";

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

    {
        name: 'community',
        path: '/community',
        component: Community,
        children: [
            {
                name: 'community.threads.list',
                path: '/:id/threads',
                props: (route) => ({boardId: route.query.id}),
                component: CommunityThreads
            },
            // {
            //     name: 'community.boards.threads.show',
            //     path: '/{boardId}/threads/{threadId}',
            //     component: CommunityThread
            // }
        ]
    }
]
