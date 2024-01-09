<template>
    <!-- Page content -->
    <div>
        <!-- Page header -->
        <div class="page-header page-header-light border-bottom-0">

            <!-- Top breadcrumb line -->
            <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                <div class="d-flex">
                    <div class="breadcrumb">
                        <a href="/" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Socbooster</a>
                        <span class="breadcrumb-item active">Tasks</span>
                    </div>
                </div>
            </div>
            <!-- /breadcrumb line -->


            <!-- Page header content -->
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Tasks</span> -
                        All tasks</h4>
                </div>
            </div>
            <!-- /page header content -->
        </div>
        <!-- /page header -->
        <TaskListFilter></TaskListFilter>
        <!-- Content area -->
        <div class="content">
            <loading :active.sync="isLoading"
                     :can-cancel="false"
                     :on-cancel="onCancel"
                     :is-full-page="true" loader="dots" color="green"></loading>
            <!-- Inner container -->
            <div class="d-flex align-items-start flex-column flex-md-row">

                <!-- Left content -->
                <div class="w-100 overflow-auto">


                    <p v-if="this.tasks.total <= 0">No tasks found</p>
                    <div class="row" v-if="this.filter.mode">
                            <div class="col-xl-6" v-for="(task, index) in tasks.data" :key="task.id">
                                <task ref="Task" v-bind:task="task" @task-event="taskEvent"></task>
                            </div>
                    </div>
                    <div class="row" v-else>
                        <div class="col-md-12" v-for="(task, index) in tasks.data" :key="task.id">
                            <task ref="Task" v-bind:task="task" @task-event="taskEvent"></task>
                        </div>
                    </div>
                </div>
                <!-- /left content -->


<!--                &lt;!&ndash; Right sidebar component &ndash;&gt;-->
<!--                <div class="sidebar sidebar-light bg-transparent sidebar-component sidebar-component-right border-0 shadow-0 order-1 order-md-2 sidebar-expand-md">-->

<!--                    &lt;!&ndash; Sidebar content &ndash;&gt;-->
<!--                    <div class="sidebar-content">-->

<!--                        &lt;!&ndash; Search &ndash;&gt;-->
<!--                        <div class="card">-->
<!--                            <div class="card-header bg-transparent header-elements-inline">-->
<!--                                <span class="card-title font-weight-semibold">Search task</span>-->
<!--                                <div class="header-elements">-->
<!--                                    <div class="list-icons">-->
<!--                                        <a class="list-icons-item" data-action="collapse"></a>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->

<!--                            <div class="card-body">-->
<!--                                <form action="#">-->
<!--                                    <div class="form-group-feedback form-group-feedback-right">-->
<!--                                        <input type="search" class="form-control" placeholder="type and hit Enter">-->
<!--                                        <div class="form-control-feedback">-->
<!--                                            <i class="icon-search4 font-size-base text-muted"></i>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </form>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        &lt;!&ndash; /search &ndash;&gt;-->


<!--                        &lt;!&ndash; Actions  &ndash;&gt;-->
<!--                        <div class="card">-->
<!--                            <div class="card-header bg-transparent header-elements-inline">-->
<!--                                <span class="card-title font-weight-semibold">Actions</span>-->
<!--                                <div class="header-elements">-->
<!--                                    <div class="list-icons">-->
<!--                                        <a class="list-icons-item" data-action="collapse"></a>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->

<!--                            <div class="card-body">-->
<!--                                <div class="row row-tile no-gutters">-->
<!--                                    <div class="col-6">-->
<!--                                        <button type="button" class="btn btn-light btn-block btn-float m-0">-->
<!--                                            <i class="icon-github4 icon-2x"></i>-->
<!--                                            <span>Github</span>-->
<!--                                        </button>-->

<!--                                        <button type="button" class="btn btn-light btn-block btn-float m-0">-->
<!--                                            <i class="icon-dropbox text-blue-400 icon-2x"></i>-->
<!--                                            <span>Dropbox</span>-->
<!--                                        </button>-->
<!--                                    </div>-->

<!--                                    <div class="col-6">-->
<!--                                        <button type="button" class="btn btn-light btn-block btn-float m-0">-->
<!--                                            <i class="icon-dribbble3 text-pink-400 icon-2x"></i>-->
<!--                                            <span>Dribbble</span>-->
<!--                                        </button>-->

<!--                                        <button type="button" class="btn btn-light btn-block btn-float m-0">-->
<!--                                            <i class="icon-google-drive text-success-400 icon-2x"></i>-->
<!--                                            <span>Google Drive</span>-->
<!--                                        </button>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        &lt;!&ndash; /actions &ndash;&gt;-->


<!--                        &lt;!&ndash; Navigation &ndash;&gt;-->
<!--                        <div class="card">-->
<!--                            <div class="card-header bg-transparent header-elements-inline">-->
<!--                                <span class="card-title font-weight-semibold">Navigation</span>-->
<!--                                <div class="header-elements">-->
<!--                                    <div class="list-icons">-->
<!--                                        <a class="list-icons-item" data-action="collapse"></a>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->

<!--                            <div class="card-body p-0">-->
<!--                                <div class="nav nav-sidebar mb-2">-->
<!--                                    <li class="nav-item-header">Actions</li>-->
<!--                                    <li class="nav-item">-->
<!--                                        <a href="#" class="nav-link">-->
<!--                                            <i class="icon-googleplus5"></i>-->
<!--                                            Create task-->
<!--                                        </a>-->
<!--                                    </li>-->
<!--                                    <li class="nav-item">-->
<!--                                        <a href="#" class="nav-link">-->
<!--                                            <i class="icon-portfolio"></i>-->
<!--                                            Create project-->
<!--                                        </a>-->
<!--                                    </li>-->
<!--                                    <li class="nav-item">-->
<!--                                        <a href="#" class="nav-link">-->
<!--                                            <i class="icon-compose"></i>-->
<!--                                            Edit task list-->
<!--                                        </a>-->
<!--                                    </li>-->
<!--                                    <li class="nav-item">-->
<!--                                        <a href="#" class="nav-link">-->
<!--                                            <i class="icon-user-plus"></i>-->
<!--                                            Assign users-->
<!--                                            <span class="badge bg-success ml-auto">94 online</span>-->
<!--                                        </a>-->
<!--                                    </li>-->
<!--                                    <li class="nav-item">-->
<!--                                        <a href="#" class="nav-link">-->
<!--                                            <i class="icon-collaboration"></i>-->
<!--                                            Create team-->
<!--                                        </a>-->
<!--                                    </li>-->
<!--                                    <li class="nav-item-header">Tasks</li>-->
<!--                                    <li class="nav-item">-->
<!--                                        <a href="#" class="nav-link">-->
<!--                                            <i class="icon-files-empty"></i>-->
<!--                                            All tasks-->
<!--                                        </a>-->
<!--                                    </li>-->
<!--                                    <li class="nav-item">-->
<!--                                        <a href="#" class="nav-link">-->
<!--                                            <i class="icon-file-plus"></i>-->
<!--                                            Active tasks-->
<!--                                        </a>-->
<!--                                    </li>-->
<!--                                    <li class="nav-item">-->
<!--                                        <a href="#" class="nav-link">-->
<!--                                            <i class="icon-file-check"></i>-->
<!--                                            Closed tasks-->
<!--                                        </a>-->
<!--                                    </li>-->
<!--                                    <li class="nav-item-divider"></li>-->
<!--                                    <li class="nav-item">-->
<!--                                        <a href="#" class="nav-link">-->
<!--                                            <i class="icon-reading"></i>-->
<!--                                            Assigned to me-->
<!--                                            <span class="badge bg-info badge-pill ml-auto">86</span>-->
<!--                                        </a>-->
<!--                                    </li>-->
<!--                                    <li class="nav-item">-->
<!--                                        <a href="#" class="nav-link">-->
<!--                                            <i class="icon-make-group"></i>-->
<!--                                            Assigned to my team-->
<!--                                            <span class="badge bg-info badge-pill ml-auto">47</span>-->
<!--                                        </a>-->
<!--                                    </li>-->
<!--                                    <li class="nav-item">-->
<!--                                        <a href="#" class="nav-link">-->
<!--                                            <i class="icon-cog3"></i>-->
<!--                                            Settings-->
<!--                                        </a>-->
<!--                                    </li>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        &lt;!&ndash; /navigation &ndash;&gt;-->

<!--                    </div>-->
<!--                    &lt;!&ndash; /sidebar content &ndash;&gt;-->

<!--                </div>-->
<!--                &lt;!&ndash; /right sidebar component &ndash;&gt;-->

            </div>
            <!-- /inner container -->
            <br />
            <pagination :data="tasks" @pagination-change-page="fetchData">
                <span slot="prev-nav">← &nbsp; Prev</span>
                <span slot="next-nav">Next &nbsp; →</span>
            </pagination>
        </div>
        <!-- /content area -->

    </div>
    <!-- /Page content -->
</template>

<script>
    export default {
        data() {
            return {
                isLoading: true,
                filter: {
                    mode: true,
                    order: 'DESC',
                    tasktype: 'all',
                    socialtype: 'all',
                    status: 'all',
                    mine: 'false',
                },
                tasks: {},
                page: 1,
                token: '',
                keyword:null,
            }
        },
        mounted() {
            this.fetchData();

            this.$root.$on('viewmode', (EventGrid) => {
                this.filter.mode = EventGrid;
            });
            this.$root.$on('tasksearch', (keyword) => {
                this.keyword = keyword;
                this.fetchData();
                //console.log(EventSoc);
            })
            this.$root.$on('tasktype', (EventSoc) => {
                this.filter.tasktype = EventSoc;
                this.fetchData();
                //console.log(EventSoc);
            })
            this.$root.$on('statustype', (status) => {
                this.filter.status = status;
                this.fetchData();
                //console.log(EventSoc);
            })
            this.$root.$on('soctype', (ev) => {
                this.filter.socialtype = ev;
                this.fetchData();
                console.log(ev);
            })
            this.$root.$on('minestatus', (status2) => {
                this.filter.mine = status2;
                this.fetchData();

            })
        },
        beforeDestroy() {
            //this.$root.$on('switchMode',this.filter.mode)
        },
        methods: {
            taskEvent(data) {
                console.log(data)
            },
            fetchData(page = 1) {
                this.isLoading = true;
                if(this.$route.name == 'MyTasks'){
                    this.filter.mine = true;
                }
                if(this.$route.name == 'Tasks'){
                    this.filter.mine = false;
                }
                this.page = page;
                // request to backend
                axios.get('/api/tasks?page=' + page + '&tasktype=' + this.filter.tasktype + '&socialtype=' + this.filter.socialtype + '&status=' + this.filter.status + '&mine=' + this.filter.mine+'&keyword='+this.keyword)
                    .then((res) => {
                        this.tasks = res.data;
                        this.isLoading = false;
                        //console.log(this.tasks.length);
                    })
                    .catch((err) => {
                        console.log(err);
                        this.isLoading = false;
                    })
            },
            onCancel() {
                console.log('User cancelled the loader.')
            },
        },
        components: {
            'Task': require('./Task.vue').default,
            'TaskListFilter': require('./TaskListFilter.vue').default,
            'Pagination': require('laravel-vue-pagination'),
            'Sidebar': require('./Sidebar.vue'),
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
