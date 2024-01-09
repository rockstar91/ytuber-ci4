<template>
    <!-- Secondary sidebar -->
    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- Sidebar search -->
        <div class="card">
            <div class="card-header bg-transparent header-elements-inline">
                <span class="text-uppercase font-size-sm font-weight-semibold">Task search</span>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="sidebar-mobile-secondary-toggle"><i class="icon-transmission"></i></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="#">
                    <div class="form-group-feedback form-group-feedback-right">
                        <input type="search" class="form-control" placeholder="Search" v-model="keywords">
                        <div class="form-control-feedback">
                            <i class="icon-search4 font-size-base text-muted"></i>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /sidebar search -->


        <!-- Block buttons -->
        <div class="card">
            <div class="card-header bg-transparent header-elements-inline">
                <span class="text-uppercase font-size-sm font-weight-semibold">Block buttons</span>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <router-link to="/" type="button" class="btn bg-purple-300 btn-block btn-float" style="min-height: 90px; margin-top: 5px;">
                            <i class="icon-home icon-2x"></i>
                            <span>Home</span>
                        </router-link>

                        <a href="/mytasks" type="button" class="btn bg-teal-400 btn-block btn-float" style="min-height: 90px; margin-top: 5px;">
                            <i class="icon-git-branch icon-2x"></i>
                            <span>My tasks</span>
                        </a>

                    </div>

                    <div class="col">
                        <router-link to="/profile" type="button" class="btn bg-warning-400 btn-block btn-float" style="min-height: 90px; margin-top: 5px;">
                            <i class="icon-stats-bars icon-2x"></i>
                            <span>Profile</span>
                        </router-link>

                        <a href="/tasks" type="button" class="btn bg-blue btn-block btn-float" style="min-height: 90px; margin-top: 5px;">
                            <i class="icon-people icon-2x"></i>
                            <span>All tasks</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /block buttons -->


        <!-- Sub navigation -->
        <div class="card mb-2">
            <div class="card-header bg-transparent header-elements-inline">
                <span class="text-uppercase font-size-sm font-weight-semibold">Navigation</span>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <ul class="nav nav-sidebar" data-nav-type="accordion">
                    <li class="nav-item-header">Menu</li>
                    <li class="nav-item">
                        <router-link to="/complete-tasks" class="nav-link"><i class="icon-compose"></i> Complete tasks
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <a @click="ShowAllTasks" href="#" class="nav-link"><i class="icon-portfolio"></i> All tasks
                        </a>
                    </li>
                    <li class="nav-item">
                        <router-link to="/create-task" class="nav-link"><i class="icon-googleplus5"></i> Create task
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <a href="#" @click="ShowMyTasks" class="nav-link">
                            <i class="icon-collaboration"></i> My tasks
                        </a>
                    </li>
                    <li class="nav-item">
                        <router-link to="/profile" class="nav-link"><i class="icon-cog3"></i> Profile</router-link>
                    </li>
                    <li class="nav-item-header">Work statistics</li>
                    <li class="nav-item">
                        <a href="waitringapprove" class="nav-link">
                            <i class="icon-file-plus"></i>
                            Waiting approve
                            <span class="badge bg-dark badge-pill ml-auto">{{statistics['status1']}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="icon-reading"></i>
                            Awaiting Completion
                            <span class="badge bg-primary badge-pill ml-auto">{{statistics['status2']}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="autoassigned" class="nav-link">
                            <i class="icon-reading"></i>
                            Auto assigned
                            <span class="badge bg-primary badge-pill ml-auto">{{statistics['status3']}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="completed" class="nav-link">
                            <i class="icon-checkmark3"></i>
                            Completed
                            <span class="badge bg-success badge-pill ml-auto">{{statistics['status4']}}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="icon-cross2"></i>
                            Rejected
                            <span class="badge bg-warning badge-pill ml-auto">{{statistics['status5']}}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="icon-database-time2"></i>
                            Checking
                            <span class="badge bg-info badge-pill ml-auto">{{statistics['status6']}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="icon-cross2"></i>
                            Not completed yet
                            <span class="badge bg-info badge-pill ml-auto">{{statistics['status7']}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="icon-cross2"></i>
                            Rejected by moderator
                            <span class="badge bg-danger badge-pill ml-auto">{{statistics['status8']}}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /sub navigation -->

    </div>
    <!-- /sidebar content -->

    <!-- /secondary sidebar -->

</template>
<script>
    export default {
        data() {
            return {
                statistics: [],
                keywords:null,
            }
        },
        mounted() {
            this.GetStatistics();
        },
        methods: {
            GetStatistics() {
                axios.get('/api/statistics')
                    .then((res) => {
                        this.statistics = res.data;
                    })
                    .catch((err) => {
                        console.log(err);
                    })
            },
            ShowMyTasks(){
                this.$router.push('MyTasks');
            },
            ShowAllTasks(){
                this.$router.push('Tasks');
            },
            RouteToProfile() {
                this.$router.push({name: 'Profile'});
            },
            RouteToUsers() {
                this.$router.push('Users');
            },
            TaskSendKey(){
                this.$root.$emit('tasksearch', this.keyword);
            }
        },
        watch: {
            keywords: function () {
             console.log('key change');
             this.$root.$emit('tasksearch', this.keywords);
            }
        }
    }
</script>