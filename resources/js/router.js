import Vue from 'vue'
import Router from 'vue-router'
import routes from './routes'

Vue.use(Router)

const router = createRouter()

export default router

/**
 * The router factory
 */
function createRouter() {
    const router = new Router({
        mode: 'history',
        routes,
    })

    router.beforeEach(beforeEach)
    router.afterEach(afterEach)

    return router
}

/**
 * Global router guard.
 *
 * @see https://router.vuejs.org/guide/advanced/navigation-guards.html
 * @param {Route} to
 * @param {Route} from
 * @param {Function} next
 */
async function beforeEach(to, from, next) {
    // Get the matched components and resolve them.
    const components = await resolveComponents(router.getMatchedComponents({ ...to }))

    if (components.length === 0) {
        return next()
    }

    // Display the loading animation, if the promise has loaded the components.
    if (components[components.length - 1].loading !== false) {
        router.app.$nextTick(() => router.app.startLoading())
    }

    next()
}

/**
 * Global after hook.
 *
 * @param {Route} to
 * @param {Route} from
 * @param {Function} next
 */
async function afterEach(to, from, next) {
    await router.app.$nextTick()
    router.app.finishLoading()
}

/**
 * Resolve async components.
 *
 * @param  {Array} components
 * @return {Promise}
 */
function resolveComponents(components) {
    return Promise.all(
        components.map(component => {
            return typeof component === 'function' ? component() : component
        })
    )
}
