import {get} from 'axios'

export default {
    state: {
        boards: [],

        threads: []
    },

    getters: {
        communityBoards: state => state.boards,
        communityThreads: state => state.threads
    },

    mutations: {
        SET_BOARDS(state, boards) {
            state.boards = boards;
        },

        SET_THREADS(state, threads) {
            state.threads = threads;
        }
    },

    actions: {
        async fetchCommunityBoards({commit}) {
            commit('SET_BOARDS', {
                id: 1,
                name: 'News',
                icon: 'newspaper'
            });

            // const {data} = await get('/api/community-boards');
            //
            // commit('SET_BOARDS', data.data);
            //
            // return data;
        },

        async fetchCommunityThreads({commit}, {boardId, page}) {
            commit('SET_THREADS', [
                {
                    title: 'Welcome',
                    tags: ['hello', 'world'],
                    description: 'hello world'
                },
                {
                    title: 'Announcements',
                    tags: ['news', 'announcements'],
                    description: null
                },
            ])

            // const { data } = await get(`/api/boards/${this.boardId}/threads`, {
            //   params: {
            //       page: page
            //   }
            // });
            //
            // commit('SET_THREADS', data.data);
            //
            // return data;
        },
    }
}
