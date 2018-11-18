export default {
    actions: {
        updateComment({}, { comment, form }) {
            const id = comment.id ? comment.id : comment;

            return form.put(`/api/comments/${id}`);
        },

        destroyComment({}, comment) {
            const id = comment.id ? comment.id : comment;

            return axios.delete(`/api/comments/${id}`);
        },
    }
}
