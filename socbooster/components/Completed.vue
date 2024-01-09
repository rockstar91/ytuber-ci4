<template>
    <div>
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Task Manager</span> - List</h4>
                    <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                </div>

                <div class="header-elements d-none">
                    <div class="d-flex justify-content-center">
                        <a href="#" class="btn btn-link btn-float text-default"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>
                        <a href="#" class="btn btn-link btn-float text-default"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>
                        <a href="#" class="btn btn-link btn-float text-default"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a>
                    </div>
                </div>
            </div>

            <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                <div class="d-flex">
                    <div class="breadcrumb">
                        <a href="index.html" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                        <a href="task_manager_list.html" class="breadcrumb-item">Task manager</a>
                        <span class="breadcrumb-item active">List</span>
                    </div>

                    <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                </div>

                <div class="header-elements d-none">
                    <div class="breadcrumb justify-content-center">
                        <a href="#" class="breadcrumb-elements-item">
                            <i class="icon-comment-discussion mr-2"></i>
                            Support
                        </a>

                        <div class="breadcrumb-elements-item dropdown p-0">
                            <a href="#" class="breadcrumb-elements-item dropdown-toggle" data-toggle="dropdown">
                                <i class="icon-gear mr-2"></i>
                                Settings
                            </a>

                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="#" class="dropdown-item"><i class="icon-user-lock"></i> Account security</a>
                                <a href="#" class="dropdown-item"><i class="icon-statistics"></i> Analytics</a>
                                <a href="#" class="dropdown-item"><i class="icon-accessibility"></i> Accessibility</a>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item"><i class="icon-gear"></i> All settings</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div  class="card">
                <div class="card-header bg-transparent header-elements-inline">
                    <h6 class="card-title">Task manager</h6>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                            <a class="list-icons-item" data-action="reload"></a>
                            <a class="list-icons-item" data-action="remove"></a>
                        </div>
                    </div>
                </div>

                <table class="table tasks-list table-lg">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th></th>
                        <th>Task Description</th>
                        <th>Join status</th>
                        <th>Status description</th>
                        <th>Work status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(task, index) in tasks.data">
                        <td>#{{task.owntask.id}}</td>
                        <td>
                            <div class="rounded-circle">
                                <a v-if="task.join_status.name !='Waiting approve'" :href="'/complete/'+task.owntask.id"><img class="avatar" :src="task.owntask.image_url" alt="" style="max-width: 120px;"></a>
                                <a v-if="task.join_status.name =='Waiting approve'" href="#" @click="ErrStatus"><img class="avatar" :src="task.owntask.image_url" alt="" style="max-width: 120px;"></a>
                            </div>
                        </td>
                        <td>
                            <div class="font-weight-semibold"><a :href="'/task/'+task.owntask.id">{{task.owntask.name}}</a></div>
                            <div class="text-muted">{{task.owntask.description}}</div>
                        </td>
                        <td>
                            <div class="btn-group">
                                <span v-bind:class="StatusTaskClass(task.join_status.name)" data-toggle="dropdown">{{task.join_status.name}}</span>
                            </div>
                        </td>
                        <td>
                            <div class="d-inline-flex align-items-center">
                                <span class="" data-toggle="dropdown">{{task.join_status.description}}</span>
                            </div>
                        </td>
                        <td>
                            <div class="font-weight-semibold">Earned {{task.owntask.price}} <i class="icon-coins"></i></div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
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
                tasks:{},
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
            ErrStatus(){
                Vue.toasted.show('Pls wait until you will approve for this task', {'type': 'info', 'duration': 5000});
            },
            getUser($id){
                this.$router.push({name: 'User', params: {'user_id': $id }});
            },
            StatusTaskClass: function (id) {
                return {
                    'badge bg-info': id == 'Waiting moderation',
                    'badge bg-primary': id == 'Open',
                    'badge bg-success': id == 'Completed',
                    'badge bg-danger': id == 'Task rejected',
                }
            },
            fetchData() {
                // request to backend
                axios.get('/api/completed/')
                    .then((res) => {
                        this.tasks = res.data;
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
