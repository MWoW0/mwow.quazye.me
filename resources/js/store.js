import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

import auth from './store/auth';
import comments from "./store/comments";

export default new Vuex.Store({
    modules: {
        auth: auth,
        comments: comments
    }
})
