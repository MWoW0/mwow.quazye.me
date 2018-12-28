import Vue from 'vue'
import Vuex from 'vuex'
import auth from './store/auth';
import comments from "./store/comments";
import gameAccounts from './store/game-accounts';
import community from './store/community';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        auth: auth,
        comments: comments,
        gameAccounts: gameAccounts,
        community: community
    }
})
