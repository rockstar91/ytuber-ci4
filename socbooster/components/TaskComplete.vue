<template>
    <div>
        <div class="content">
            <loading :active.sync="loading"
                     :can-cancel="false"
                     :on-cancel="onCancel"
                     :is-full-page="true" loader="dots" color="green"></loading>
            <!-- Image grid -->
            <div class="d-flex flex-column bg-light border rounded p-2">
                <div class="d-flex flex-column" v-if="youtubemode">
                    <i class="icon-cross text-black float-right" @click="StopYoutube()"></i>
                    <YtClient></YtClient>
                </div>
                <div class="d-flex flex-column" v-for="(task, index) in tasks.data" v-if="tasks.data">
                    <div class="alert alert-primary alert-dismissible alert-styled-left border-top-0 border-bottom-0 border-right-0"
                         v-if="(task.owntask.view) && youtubemode != true">
                        <span class="font-weight-semibold">Watch this page</span> {{task.owntask.time}} second to
                        complete this task!
                        <button type="button" class="close" data-dismiss="alert">×</button>
                    </div>
                    <div class="alert alert-primary alert-dismissible alert-styled-left border-top-0 border-bottom-0 border-right-0"
                         v-if="(task.owntask.likemode)&& youtubemode != true">
                        <span class="font-weight-semibold">Make Like</span> to complete this task!
                        <button type="button" class="close" data-dismiss="alert">×</button>
                    </div>
                    <div class="alert alert-primary alert-dismissible alert-styled-left border-top-0 border-bottom-0 border-right-0"
                         v-if="(task.owntask.custom_comment)&& youtubemode != true">
                        <span class="font-weight-semibold">Make custom comment</span>
                        <input type="text" class="form-control" readonly="" :value="tasks.data[0].customcomment.text">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                    </div>
                    <div class="card" v-if="youtubemode != true">
                        <div class="card-img-actions mx-1 mt-1">
                            <img class="card-img img-fluid" :src="task.owntask.image_url" alt="">
                            <div class="card-img-actions-overlay card-img">
                                <a href="#"
                                   @click="OpenTask(task.owntask.url,task.owntask.task_type.name,task.owntask.social_type.name,task.owntask.time)"
                                   class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round"
                                   data-popup="lightbox" rel="group">
                                    <i class="icon-play"></i>
                                </a>

                                <a href="#"
                                   class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round ml-2">
                                    <i class="icon-link"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex-row" v-if="progress == false">
                                <div class="d-flex">
                                    <span class="font-weight-semibold">Status:&nbsp;</span>
                                    {{task.join_status.name}}
                                </div>
                                <div class="d-flex">
                                    <span class="font-weight-semibold">Description: &nbsp;</span>
                                    {{task.join_status.description}}
                                </div>
                                <div class="d-flex" v-if="(task.owntask.custom_comment)">
                                    <span class="font-weight-semibold">Comment text:&nbsp;</span>
                                    <input type="text" class="form-control" readonly="" :value="tasks.data[0].customcomment.text">
                                </div>

                            </div>
                            <div class="d-flex" v-if="closed == false">
                                <span class="font-weight-semibold" v-if="time <= max && time != 0">{{time}}&nbsp;<i
                                        class="icon-spinner2 spinner mr-2"></i></span>
                                <span class="font-weight-semibold" v-if="time >= max && time != 0"><i
                                        class="icon-checkmark2 text-green mr-2"></i>&nbsp;Success</span>
                            </div>
                            <b-progress ref="progressbar" :value="time" variant="dark" :max="task.owntask.time" striped
                                        :animated="animate"
                                        class="mt-2" v-if="progress == true"></b-progress>
                            <br/>
                            <div class="d-flex align-items-start flex-nowrap">
                                <div>
                                    <h6 class="font-weight-semibold mr-2">{{task.owntask.name}}</h6>
                                    <span>{{task.owntask.description| truncate(105)}}</span>
                                </div>

                                <div class="list-icons list-icons-extended ml-auto">
                                    <button class="btn btn-primary"
                                            @click="OpenTask(task.owntask.url,task.owntask.task_type.name,task.owntask.social_type.name,task.owntask.time)">
                                        <i class="icon-play icon-2x" v-if="!(progress)"></i>
                                        <span v-if="progress">{{time}}</span>
                                    </button>
                                </div>
                            </div>
                            <div class="d-flex float-left">
                                <div class="d-sm-flex" v-if="(task.owntask.view)" style="icon-playmargin:3px;">
                            <span class="badge bg-info">
                                <i class="icon-youtube mr-3 icon-2x"></i>View
                            </span>
                                </div>
                                <div class="d-sm-flex" v-if="(task.owntask.likemode)" style="margin:3px;">
                <span class="badge bg-warning">
                                <i class="icon-thumbs-up2 icon-2x"></i> Like
                            </span>
                                </div>
                                <div class="d-sm-flex" v-if="(task.owntask.custom)" style="margin:3px;">
                <span class="badge bg-warning">
                                <i class="icon-thumbs-up2"></i> Like
                            </span>
                                </div>
                                <div class="d-sm-flex" v-if="(task.owntask.custom_comment)" style="margin:3px;">
                <span class="badge bg-grey-400">
                                <i class="icon-comments icon-2x"></i>&nbsp;&nbsp;Custom comments
                            </span>
                                </div>
                                <div class="d-sm-flex" v-if="(task.owntask.subscribe)" style="margin:3px;">
                <span class="badge bg-info">
                                Subscribe
                            </span>
                                </div>
                                <div class="d-sm-flex" v-if="(task.owntask.repost)" style="margin:3px;">
                            <span class="badge bg-info">
                                Repost
                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /image grid -->
            <br/>
            <pagination :data="tasks" @pagination-change-page="fetchData">
                <span slot="prev-nav">← &nbsp; Prev</span>
                <span slot="next-nav">Next &nbsp; →</span>
            </pagination>
            <br/>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                task_id:'',
                loading: true,
                tasks: {},
                page: 1,
                openedWindow: {},
                youtubemode: false,
                interval: null,
                time: 0,
                animate: '',
                progress: false,
                max: 0,
                closed: true,
                user: [],
                isRunning: false,
                marked: false,
            }
        },
        mounted() {
            this.$root.$on('ytfinish', (mark,strz,blnc) => {
                try {
                    const regex = /(?:[?&]vi?=|\/embed\/|\/\d\d?\/|\/vi?\/|https?:\/\/(?:www\.)?youtu\.be\/)([^&\n?#]+)/g;
                    const m = regex.exec(this.tasks.data[0].owntask.url);
                    const str = String(String('ytbe' + this.tasks.data[0].owntask.time) +String(blnc)+ String(m[1] + 'fsdfsl34DFfe45huererjtwe'));
                    const bcrypt = require('bcryptjs');
                    const task_id = this.task_id;
                    bcrypt.compare(str, mark, function (err, result) {
                        if (result) {
                            const postarray = {
                                'mark': mark,
                                'video_id': m[1],
                                'balance': blnc,
                                'task_id': task_id,
                            };
                            axios.post('/api/complete', postarray)
                                .then((res) => {
                                    Vue.toasted.show(res.data.sms, {'type': res.data.type, 'duration': 5000});
                                })
                                .catch((err) => {
                                    console.log(err)
                                });
                            try{
                            this.fetchData(this.page);
                            }
                            catch{}
                        }
                    });
                } catch {
                }
            });
            this.$root.$on('user', (current_user) => {
                this.user = current_user;
            });
            //this.$root.$emit('ytfinish', false);
            this.DataMake();
            // this.$gtm.enable(true);
            // this.$gtm.trackView('MyScreenName', 'currentpath');
        },
        beforeDestroy() {
            //this.$root.$on('switchMode',this.filter.mode)
        },
        methods: {
            DataMake(){
                setTimeout(()=>{
                    this.fetchData(this.page);
                },1500);
            },
            CheckHash(taskid, task_typename, task_typeid, social_typename, username, social_typeid) {
                //console.log('this hash started');
                const bcrypt = require('bcryptjs');
                const hash = bcrypt.hashSync(this.task_id + task_typename + task_typeid + social_typename + username + social_typeid, 10);
                //console.log('this hash '+hash);
                const postarray = {
                    'mark': hash,
                    'task_id': this.task_id,
                    'task_type_id': task_typeid,
                    'social_type_id': social_typeid,
                };
                axios.post('/api/complete', postarray)
                    .then((res) => {
                        //console.log('post sended');
                        Vue.toasted.show(res.data.sms, {'type': res.data.type, 'duration': 5000});
                    })
                    .catch((err) => {
                     //   console.log('not sended');
                     //   console.log(err)
                    });
                console.log('Complete-send');
            },
            OpenTask(url, task_type, social_type, timemax) {
                //this.$root.$emit('ytfinish', false);
                this.max = timemax;
                this.time = 0;
                this.progress = true;
                this.closed = true;
                clearInterval(this.interval);
                if (url.includes('youtu') && task_type == 'Youtube' && social_type == 'Views') {
                    this.youtubemode = true;
                    this.$route.params.videoId = url;
                    this.$route.params.maxtime = timemax;
                    this.progress = false;
                } else {
                    this.youtubemode = false;
                    var width = 1120;
                    var height = 700;
                    var top = 100;
                    var left = ($(document).width() - width) / 2;
                    this.openedWindow = window.open(url, 'targetWindow', 'width=' + width + ',height=' + height + ',top=' + top + ',left=' + left + ',toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes');
                }
                this.toggleTimer();
                this.toggleTimer();
                // this.$gtm.trackEvent({
                //     event: null, // Event type [default = 'interaction'] (Optional)
                //     category: 'YtCompleteTask',
                //     action: 'VideoClick',
                //     label: 'Click on youtube video',
                //     value: 5000,
                //     noninteraction: false // Optional
                // });
                // Vue.prototype.$userId = document.querySelector("meta[name='user-id']").getAttribute('content');
                // Vue.$ga.set('userId', this.$userId);
                // this.$ga.event({
                //     eventCategory: 'YtCompleteTask',
                //     eventAction: 'VideoClick',
                //     eventValue: '1'
                // });


            },
            toggleTimer() {
                if (!this.isRunning) {
                    clearInterval(this.interval);
                } else {
                    this.interval = setInterval(this.incrementTime, 1000);
                }
                this.isRunning = !this.isRunning;
            },
            incrementTime() {
                this.time = parseInt(this.time) + 1;
                try {
                    if (this.openedWindow.closed) {
                        this.progress = false;
                        if (this.closed == true) {
                            if (this.max >= this.time) {
                                if (this.youtubemode == false) {
                                    Vue.toasted.show('Do not close window!', {'type': 'error', 'duration': 5000});
                                } else {
                                    Vue.toasted.show('Please watch video ' + this.max + ' sec', {
                                        'type': 'info',
                                        'duration': 5000
                                    });
                                    console.log('info 3');
                                }
                                console.log('info 2');
                                clearInterval(this.interval);
                                this.time = 0;
                                this.progress = false;
                                this.CheckHash(this.task_id,this.tasks.data[0].owntask.task_type.name,this.tasks.data[0].owntask.task_type.id,this.tasks.data[0].owntask.social_type.name,'j34fs7vxSdfVCXs2dxf',this.tasks.data[0].owntask.social_type.id);
                            } else {
                                clearInterval(this.interval);
                                console.log(this.user.name);
                                console.log('info sended 112');
                                console.log(this.task_id,this.tasks.data[0].owntask.task_type.name,this.tasks.data[0].owntask.task_type.id,this.tasks.data[0].owntask.social_type.name,'j34fs7vxSdfVCXs2dxf',this.tasks.data[0].owntask.social_type.id);
                                this.CheckHash(this.task_id,this.tasks.data[0].owntask.task_type.name,this.tasks.data[0].owntask.task_type.id,this.tasks.data[0].owntask.social_type.name,'j34fs7vxSdfVCXs2dxf',this.tasks.data[0].owntask.social_type.id);
                                this.time = 0;
                                this.progress = false;
                            }
                        }
                        this.closed = false;
                    }
                } catch {
                }
            },
            onCancel() {
                console.log('User cancelled the loader.')
            },
            StopYoutube() {
                this.youtubemode = false;
            },
            TaskCompleteClass(id) {
                return {
                    'active': id == 'User waiting approve',
                    'info': id == 'User complete assigned',
                    'success': id == 'Task is completed',
                    'warning': id == 'User auto assigned',
                    'danger': id == 'User was rejected',
                }
            },
            fetchData(page = 1) {
                // save page number
                this.youtubemode = false;
                this.task_id = this.$route.params.task_id;
                this.page = page;
                // request to backend
                axios.get('/api/task_complete?page=' + page+ '&task_id=' + this.task_id)
                    .then((res) => {
                        this.tasks = res.data;
                        this.loading = false;
                        //console.log(this.tasks.length);
                    })
                    .catch((err) => {
                        console.log(err);
                        this.loading = false;
                    })
            },
        },
        watch: {
            'this.$route.params.videoId': () => {
                if (this.$route.params.videoId.length > 20) {
                    this.youtubemode = false;
                    this.progress = false;
                }
            },
        },
        components: {
            'Pagination': require('laravel-vue-pagination'),
            'Sidebar': require('./Sidebar.vue'),
            'YtClient': require('./ytClient.vue').default,
            'BootstrapVue': require('bootstrap-vue'),
            'bcrypt': require('bcryptjs'),
            'Loading': require('vue-loading-overlay'),
        }
    }
</script>

<style>
    .done label {
        text-decoration: line-through;
    }

    .fade-enter-active, .fade-leave-active {
        transition: opacity .2s;
    }

    .fade-enter, .fade-leave-to /* .fade-leave-active до версии 2.1.8 */
    {
        opacity: 0;
    }
</style>
