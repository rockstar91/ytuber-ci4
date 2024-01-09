<template>
    <div class="card border-left-3 rounded-left-0" v-bind:class="taskClassByStatus(task.status.name)">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8 task-join">
                    <img :src="task.image_url" style="max-height: 60px;margin-bottom: 10px;"
                         v-if="task.image_url.includes('ytimg')"/>
                    <img class="rounded-circle" :src="'/storage/'+task.image_url"
                         style="max-height: 38px;margin-bottom: 10px;" v-if="task.image_url.includes('placeholder')"/>
                    <h6 class="no-margin-top">
                        <a :href="'/task/'+ task.id">
                            {{ task.name|truncate(70) }}</a>

                    </h6>
                    <p class="mb-15">{{task.description| truncate(105)}}</p>
                    <a href="#" v-if="task.joined.length < 1">
                        <img :src="joined_avatar" class="rounded-circle" alt="" style="max-height: 40px;"/></a>

                    <a @click="getUser(join.user_join.id)" href="#" v-else="task.joined.length > 0"
                       v-for="join in task.joined"
                       :key="task.joined.id">

                        <div class="rounded-circle joined-avatar"
                             :style="{'background-image': 'url(' + '/uploads/avatars/'+join.user_join.avatar + ')'}"></div>

                    </a>

                    <a href="#"
                       class="btn btn-icon bg-transparent border-slate-300 text-slate rounded-round border-dashed"
                       @click.prevent="joinTask(task.id,task.task_type_id,task.user_id,task,task.social_type_id,task.autojoin)"><i
                            class="icon-plus2"></i></a>


                </div>
                <ul class="list list-unstyled mb-0 mt-3 mt-sm-0 ml-auto" style="list-style: none">
                    <li class="media"><a href="#" @click.prevent="GoToUserPage(task.user.id)" class="media-left">
                        <div class="rounded-circle joined-avatar"
                             :style="{'background-image': 'url(' + '/uploads/avatars/'+task.user.avatar + ')'}"></div>
                    </a>
                    </li>
                    <li>
                        {{task.user.name}}
                    </li>
                    <li>
                        <h1 class="text-success">{{task.price}}&nbsp;<i class="icon-coins mr-3 icon-2x rounded text-success icon-right"></i></h1>

                    </li>
                    <li>
                        <h3 class="text-warning"><i class="icon-alarm mr-3 rounded text-warning">&nbsp;{{task.time}} sec</i></h3>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card-footer d-sm-flex justify-content-sm-between align-items-sm-center">
            <div class="d-sm-flex" style="margin-right: 20px;">
		        <h6 class="float-left">
                     <div class="rounded-circle joined-avatar"
                          :style="{'background-image': 'url(' + '/storage/'+task.task_type.image + ')'}">
                     </div>
                    <span style="position: relative;top: 6px;" class="font-weight-semibold">{{task.task_type.name}} - {{task.social_type.name}}</span>
                </h6>
            </div>
            <div class="d-flex float-left">
            <div class="d-sm-flex" v-if="(task.view)" style="margin:3px;">
                            <span class="badge bg-info">
                                <i class="icon-youtube mr-3"></i>View
                            </span>
            </div>
            <div class="d-sm-flex" v-if="(task.autojoin)" style="margin:3px;">
                <span class="badge bg-success">
                                <i class="icon-touch mr-3"></i>AutoJoin
                            </span>
            </div>
            <div class="d-sm-flex" v-if="(task.multitask)" style="margin:3px;">
                <span class="badge bg-purple">
                               <i class="icon-collaboration mr-3"></i> MultiTask
                            </span>
            </div>
            <div class="d-sm-flex" v-if="(task.likemode)" style="margin:3px;">
                <span class="badge bg-warning">
                                <i class="icon-thumbs-up2"></i> Like
                            </span>
            </div>
                <div class="d-sm-flex" v-if="(task.dislike)" style="margin:3px;">
                <span class="badge bg-warning">
                                <i class="icon-thumbs-down2"></i> DisLike
                            </span>
                </div>
            <div class="d-sm-flex" v-if="(task.custom)" style="margin:3px;">
                <span class="badge bg-warning">
                                <i class="icon-thumbs-up2"></i> Like
                            </span>
            </div>
            <div class="d-sm-flex" v-if="(task.subscribe)" style="margin:3px;">
                <span class="badge bg-info">
                                Subscribe
                            </span>
            </div>
            <div class="d-sm-flex" v-if="(task.repost)" style="margin:3px;">
                            <span class="badge bg-info">
                                Repost
                            </span>
            </div>
                <div class="d-sm-flex" v-if="(task.custom_comment)" style="margin:3px;">
                            <span class="badge bg-grey-400">
                               <i class="icon-comments"></i>  Custom comment
                            </span>
            </div>
            </div>
                <span class="float-right" v-bind:class="StatusTaskClass(task.status.name)" style="margin-top:6px">

                         <i class="icon-spinner2 spinner position-left"
                            v-if="task.status.name == 'Waiting moderation' || task.status.name == 'Open' ">
												</i>
						{{task.status.name}}
						</span>
            </div>
        </div>
</template>

<script>
    export default {

        mounted() {
            //console.debug('task #'+this.task.id+' loaded');
        },

        props: {
            task: {
                type: Object,
                default: () => {
                }
            }
        },

        data() {
            return {
                joined_avatar: '/uploads/avatars/placeholder.jpg'
            }
        },

        methods: {
            GoToUserPage(user) {
                this.$router.push({name: 'User', params: {'user_id': user}});
            },
            RouteTask(id) {
                this.$router.push({name: 'Task', params: {'id': id}});
            },
            taskClassByStatus: function (id) {
                return {
                    'border-left-danger-400': id == 'Waiting moderation',
                    'border-left-primary-400': id == 'Open',
                    'border-left-success-400': id == 'Completed',
                    'border-left-warning-400': id == 'Task rejected',
                }
            },
            StatusTaskClass: function (id) {
                return {
                    'badge bg-grey-600': id == 'Waiting moderation',
                    'badge bg-teal-400': id == 'Open',
                    'badge bg-success': id == 'Completed',
                    'badge bg-danger': id == 'Task rejected',
                }
            },
            getUser($id) {
                this.$router.push({name: 'User', params: {'user_id': $id}});
            },
            joinTask: function (task_id, task_type_id, user_id, task, social_type_id,autojoin) {

                // this.$emit('task-event', task_id);
                //
                // //this.task.name = 'new name';

                var request = {
                    'task_id': task_id,
                    'user_id': user_id,
                    'task_type_id': task_type_id,
                    'social_type_id': social_type_id,
                    'autojoin': autojoin
                }

                axios.post('/api/join-task', request, task)
                    .then((res) => {
                        if (res.data.type == 'info') {
                            this.$toasted.show(res.data.sms, {
                                icon: 'icon-info3', duration: 6500,
                                action: {
                                    text: 'Profile',
                                    onClick: (e, toastObject) => {
                                        this.$router.push({path: 'profile'})
                                        toastObject.goAway(0);
                                    }
                                },
                            });
                        }
                        if (res.data.type == 'error') {
                            this.$toasted.show(res.data.sms);
                        }
                        if (res.data.type == 'success') {
                            this.$toasted.show(res.data.sms);
                            this.$parent.fetchData(this.page)
                            if (task.joined.length === 0) {
                                console.log(task);
                            }
                        }
                    })
                    .catch((err) => {
                        console.log(err)
                    })
            }
        }
    }
</script>
<style>
    .panel-footer-condensed {
        max-height: 40px;
    }

    .joined-avatar {
        background-size: cover;
        border-radius: 50% 50% 50% 50%;
        width: 100px;
        height: 100px;
        max-height: 38px;
        max-width: 38px;
        float: left;
        margin-right: 4px;
    }
</style>
