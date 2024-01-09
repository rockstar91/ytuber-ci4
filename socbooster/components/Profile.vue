<template>
    <!-- Content area -->
    <div>

        <router-view></router-view>

        <!-- Page header -->
        <div class="page-header page-header-light border-bottom-0">

            <!-- Top breadcrumb line -->
            <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                <div class="d-flex">
                    <div class="breadcrumb">
                        <a href="/" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Socbooster</a>
                        <span class="breadcrumb-item active">Profile</span>
                    </div>
                </div>
            </div>
            <!-- /breadcrumb line -->


            <!-- Page header content -->
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">User Pages</span> -
                        Profile</h4>
                </div>
            </div>

            <!-- Profile navigation -->
            <div class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="navbar">
                    <ul class="nav navbar-nav" style="min-width:330px">
                        <li class="nav-item">
                            <a href="#activity" class="navbar-nav-link active" data-toggle="tab">
                                <i class="icon-menu7 mr-2"></i>
                                Activity
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#socialpages" class="navbar-nav-link" data-toggle="tab">
                                <i class="icon-calendar3 mr-2"></i>
                                Social pages
                                <span class="badge badge-pill bg-success position-static ml-auto ml-lg-2">{{pages.social_pages.length}}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#settings" class="navbar-nav-link" data-toggle="tab">
                                <i class="icon-cog3 mr-2"></i>
                                Settings
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /profile navigation -->
            <!-- /page header content -->
        </div>
        <!-- /page header -->
        <div class="content">
            <!-- Inner container -->
            <div class="d-flex align-items-start flex-column flex-md-row">

                <!-- Left content -->
                <div class="tab-content w-100 overflow-auto order-2 order-md-1">
                    <div class="tab-pane fade active show" id="activity">
                        <!-- Timeline -->
                        <div class="timeline timeline-left">
                            <div class="timeline-container">

                                <!-- Activities -->
                                <div class="timeline-row" v-for="a in pages.activities.data">
                                    <div class="timeline-icon" v-if="a.history_point == 0">
                                        <h3 style="position: relative; top: 4px; left: 13px; color: black;">
                                            {{a.history_point}}</h3>
                                    </div>

                                    <div class="timeline-icon" v-else-if="a.history_point <= 0">
                                        <h3 style="position: relative; top: 4px; left: 8px; color: red;">
                                            {{a.history_point}}</h3>
                                    </div>
                                    <div class="timeline-icon" v-else>
                                        <h3 style="position: relative; top: 4px; left: 3px; color: green;">
                                            +{{a.history_point}}</h3>
                                    </div>

                                    <div class="card">
                                        <div class="card-header header-elements-sm-inline">

                                            <span v-if="a.history_type=='1'"><i
                                                    class="icon-home5 text-slate mr-3 icon-2x"></i></span>
                                            <span v-if="a.history_type=='6'"><i
                                                    class="icon-file-minus text-slate mr-3 icon-2x"></i></span>
                                            <span v-if="a.history_type=='2'"><i
                                                    class="icon-mail text-slate mr-3 icon-2x"></i></span>
                                            <span v-if="a.history_type=='3'"><i
                                                    class="icon-profile text-slate mr-3 icon-2x"></i></span>
                                            <span v-if="a.history_type=='4'"><i
                                                    class="icon-forward text-slate mr-3 icon-2x"></i></span>
                                            <span v-if="a.history_type=='7'"><i
                                                    class="icon-task text-slate mr-3 icon-2x"></i></span>
                                            <span v-if="a.history_type=='8'"><i
                                                    class="icon-task text-sucess mr-3 icon-2x"></i></span>

                                            <span class="badge bg-info badge-pill" v-if="a.history_point == 0"
                                                  style="text-transform: uppercase; padding: 14px 20px 4px 25px;max-width: 336px;">
                                                        <h6 class="panel-title">{{a.history_event| truncate(33)}}</h6>
                                                           </span>
                                            <span class="badge bg-danger badge-pill" v-else-if="a.history_point < 0"
                                                  style="text-transform: uppercase; padding: 14px 20px 4px 25px;max-width: 336px;">
                                                        <h6 class="panel-title">{{a.history_event| truncate(33)}}</h6>
                                                           </span>
                                            <span class="badge bg-success badge-pill" v-else
                                                  style="text-transform: uppercase; padding: 14px 20px 4px 25px;max-width: 336px;">
                                                        <h6 class="panel-title">{{a.history_event| truncate(33)}}</h6>
                                                           </span>
                                            <div class="header-elements">
                                                <span><i
                                                        class="icon-history mr-2 text-success"></i>  {{a.created_at}}</span>

                                                <div class="list-icons ml-3">
                                                    <a class="list-icons-item" data-action="reload"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card" style="margin-left: 68px;">
                                <div class="card-header header-elements-sm-inline" style="text-align: center">
                                    <h3 style="text-align: center;margin: 0 auto;">Total Points: {{pages.activities_count}}</h3>
                                </div>
                            </div>
                        </div>
                        <!-- /timeline -->
                        <!-- /Activities -->
                    </div>
                    <div class="tab-pane fade" id="socialpages">
                        <!-- Social Pages -->
                        <div class="card">
                            <div class="card-header header-elements-inline">
                                <h6 class="card-title">Social pages</h6>
                                <div class="header-elements">
                                    <div class="list-icons">
                                        <a class="list-icons-item" data-action="collapse"></a>
                                        <a class="list-icons-item" data-action="reload" @click="fetchData"></a>
                                        <a class="list-icons-item" data-action="remove"></a>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <!-- Social Pages content -->
                                <div class="table-responsive">
                                    <table class="table text-nowrap">
                                        <thead>
                                        <tr>
                                            <th>Page avatar</th>
                                            <th>URL</th>
                                            <th>Status</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="socpage in pages.social_pages">
                                            <td>

                                                <div>
                                                    <img :src="'/storage/'+socpage.img" class="rounded-circle"
                                                         style="max-width: 40px;"/>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="text-semibold">{{socpage.url}}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
												<span v-bind:class="PageClassByStatus(socpage.pagestatus.name)">
												<i class="icon-spinner2 spinner position-left"
                                                   v-if="socpage.pagestatus.name == 'Waiting moderation'">
												</i>
												{{socpage.pagestatus.name}}
												</span>
                                                    <br/>
                                                    <small>{{socpage.pagestatus.description}}</small>
                                                </div>
                                            <td/>
                                            <td>
                                                <div>
                                                    <button class="btn btn-danger btn-xs" @click="RemovePage(socpage)">
                                                        Remove
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /Social Pages content -->
                        </div>
                        <!-- /Social Pages -->
                        <!-- Social Pages form content -->
                        <div class="card">
                            <div class="card-header header-elements-inline">
                                <h6 class="card-title">Social pages</h6>
                                <div class="header-elements">
                                    <div class="list-icons">
                                        <a class="list-icons-item" data-action="collapse"></a>
                                        <a class="list-icons-item" data-action="reload" @click="fetchData"></a>
                                        <a class="list-icons-item" data-action="remove"></a>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-lg-10" v-for="socialtype in pages.task_types">
                                        <div class="text-left">
                                            <h6 class="no-margin text-semibold">Setup your {{socialtype.name}} page</h6>
                                        </div>
                                        <div class="form-group form-group-feedback form-group-feedback-left">
                                            <input v-model="socialtype.value" type="text" class="form-control input-xlg"
                                                   :placeholder="socialtype.url">
                                            <div class="form-control-feedback">
                                                <img class="rounded-circle" :src="'/storage/'+socialtype.image"
                                                     style="max-width: 25px;"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary" @click="AddPage">Add Page<i
                                        class="icon-arrow-right14 position-right"></i></button>
                            </div>
                            <!-- /Social Pages form content -->
                        </div>
                        <!-- /Social Pages form-->
                    </div>
                    <div class="tab-pane fade" id="settings">

                    </div>
                    <pagination :data="pages.activities" @pagination-change-page="fetchData">
                        <span slot="prev-nav">&lt; Previous</span>
                        <span slot="next-nav">Next &gt;</span>
                    </pagination>
                </div>
                <!-- /left content -->


                <!-- Right sidebar component -->
                <div class="sidebar sidebar-light bg-transparent sidebar-component sidebar-component-right wmin-300 border-0 shadow-0 order-1 order-md-2 sidebar-expand-md">

                    <!-- Sidebar content -->
                    <div class="sidebar-content">

                        <!-- User card -->
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="card-img-actions d-inline-block mb-3">
                                    <!--                                    <img :src="'/uploads/avatars/'+pages.user.avatar" class="img-fluid rounded-circle"/>-->
                                    <div class="rounded-circle main-avatar"
                                         :style="{'background-image': 'url(' + '/uploads/avatars/'+pages.user.avatar + ')'}"></div>
                                    <div class="card-img-actions-overlay card-img rounded-circle">
                                        <a href="#"
                                           class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round fileContainer">
                                            <i class="icon-plus3"></i>
                                            <input class="file-input" type="file" ref="file" name="file"
                                                   @change="UploadAvatar()">
                                        </a>
                                        <a href="#"
                                           class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round ml-2">
                                            <i class="icon-link"></i>
                                        </a>
                                    </div>
                                </div>

                                <h6 class="font-weight-semibold mb-0">{{pages.user.name}}</h6>
                                <span class="d-block text-muted">UX/UI designer</span>

                                <div class="list-icons list-icons-extended mt-3">
                                    <a href="#" class="list-icons-item" data-popup="tooltip" title="Google Drive"
                                       data-container="body"><i class="icon-google-drive"></i></a>
                                    <a href="#" class="list-icons-item" data-popup="tooltip" title="Twitter"
                                       data-container="body"><i class="icon-twitter"></i></a>
                                    <a href="#" class="list-icons-item" data-popup="tooltip" title="Github"
                                       data-container="body"><i class="icon-github"></i></a>
                                </div>
                            </div>
                        </div>
                        <!-- /user card -->


                        <!-- Navigation -->
                        <div class="card">
                            <div class="card-header bg-transparent header-elements-inline">
                                <span class="card-title font-weight-semibold">Navigation</span>
                                <div class="header-elements">
                                    <div class="list-icons">
                                        <a class="list-icons-item" data-action="collapse"></a>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-0">
                                <ul class="nav nav-sidebar my-2">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="icon-user"></i>
                                            My profile
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="icon-cash3"></i>
                                            Balance
                                            <span class="text-muted font-size-sm font-weight-normal ml-auto">$1,430</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="icon-tree7"></i>
                                            Connections
                                            <span class="badge bg-danger badge-pill ml-auto">29</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="icon-users"></i>
                                            Friends
                                        </a>
                                    </li>

                                    <li class="nav-item-divider"></li>

                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="icon-calendar3"></i>
                                            Events
                                            <span class="badge bg-teal-400 badge-pill ml-auto">48</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="icon-cog3"></i>
                                            Account settings
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- /navigation -->
                    </div>
                    <!-- /sidebar content -->

                </div>
                <!-- /right sidebar component -->

            </div>
            <!-- /inner container -->
        </div>
        <!-- /content area -->
    </div>
    <!-- /content area -->
</template>

<script>
    export default {
        data() {
            return {
                loading: true,
                pages: {},
                file: {},
            }
        },
        mounted() {
            this.fetchData();
        },
        methods: {
            UploadAvatar() {
                this.file = this.$refs.file.files[0];
                let formData = new FormData();
                formData.append('file', this.file);
                axios.post('avatar', formData, {headers: {'Content-Type': 'multipart/form-data'}})
                    .then(res => {
                        if (res.data.type == 'info') {
                            this.$toasted.show(res.data.sms);
                            this.fetchData()
                        }
                        if (res.data.type == 'success') {
                            this.fetchData();
                            this.$toasted.show(res.data.sms);
                        }
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors;
                    });
            },
            AddPage() {
                axios.post('/api/add_pages', this.pages.task_types)
                    .then((res) => {
                        if (res.data.type == 'info') {
                            this.$toasted.show(res.data.sms);
                            this.fetchData()
                        }
                        if (res.data.type == 'error') {
                            this.$toasted.show(res.data.sms);
                            this.fetchData()
                        }
                        if (res.data.type == 'success') {
                            this.$toasted.show(res.data.sms);
                            this.fetchData()
                        }
                    })
                    .catch((err) => {
                        console.log(err)
                    })
                //console.log(this.pages.task_types);
            },
            RemovePage(pid) {
                axios.post('/remove_pages', pid)
                    .then((res) => {
                        if (res.data.type == 'info') {
                            this.$toasted.show(res.data.sms);
                            this.fetchData()
                        }
                        if (res.data.type == 'error') {
                            this.$toasted.show(res.data.sms);
                            this.fetchData()
                        }
                        if (res.data.type == 'success') {
                            this.$toasted.show(res.data.sms);
                            this.fetchData()
                        }
                    })
                    .catch((err) => {
                        console.log(err)
                    })
            },
            PageClassByStatus: function (id) {
                return {
                    'badge badge-info': id == 'Waiting moderation',
                    'badge badge-warning': id == 'Rejected',
                    'badge badge-success': id == 'Accepted',
                }
            },
            fetchData(page = 1) {
                axios.get('/api/profile?page=' + page)
                    .then((res) => {
                        //console.log(res);
                        this.pages = res.data;
                        this.loading = false;
                    })
                    .catch((err) => {
                        console.log(err);
                        this.loading = false;
                    })
            },
        },
        components: {
            'Pagination': require('laravel-vue-pagination'),
        }
    }
</script>
<style>
    a.fileContainer {
        overflow: hidden;
        position: relative;
        cursor: pointer;
        display: inline-block;
        color: lightskyblue;
    }

    a.fileContainer:hover {
        text-decoration: underline;
        color: blue;
    }

    a.fileContainer > input[type=file] {
        cursor: inherit;
        filter: alpha(opacity=0);
        opacity: 0;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        text-align: right;
    }

    .main-avatar {
        background-size: cover;
        width: 100px;
        height: 100px;
    }
    .page-link{
    list-style: none;
    }
    .timeline:after{
        bottom: 0;
        left: -2px!important;
    }
</style>
