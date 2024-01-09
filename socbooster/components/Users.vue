<template>
    <div>
        <p v-if="loading" class="notification is-info">
            Loading
        </p>
        <template v-else>
            <div class="panel panel-flat col-md-4" style="padding:6px; margin:6px;" v-for="(user, index) in users.data" :key="user.id">

                <div class="media">
                    <div class="media-left media-middle">
                        <a href="#" @click="getUser(user.id)">
                            <img :src="'/uploads/avatars/'+user.avatar" class="img-circle" alt="">
                        </a>
                    </div>

                    <div class="media-body">
                        <div class="media-heading text-semibold">{{user.name }}</div>
                        <span class="text-muted">id: {{user.id }}</span>
                    </div>

                    <div class="media-right media-middle">
                        <ul class="icons-list icons-list-extended text-nowrap">
                            <li><a href="#" data-popup="tooltip" title="Call" data-toggle="modal" data-target="#call"><i class="icon-phone2"></i></a></li>
                            <li><a href="#" data-popup="tooltip" title="Chat" data-toggle="modal" data-target="#chat"><i class="icon-comment"></i></a></li>
                            <li><a href="#" data-popup="tooltip" title="Video" data-toggle="modal" data-target="#video"><i class="icon-video-camera"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </template>
    </div>
</template>

<script>
    export default {

        mounted() {
            this.fetchData();
        },
        data() {
            return {
                joined_avatar: '/uploads/avatars/placeholder.jpg',
                users:{},
                id:'',
                loading: true,
            }
        },

        methods: {
            taskClassByStatus: function (id) {
                return {
                    'border-left-info': id == 'Waiting moderation',
                    'border-left-primary': id == 'Open',
                    'border-left-success': id == 'Completed',
                    'border-left-warning': id == 'Task rejected',
                }
            },
            getUser($id){
                this.$router.push({name: 'User', params: {'user_id': $id }});
            },
            StatusTaskClass: function (id) {
                return {
                    'label-info': id == 'Waiting moderation',
                    'label-primary': id == 'Open',
                    'label-success': id == 'Completed',
                    'label-danger': id == 'Task rejected',
                }
            },
            fetchData() {
                // request to backend
                axios.get('/api/users/')
                    .then((res) => {
                        this.users = res.data;
                        this.loading = false;
                        //console.log(this.tasks.length);
                    })
                    .catch((err) => {
                        console.log(err);
                        this.loading = false;
                    })
            }
        }
    }
</script>
<style>
    .panel-footer-condensed {
        max-height: 40px;
    }
</style>
