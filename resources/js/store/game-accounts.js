export default {
    state: {
        gameAccounts: []
    },

    getters: {
        gameAccounts: state => state.gameAccounts
    },

    mutations: {
        SET_GAME_ACCOUNTS(state, accounts) {
            state.gameAccounts = accounts;
        }
    },

    actions: {
        async fetchGameAccounts({commit}, params) {
            const {data} = await axios.get('/api/game-accounts', {params: params});

            commit('SET_GAME_ACCOUNTS', data.data);

            return data;
        }
    }
}
