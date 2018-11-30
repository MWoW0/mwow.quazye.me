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
        },

        ADD_GAME_ACCOUNT(state, account) {
            const index = state.gameAccounts.findIndex(ga => ga.id === account.id);

            if (index === -1) {
                state.gameAccounts.push(account);
            }
        },

        UPDATE_GAME_ACCOUNT(state, account) {
            const index = state.gameAccounts.findIndex(ga => ga.id === account.id);

            if (index !== -1) {
                state.gameAccounts[index] = account;
            }
        },

        DELETE_GAME_ACCOUNT(state, account) {
            state.gameAccounts = state.gameAccounts.filter(ga => ga.id !== account.id);
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
