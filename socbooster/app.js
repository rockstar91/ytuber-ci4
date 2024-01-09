import Vue from 'vue';
import VueRouter from 'vue-router';
import ToggleButton from 'vue-js-toggle-button';
import Toasted from 'vue-toasted';
import VueSlider from 'vue-slider-component';
import vueSlider from 'vue-slider-component';
import VueGtm from 'vue-gtm';
import VueAnalytics from 'vue-analytics'
import 'vue-slider-component/theme/default.css';
import loading from 'vue-loading-overlay';
import {BootstrapVue} from 'bootstrap-vue';
import TaskList from './components/TaskList.vue';
import TaskListFilter from './components/TaskListFilter.vue';
import TaskListCompleteFilter from './components/TaskListCompleteFilter.vue';
import TaskForm from './components/TaskForm.vue';
import maincomponent from './components/Main.vue';
import Profile from './components/Profile.vue';
import TaskManager from './components/TaskManager.vue';
import floatnav from './components/FloatNav.vue';
import Sidebar from './components/Sidebar.vue';
import SidebarLeft from './components/SidebarLeft.vue';
import User from './components/User.vue';
import Users from './components/Users.vue';
import TaskCompleteList from './components/TaskCompleteList.vue';
import TaskComplete from './components/TaskComplete.vue';
import WaitringApprove from './components/WaitringApprove.vue';
import AutoAssigned from './components/AutoAssigned.vue';
import Completed from './components/Completed.vue';
import VueYoutube from 'vue-youtube-embed';
import ytClientAuto from './components/ytClientAuto.vue';
import Task from './components/Task.vue';
import AddRatingPage from './components/AddRatingPage.vue';
import YtClient from './components/ytClient.vue';
import NavBar from './components/NavBar.vue';
import TaskEditForm from './components/TaskEditForm.vue';

var VueTruncate = require('vue-truncate-filter');

Vue.use(BootstrapVue);

Vue.use(loading, {
    // props
    color: 'red',
    loader: 'dots'
}, {
    // slots
})

//    require('./bootstrap');


window.Vue = require('vue');
window.axios = require('axios');
window.$ = require('jquery');
window.JQuery = require('jquery');

//Vue.component('vueSlider', require('vue-slider-component/src/vue2-slider.vue'));

Vue.component('VueSlider', VueSlider);

//const router = new VueRouter({ routes, mode, linkActiveClass });

Vue.use(VueGtm, {
    id: 'GTM-NQC7TDB', // Your GTM single container ID or array of container ids ['GTM-xxxxxxx', 'GTM-yyyyyyy']
    queryParams: { // Add url query string when load gtm.js with GTM ID (optional)
        gtm_auth: 'AB7cDEf3GHIjkl-MnOP8qr',
        gtm_preview: 'env-4',
        gtm_cookies_win: 'x'
    },
    enabled: true, // defaults to true. Plugin can be disabled by setting this to false for Ex: enabled: !!GDPR_Cookie (optional)
    debug: true, // Whether or not display console logs debugs (optional)
    loadScript: true, // Whether or not to load the GTM Script (Helpful if you are including GTM manually, but need the dataLayer functionality in your components) (optional)
    vueRouter: router, // Pass the router instance to automatically sync with router (optional)
    ignoredViews: ['homepage'] // If router, you can exclude some routes name (case insensitive) (optional)
});

Vue.use(VueAnalytics, {
    id: 'UA-150369917-1',
    autoTracking: {
        screenview: true
    }
})
Vue.use(Toasted, {
    duration: 1500, iconPack: 'custom-class', theme: 'bubble'

});
/* Import components */

Vue.use(VueTruncate);

Vue.use(VueYoutube);
Vue.use(YtClient);
Vue.use(VueRouter);
Vue.use(ToggleButton);

const routes = [
    {
        name: 'Sidebar',
        path: '/',
        components: {
            default: maincomponent,
            Sidebar: Sidebar,
            SidebarLeft: SidebarLeft,
            AddRatingPage: AddRatingPage,
            NavBar: NavBar,
            floatnav: floatnav
        },
    },
    {
        name: 'Home',
        path: '/home',
        components: {default: maincomponent, Sidebar: Sidebar, SidebarLeft: SidebarLeft},
    },
    {
        name: 'Tasks',
        path: '/tasks',
        components: {
            default: TaskList,
            Filter: TaskListFilter,
            floatnav: floatnav,
            Sidebar: Sidebar,
            SidebarLeft: SidebarLeft,
            NavBar: NavBar,
        },
    },
    {
        name: 'MyTasks',
        path: '/mytasks',
        components: {
            default: TaskList,
            Filter: TaskListFilter,
            floatnav: floatnav,
            Sidebar: Sidebar,
            SidebarLeft: SidebarLeft,
            NavBar: NavBar,
        },
    },
    {
        name: 'CreateTask',
        path: '/create-task/',
        components: {default: TaskForm, Sidebar: Sidebar, SidebarLeft: SidebarLeft, floatnav: floatnav, NavBar: NavBar}
    },
    {
        name: 'EditTask',
        path: '/edit-task/:task_id',
        components: {
            default: TaskEditForm,
            Sidebar: Sidebar,
            SidebarLeft: SidebarLeft,
            floatnav: floatnav,
            NavBar: NavBar
        },
        props: true
    },
    {
        name: 'CreateTaskFrom',
        path: '/addtaskrating',
        components: {default: TaskForm, Sidebar: Sidebar, SidebarLeft: SidebarLeft, floatnav: floatnav, NavBar: NavBar},
        props: {TaskUrl: null, TaskName: null, TaskImage: null, TaskDesc: null}
    },
    {
        name: 'TaskCompleteList',
        path: '/complete-tasks',
        components: {
            default: TaskCompleteList,
            Sidebar: Sidebar,
            SidebarLeft: SidebarLeft,
            floatnav: floatnav,
            Filter: TaskListCompleteFilter,
            NavBar: NavBar,
            YtClient: YtClient
        },
        props: {default: true, videoId: null},
        meta: {gtm: 'MyCustomValue'}
    },
    {
        name: 'TaskComplete',
        path: '/complete/:task_id',
        components: {
            default: TaskComplete,
            Sidebar: Sidebar,
            SidebarLeft: SidebarLeft,
            floatnav: floatnav,
            Filter: TaskListCompleteFilter,
            NavBar: NavBar,
            YtClient: YtClient
        },
        props: {default: true, videoId: null},
        meta: {gtm: 'MyCustomValue'}
    },
    {
        name: 'autoview',
        path: '/autoview',
        components: {
            default: ytClientAuto,
            Sidebar: Sidebar,
            SidebarLeft: SidebarLeft,
            floatnav: floatnav,
            Filter: TaskListCompleteFilter,
            NavBar: NavBar,
        },
        props: {default: true, videoId: null},
        meta: {gtm: 'MyCustomValue'}
    },
    {
        name: 'User',
        path: '/user/:user_id',
        components: {default: User, Sidebar: Sidebar, SidebarLeft: SidebarLeft, floatnav: floatnav, NavBar: NavBar},
        props: true
    },
    {
        name: 'auto',
        path: '/autoassigned',
        components: {
            default: AutoAssigned,
            Sidebar: Sidebar,
            SidebarLeft: SidebarLeft,
            floatnav: floatnav,
            NavBar: NavBar
        },
        props: true
    },

    {
        name: 'completed',
        path: '/completed',
        components: {
            default: Completed,
            Sidebar: Sidebar,
            SidebarLeft: SidebarLeft,
            floatnav: floatnav,
            NavBar: NavBar
        },
        props: true
    },
    {
        name: 'WaitringApprove',
        path: '/waitringapprove',
        components: {
            default: WaitringApprove,
            Sidebar: Sidebar,
            SidebarLeft: SidebarLeft,
            floatnav: floatnav,
            NavBar: NavBar
        },
        props: true
    },
    {
        name: 'Users',
        path: '/users/',
        components: {default: Users, Sidebar: Sidebar, SidebarLeft: SidebarLeft, floatnav: floatnav, NavBar: NavBar},
        props: true
    },
    {
        name: 'AddRatingPage',
        path: '/pages/',
        components: {default: AddRatingPage, Sidebar: Sidebar, SidebarLeft: SidebarLeft, NavBar: NavBar},
        props: {default: true, videoId: null}
    },
    {
        name: 'youtubeplayer',
        path: '/youtubeplayer/',
        components: {default: YtClient, Sidebar: Sidebar, SidebarLeft: SidebarLeft, floatnav: floatnav, NavBar: NavBar},
        props: {default: true, videoId: null, maxtime: null}
    },
    {
        name: 'Task',
        path: '/task/:task_id',
        components: {
            default: TaskManager,
            floatnav: floatnav,
            Sidebar: Sidebar,
            SidebarLeft: SidebarLeft,
            NavBar: NavBar,
        },
        props: true
    },
    {
        name: 'TaskFilter',
        path: '/taskfilter',
        components: {
            default: TaskList,
            a: TaskListFilter,
        }
        ,
    },
    {
        name: 'Profile',
        path: '/profile',
        components: {default: Profile, floatnav: floatnav, Sidebar: Sidebar, SidebarLeft: SidebarLeft, NavBar: NavBar},
    },
];

var router = new VueRouter({
    routes: routes,
    mode: 'history'
});

const app = new Vue({

    el: '#app',
    components: {
        TaskListFilter,
        Task,
        TaskList,
        TaskForm,
        vueSlider,
        maincomponent,
        Profile,
        TaskManager,
        floatnav,
        Sidebar,
        SidebarLeft,
        Users,
        TaskCompleteList,
        VueYoutube,
        YtClient,
        AddRatingPage,
        TaskEditForm,
    },
    router: router,
});
export default router
