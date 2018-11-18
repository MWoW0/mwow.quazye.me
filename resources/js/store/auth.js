export default {
    state: {
        currentUser: null
    },

    getters: {
        currentUser: state => state.currentUser
    },

    mutations: {
        SET_CURRENT_USER (state, user) {
            state.currentUser = user;
        }
    },

    actions: {
        async fetchCurrentUser({ commit }) {
            const { data } = await axios.get('/api/current-user')

            commit('SET_CURRENT_USER', data);
        },

        async updateCurrentUser({ commit }, form) {
            const { data } = await form.patch('/api/current-user');

            commit('SET_CURRENT_USER', data);
        }
    }
}
