<template>
    <!-- Main content -->
    <div class="content-wrapper">
        <!-- Page header -->
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Task Manager</span> - Detailed</h4>
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
                        <a href="task_manager_detailed.html" class="breadcrumb-item">Task manager</a>
                        <span class="breadcrumb-item active">Detailed</span>
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
        <!-- /page header -->


        <!-- Content area -->
        <div class="content">
            <loading :active.sync="loading"
                     :can-cancel="false"
                     :on-cancel="onCancel"
                     :is-full-page="true" loader="dots" color="green"></loading>
            <!-- Inner container -->
            <div class="d-flex align-items-start flex-column flex-md-row" v-if="loading == false">

                <!-- Left content -->
                <div class="w-100 overflow-auto order-2 order-md-1">

                    <!-- Task overview -->
                    <div class="card" v-if="task">
                        <div class="card-header header-elements-md-inline">
                            <h5 class="card-title">{{task[0].name}}</h5>
                            <div class="header-elements">
                                <a href="#" class="btn bg-teal-400 btn-sm btn-labeled btn-labeled-right">{{task[0].status.name}} <b><i class="icon-alarm-check"></i></b></a>
                            </div>
                        </div>

                        <div class="card-body">
                            <router-view></router-view>
                                <div class="col-4-auto" v-if="task &&TaskComplete">
                                    <div class="card social-card" v-if="(this.UserSwitcher)">
                                        <div class="card-img-actions m-1" style="max-width: 320px;margin: 0 auto!important;margin-top: 10px!important;margin-bottom: 20px!important;">
                                            <img :src="task[0].image_url"
                                                 style="text-align: center;margin: 0 auto;width: 100%;"/>
                                            <div class="card-img-actions-overlay card-img">
                                                <a @click="LoadVideo(task[0].url)" href="#" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round" data-popup="lightbox" rel="group">
                                                    <i class="icon-youtube"></i>
                                                </a>

                                                <a href="#"  @click="CreateTask(task[0].url,task[0].name,task[0].image,task[0].description)" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round ml-2">
                                                    <i class="icon-link"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="caption text-center">
                                            <h6 class="text-semibold no-margin">
                                                <small class="display-block" v-if="task[0].description!='0'">
                                                    {{task[0].description| truncate(105) }}</small>
                                                <small class="display-block" v-if="task[0].dataregpage!=0">
                                                    {{task[0].dataregpage}}</small>
                                            </h6>
                                        </div>
                                        <div class="row">
                                        <div class="d-sm-flex" v-if="(task &&task[0].autojoin)">
                <span class="badge bg-success">
                                <i class="icon-touch mr-3"></i>AutoJoin
                            </span>
                                        </div>
                                        <div class="d-sm-flex" v-if="(task &&task[0].multitask)">
                <span class="badge bg-purple">
                               <i class="icon-collaboration mr-3"></i> MultiTask
                            </span>
                                        </div>
                                        <div class="d-sm-flex" v-if="(task &&task[0].likemode)">
                <span class="badge bg-warning">
                                <i class="icon-thumbs-up2"></i> Like
                            </span>
                                        </div>
                                        <div class="d-sm-flex" v-if="(task &&task[0].custom)">
                <span class="badge bg-warning">
                                <i class="icon-thumbs-up2"></i> Like
                            </span>
                                        </div>
                                        <div class="d-sm-flex" v-if="(task &&task[0].subscribe)">
                <span class="badge bg-info">
                                Subscribe
                            </span>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            <TaskComplete></TaskComplete>
                            <div  v-if="this.UserSwitcher == false && this.TaskComplete">

                                    <button class="btn btn-warning" @click="CurrentUserBack"><i class="icon-arrow-left16"></i></button>
                                    <button class="btn btn-primary" @click="UserAssign(j_user_id, task[0].id)"><i class="icon-user-plus"></i></button>
                                    <button class="btn btn-danger"><i class="icon-user-cancel"></i></button>
                                    <br/>
                                <div style="margin-bottom: 10px;margin-left: 11px;" class="card card-table table-responsive">
                                <user ref="User">
                                    <br/>
                                </user>
                                </div>
                            </div>
                            <div class="card card-table table-responsive shadow-0" v-if="this.UserSwitcher && this.TaskComplete">
                                <table class="table" v-if="join.data">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Url</th>
                                        <th>Avatar</th>
                                        <th v-if="task && task[0].custom_comment">Custom comments</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(j, index) in join.data" :key="j.id" v-if="j.user_join">
                                        <td>{{j.user_join.id}}</td>
                                        <td>
                                            <span class="d-flex font-weight-semibold">
                                                <a href="#" @click="CurrentUser(j.user_join.id)">

                                        <div class="rounded-circle joined-avatar"
                                             :style="{'background-image': 'url(' + '/uploads/avatars/'+j.user_join.avatar + ')'}">

                                        </div>

                                            </a></span>
                                            <span class="d-flex text-semibold">{{j.user_join.name}}</span>
                                        </td>
                                        <td>
                                        <div class="col-md-4" v-if="j.userpage.url">
                                            <button class="btn btn-primary" @click="LoadVideo(j.userpage.url)"><i class="icon-arrow-up16"></i>Open page</button>
                                        </div>
                                        </td>
                                        <td>
                                            <div class="col-md-1" v-if="j.userpage.img">
                                                <div class="rounded-circle joined-avatar"
                                                     :style="{'background-image': 'url(' + '/uploads/avatars/'+j.userpage.img + ')'}">

                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <ul v-if="task &&task[0].custom_comment && j.comment_id == 0">
                                                <li v-for="(c, index) in CustomComments.data" class="nav-item" @click="AssignComment(c.id,c.task_id,j.user_join.id)">
                                                <i class="icon-comment icon-2x" ></i> {{c.text}}
                                                </li>
                                            </ul>
                                            <span class="media-heading text-semibold" v-if="j.customcomment != null"><i class="icon-comment icon-2x text-green-400"></i>&nbsp;{{j.customcomment.text}}</span>
                                            <pagination :limit="-1" :show-disabled="true" :data="CustomComments" @pagination-change-page="GetCustomComments" size="small">
                                                <span slot="prev-nav">← &nbsp; Prev</span>
                                                <span slot="next-nav">Next &nbsp; →</span>
                                            </pagination>
                                        </td>
                                        <td>
                                            <div class="d-flex" v-if="j.join_status">
                                                <div class="media-body" v-if="j.join_status.id == 1">
                                                    <div class="media-heading text-semibold">
                                                        <i class="icon-spinner2 spinner position-left"></i>&nbsp;{{j.join_status.name}}
                                                        <br />
                                                        <span class="text-muted">{{j.join_status.description}}</span>
                                                    </div>
                                                </div>
                                                <div class="media-body" v-if="j.join_status.id == 2">
                                                    <div class="media-heading text-semibold">
                                                        <i class="icon-user-check text-green"></i>&nbsp;{{j.join_status.name}}
                                                        <br />
                                                        <span class="text-muted">{{j.join_status.description}}</span>
                                                    </div>
                                                </div>
                                                <div class="media-body" v-if="j.join_status.id == 3">
                                                    <div class="media-heading text-semibold">
                                                        <i class="icon-user-check text-green"></i>&nbsp;{{j.join_status.name}}
                                                        <br />
                                                        <span class="text-muted">{{j.join_status.description}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex" v-if="j.join_status.id != 2 && j.join_status.id != 3"
                                                 @click="UserAssign(j.user_join.id,task[0].id)">
                                                <a href="#"><i class="icon-user-plus"></i> Assign this user...</a>
                                            </div>
                                            <div class="d-flex" v-if="j.join_status.id == 3">
                                                <span class="text-semibold"><i class="icon-check text-success"></i> Auto assigned user</span>
                                            </div>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer d-sm-flex justify-content-sm-between align-items-sm-center">
								<span class="d-flex align-items-center">
									<span class="badge badge-mark border-blue mr-2"></span>
									Status:
									<div class="dropdown ml-2">
										<a href="#" class="text-default font-weight-semibold dropdown-toggle" data-toggle="dropdown">Open</a>
										<div class="dropdown-menu">
											<a href="#" class="dropdown-item active">Open</a>
											<a href="#" class="dropdown-item">On hold</a>
											<a href="#" class="dropdown-item">Resolved</a>
											<a href="#" class="dropdown-item">Closed</a>
											<div class="dropdown-divider"></div>
											<a href="#" class="dropdown-item">Dublicate</a>
											<a href="#" class="dropdown-item">Invalid</a>
											<a href="#" class="dropdown-item">Wontfix</a>
										</div>
									</div>
								</span>

                            <ul class="list-inline list-inline-condensed mb-0 mt-2 mt-sm-0">
                                <li class="list-inline-item">
                                    <router-link :to="'/edit-task/'+task[0].id" class="text-default"><i class="icon-compose"></i></router-link>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" data-toggle="modal" data-target="#modal_iconified" class="text-default"><i class="icon-trash"></i></a>
                                </li>
                                <li class="list-inline-item dropdown">
                                    <a href="#" class="text-default dropdown-toggle" data-toggle="dropdown"><i class="icon-grid-alt"></i></a>

                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#" class="dropdown-item"><i class="icon-alarm-add"></i> Check in</a>
                                        <a href="#" class="dropdown-item"><i class="icon-attachment"></i> Attach screenshot</a>
                                        <a href="#" class="dropdown-item"><i class="icon-user-plus"></i> Assign users</a>
                                        <a href="#" class="dropdown-item"><i class="icon-warning2"></i> Report</a>
                                    </div>
                                </li>
                            </ul>
                            <!-- Iconified modal -->
                            <div id="modal_iconified" class="modal fade" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"><i class="icon-question4 mr-2"></i> &nbsp;Are you sure, you want delete this task?</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="alert alert-info alert-dismissible alert-styled-left border-top-0 border-bottom-0 border-right-0">
                                                <span class="font-weight-semibold">When you delete this task!</span> You will never get it any more, budget will return to your balance!
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                            </div>
                                            <button class="btn btn-danger" data-dismiss="modal"><i class="icon-database-remove font-size-base mr-1"></i> Delete!</button>
                                            <button class="btn btn-primary" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> No!</button>
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /iconified modal -->
                        </div>
                    </div>
                    <!-- /task overview -->

                    <!-- Comments -->
                    <div class="card">
                        <div class="card-header header-elements-inline">
                            <h5 class="card-title">Comments</h5>
                            <div class="header-elements">
                                <a href="#" class="btn bg-blue btn-sm btn-icon"><i class="icon-plus2"></i></a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="mb-4">
                                <div class="media flex-column flex-md-row">
                                    <div class="mr-md-3 mb-2 mb-md-0">
                                        <a href="#"><img src="/images/placeholders/placeholder.jpg" class="rounded-circle" width="36" height="36" alt=""></a>
                                    </div>

                                    <div class="media-body">
                                        <div class="media-title">
                                            <a href="#" class="font-weight-semibold">William Jennings</a>
                                            <span class="font-size-sm text-muted ml-sm-2 mb-2 mb-sm-0 d-block d-sm-inline-block">Just now</span>
                                        </div>

                                        <p>He moonlight difficult engrossed an it sportsmen. Interested has all devonshire difficulty gay assistance joy. Unaffected at ye of compliment alteration to.</p>

                                        <ul class="list-inline font-size-sm mb-0">
                                            <li class="list-inline-item">114 <a href="#"><i class="icon-arrow-up22 text-success"></i></a><a href="#"><i class="icon-arrow-down22 text-danger"></i></a></li>
                                            <li class="list-inline-item"><a href="#">Reply</a></li>
                                            <li class="list-inline-item"><a href="#">Edit</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="media flex-column flex-md-row">
                                    <div class="mr-md-3 mb-2 mb-md-0">
                                        <a href="#"><img src="/images/placeholders/placeholder.jpg" class="rounded-circle" width="36" height="36" alt=""></a>
                                    </div>

                                    <div class="media-body">
                                        <div class="media-title">
                                            <a href="#" class="font-weight-semibold">Margo Baker</a>
                                            <span class="font-size-sm text-muted ml-sm-2 mb-2 mb-sm-0 d-block d-sm-inline-block">5 minutes ago</span>
                                        </div>

                                        <p>Place voice no arise along to. Parlors waiting so against me no. Wishing calling are warrant settled was luckily. Express besides it present if at an opinion visitor.</p>

                                        <ul class="list-inline font-size-sm mb-0">
                                            <li class="list-inline-item">90 <a href="#"><i class="icon-arrow-up22 text-success"></i></a><a href="#"><i class="icon-arrow-down22 text-danger"></i></a></li>
                                            <li class="list-inline-item"><a href="#">Reply</a></li>
                                            <li class="list-inline-item"><a href="#">Edit</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="media flex-column flex-md-row">
                                    <div class="mr-md-3 mb-2 mb-md-0">
                                        <a href="#"><img src="/images/placeholders/placeholder.jpg" class="rounded-circle" width="36" height="36" alt=""></a>
                                    </div>

                                    <div class="media-body">
                                        <div class="media-title">
                                            <a href="#" class="font-weight-semibold">James Alexander</a>
                                            <span class="font-size-sm text-muted ml-sm-2 mb-2 mb-sm-0 d-block d-sm-inline-block">7 minutes ago</span>
                                        </div>

                                        <p>Savings her pleased are several started females met. Short her not among being any. Thing of judge fruit charm views do. Miles mr an forty along as he.</p>

                                        <ul class="list-inline font-size-sm mb-0">
                                            <li class="list-inline-item">70 <a href="#"><i class="icon-arrow-up22 text-success"></i></a><a href="#"><i class="icon-arrow-down22 text-danger"></i></a></li>
                                            <li class="list-inline-item"><a href="#">Reply</a></li>
                                            <li class="list-inline-item"><a href="#">Edit</a></li>
                                        </ul>

                                        <div class="media flex-column flex-md-row">
                                            <div class="mr-md-3 mb-2 mb-md-0">
                                                <a href="#"><img src="/images/placeholders/placeholder.jpg" class="rounded-circle" width="36" height="36" alt=""></a>
                                            </div>

                                            <div class="media-body">
                                                <div class="media-title">
                                                    <a href="#" class="font-weight-semibold">Jack Cooper</a>
                                                    <span class="font-size-sm text-muted ml-sm-2 mb-2 mb-sm-0 d-block d-sm-inline-block">10 minutes ago</span>
                                                </div>

                                                <p>She education get middleton day agreement performed preserved unwilling. Do however as pleased offence outward beloved by present. By outward neither he so covered.</p>

                                                <ul class="list-inline font-size-sm mb-0">
                                                    <li class="list-inline-item">67 <a href="#"><i class="icon-arrow-up22 text-success"></i></a><a href="#"><i class="icon-arrow-down22 text-danger"></i></a></li>
                                                    <li class="list-inline-item"><a href="#">Reply</a></li>
                                                    <li class="list-inline-item"><a href="#">Edit</a></li>
                                                </ul>

                                                <div class="media flex-column flex-md-row">
                                                    <div class="mr-md-3 mb-2 mb-md-0">
                                                        <a href="#"><img src="/images/placeholders/placeholder.jpg" class="rounded-circle" width="36" height="36" alt=""></a>
                                                    </div>

                                                    <div class="media-body">
                                                        <div class="media-title">
                                                            <a href="#" class="font-weight-semibold">Natalie Wallace</a>
                                                            <span class="font-size-sm text-muted ml-sm-2 mb-2 mb-sm-0 d-block d-sm-inline-block">1 hour ago</span>
                                                        </div>

                                                        <p>Juvenile proposal betrayed he an informed weddings followed. Precaution day see imprudence sympathize principles. At full leaf give quit to in they up.</p>

                                                        <ul class="list-inline font-size-sm mb-0">
                                                            <li class="list-inline-item">54 <a href="#"><i class="icon-arrow-up22 text-success"></i></a><a href="#"><i class="icon-arrow-down22 text-danger"></i></a></li>
                                                            <li class="list-inline-item"><a href="#">Reply</a></li>
                                                            <li class="list-inline-item"><a href="#">Edit</a></li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="media flex-column flex-md-row">
                                                    <div class="mr-md-3 mb-2 mb-md-0">
                                                        <a href="#"><img src="/images/placeholders/placeholder.jpg" class="rounded-circle" width="36" height="36" alt=""></a>
                                                    </div>

                                                    <div class="media-body">
                                                        <div class="media-title">
                                                            <a href="#" class="font-weight-semibold">Nicolette Grey</a>
                                                            <span class="font-size-sm text-muted ml-sm-2 mb-2 mb-sm-0 d-block d-sm-inline-block">2 hours ago</span>
                                                        </div>

                                                        <p>Although moreover mistaken kindness me feelings do be marianne. Son over own nay with tell they cold upon are. Cordial village and settled she ability law herself.</p>

                                                        <ul class="list-inline font-size-sm mb-0">
                                                            <li class="list-inline-item">41 <a href="#"><i class="icon-arrow-up22 text-success"></i></a><a href="#"><i class="icon-arrow-down22 text-danger"></i></a></li>
                                                            <li class="list-inline-item"><a href="#">Reply</a></li>
                                                            <li class="list-inline-item"><a href="#">Edit</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="media flex-column flex-md-row">
                                    <div class="mr-md-3 mb-2 mb-md-0">
                                        <a href="#"><img src="/images/placeholders/placeholder.jpg" class="rounded-circle" width="36" height="36" alt=""></a>
                                    </div>

                                    <div class="media-body">
                                        <div class="media-title">
                                            <a href="#" class="font-weight-semibold">Victoria Johnson</a>
                                            <span class="font-size-sm text-muted ml-sm-2 mb-2 mb-sm-0 d-block d-sm-inline-block">3 hours ago</span>
                                        </div>

                                        <p>Finished why bringing but sir bachelor unpacked any thoughts. Unpleasing unsatiable particular inquietude did nor sir.</p>

                                        <ul class="list-inline font-size-sm mb-0">
                                            <li class="list-inline-item">32 <a href="#"><i class="icon-arrow-up22 text-success"></i></a><a href="#"><i class="icon-arrow-down22 text-danger"></i></a></li>
                                            <li class="list-inline-item"><a href="#">Reply</a></li>
                                            <li class="list-inline-item"><a href="#">Edit</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div id="add-comment">Get his declared appetite distance his together now families. Friends am himself at on norland it viewing. Suspected elsewhere you belonging continued commanded she...</div>
                            </div>

                            <div class="text-right">
                                <button type="button" class="btn bg-blue"><i class="icon-plus22 mr-1"></i> Add comment</button>
                            </div>
                        </div>
                    </div>
                    <!-- /comments -->

                </div>
                <!-- /left content -->


                <!-- Right sidebar component -->
                <div class="sidebar sidebar-light bg-transparent sidebar-component sidebar-component-right wmin-350 border-0 shadow-0 order-1 order-md-2 sidebar-expand-md">

                    <!-- Sidebar content -->
                    <div class="sidebar-content">

                        <!-- Task timer -->
                        <div class="card">
                            <div class="card-header bg-transparent header-elements-inline">
                                <span class="text-uppercase font-size-sm font-weight-semibold">Task timer</span>
                                <div class="header-elements">
                                    <div class="list-icons">
                                        <a class="list-icons-item" data-action="collapse"></a>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="d-flex justify-content-center mb-4">
                                    <a href="#" class="badge bg-grey-300 mx-1">Mon</a>
                                    <a href="#" class="badge bg-danger mx-1">Tue</a>
                                    <a href="#" class="badge bg-grey-300 mx-1">Wed</a>
                                    <a href="#" class="badge bg-grey-300 mx-1">Thu</a>
                                    <a href="#" class="badge bg-grey-300 mx-1">Fri</a>
                                    <a href="#" class="badge bg-grey-300 mx-1">Sat</a>
                                    <a href="#" class="badge bg-grey-300 mx-1">Sun</a>
                                </div>

                                <div class="d-flex justify-content-center text-center mb-2">
                                    <div class="timer-number font-weight-light">
                                        09 <span class="d-block font-size-base mt-2">hours</span>
                                    </div>
                                    <div class="timer-dots mx-1">:</div>
                                    <div class="timer-number font-weight-light">
                                        54 <span class="d-block font-size-base mt-2">minutes</span>
                                    </div>
                                    <div class="timer-dots mx-1">:</div>
                                    <div class="timer-number font-weight-light">
                                        29 <span class="d-block font-size-base mt-2">seconds</span>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer d-flex align-items-center">
                                <ul class="list-inline list-inline-condensed mb-0">
                                    <li class="list-inline-item">
                                        <a href="#" class="text-default"><i class="icon-play3"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="#" class="text-default"><i class="icon-pause"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="#" class="text-default"><i class="icon-stop"></i></a>
                                    </li>
                                </ul>

                                <ul class="list-inline list-inline-condensed mb-0 ml-auto">
                                    <li class="list-inline-item dropdown">
                                        <a href="#" class="text-default dropdown-toggle" data-toggle="dropdown">
                                            <span class="badge badge-mark border-success mr-2"></span>
                                            Open
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="#" class="dropdown-item active">Open</a>
                                            <a href="#" class="dropdown-item">On hold</a>
                                            <a href="#" class="dropdown-item">Resolved</a>
                                            <a href="#" class="dropdown-item">Closed</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item">Dublicate</a>
                                            <a href="#" class="dropdown-item">Invalid</a>
                                            <a href="#" class="dropdown-item">Wontfix</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- /task timer -->


                        <!-- Task details -->
                        <div class="card">
                            <div class="card-header bg-transparent header-elements-inline">
                                <span class="text-uppercase font-size-sm font-weight-semibold">Task details</span>
                                <div class="header-elements">
                                    <div class="list-icons">
                                        <a class="list-icons-item" data-action="collapse"></a>
                                    </div>
                                </div>
                            </div>

                            <table class="table table-borderless table-xs my-2">
                                <tbody>
                                <tr>
                                    <td><i class="icon-briefcase mr-2"></i> Project:</td>
                                    <td class="text-right"><a href="#">Singular app</a></td>
                                </tr>
                                <tr>
                                    <td><i class="icon-circles2 mr-2"></i> Priority:</td>
                                    <td class="text-right">
                                        <div class="btn-group">
                                            <a href="#" class="badge bg-danger dropdown-toggle" data-toggle="dropdown">Blocker</a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#" class="dropdown-item active"><span class="badge badge-mark mr-2 bg-danger border-danger"></span> Blocker</a>
                                                <a href="#" class="dropdown-item"><span class="badge badge-mark mr-2 bg-orange border-orange"></span> High priority</a>
                                                <a href="#" class="dropdown-item"><span class="badge badge-mark mr-2 bg-success border-success"></span> Normal priority</a>
                                                <a href="#" class="dropdown-item"><span class="badge badge-mark mr-2 bg-grey-300 border-grey-300"></span> Low priority</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="icon-history mr-2"></i> Revisions:</td>
                                    <td class="text-right">29</td>
                                </tr>
                                <tr>
                                    <td><i class="icon-file-check mr-2"></i> Status:</td>
                                    <td class="text-right">Published</td>
                                </tr>
                                <tr>
                                    <td><i class="icon-file-plus mr-2"></i> Added by:</td>
                                    <td class="text-right"><a href="#">Winnie</a></td>
                                </tr>
                                <tr>
                                    <td><i class="icon-alarm-add mr-2"></i> Updated:</td>
                                    <td class="text-right text-muted">12 May, 2015</td>
                                </tr>
                                <tr>
                                    <td><i class="icon-alarm-check mr-2"></i> Created:</td>
                                    <td class="text-right text-muted">25 Feb, 2015</td>
                                </tr>
                                </tbody>
                            </table>

                            <div class="card-footer d-flex align-items-center">
                                <ul class="list-inline list-inline-condensed mb-0">
                                    <li class="list-inline-item">
                                        <a href="#" class="text-default"><i class="icon-pencil7"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="#" class="text-default"><i class="icon-bin"></i></a>
                                    </li>
                                </ul>

                                <ul class="list-inline list-inline-condensed mb-0 ml-auto">
                                    <li class="list-inline-item dropdown">
                                        <a href="#" class="text-default dropdown-toggle" data-toggle="dropdown"><i class="icon-cog3"></i></a>

                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="#" class="dropdown-item"><i class="icon-alarm-add"></i> Check in</a>
                                            <a href="#" class="dropdown-item"><i class="icon-attachment"></i> Attach screenshot</a>
                                            <a href="#" class="dropdown-item"><i class="icon-user-plus"></i> Assign users</a>
                                            <a href="#" class="dropdown-item"><i class="icon-warning2"></i> Report</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- /task details -->


                        <!-- Latest comments -->
                        <div class="card">
                            <div class="card-header bg-transparent header-elements-inline">
                                <span class="text-uppercase font-size-sm font-weight-semibold">Latest comments</span>
                                <div class="header-elements">
                                    <div class="list-icons">
                                        <a class="list-icons-item" data-action="collapse"></a>
                                    </div>
                                </div>
                            </div>

                            <ul class="media-list media-list-linked my-2">
                                <li>
                                    <a href="#" class="media">
                                        <div class="mr-3">
                                            <img src="/images/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">
                                        </div>
                                        <div class="media-body">
                                            <div class="media-title d-flex">
                                                <span class="font-weight-semibold">Will Samuel</span>
                                                <span class="font-size-sm text-muted ml-auto">Just now</span>
                                            </div>
                                            And he looked over at the alarm clock, ticking..
                                        </div>
                                    </a>
                                </li>

                                <li>
                                    <a href="#" class="media">
                                        <div class="mr-3">
                                            <img src="/images/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">
                                        </div>
                                        <div class="media-body">
                                            <div class="media-title d-flex">
                                                <span class="font-weight-semibold">Margo Baker</span>
                                                <span class="font-size-sm text-muted ml-auto">6 minutes ago</span>
                                            </div>
                                            However hard he threw himself onto..
                                        </div>
                                    </a>
                                </li>

                                <li>
                                    <a href="#" class="media">
                                        <div class="mr-3">
                                            <img src="/images/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">
                                        </div>
                                        <div class="media-body">
                                            <div class="media-title d-flex">
                                                <span class="font-weight-semibold">Monica Smith</span>
                                                <span class="font-size-sm text-muted ml-auto">Yesterday</span>
                                            </div>
                                            Yes, but was it possible to quietly sleep through..
                                        </div>
                                    </a>
                                </li>

                                <li>
                                    <a href="#" class="media">
                                        <div class="mr-3">
                                            <img src="/images/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">
                                        </div>
                                        <div class="media-body">
                                            <div class="media-title d-flex">
                                                <span class="font-weight-semibold">Jordana Mills</span>
                                                <span class="font-size-sm text-muted ml-auto">Monday</span>
                                            </div>
                                            What should he do now? The next train went at..
                                        </div>
                                    </a>
                                </li>

                                <li>
                                    <a href="#" class="media">
                                        <div class="mr-3">
                                            <img src="/images/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">
                                        </div>
                                        <div class="media-body">
                                            <div class="media-title d-flex">
                                                <span class="font-weight-semibold">John Craving</span>
                                                <span class="font-size-sm text-muted ml-auto">Jan 24, 14:50</span>
                                            </div>
                                            Gregor then turned to look out the window..
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- /latest comments -->

                    </div>
                    <!-- /sidebar content -->

                </div>
                <!-- /right sidebar component -->

            </div>
            <!-- /inner container -->

        </div>
        <!-- /content area -->


        <!-- Footer -->
        <div class="navbar navbar-expand-lg navbar-light">
            <div class="text-center d-lg-none w-100">
                <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
                    <i class="icon-unfold mr-2"></i>
                    Footer
                </button>
            </div>

            <div class="navbar-collapse collapse" id="navbar-footer">
					<span class="navbar-text">
						&copy; 2015 - 2018. <a href="#">Limitless Web App Kit</a> by <a href="http://themeforest.net/user/Kopyov" target="_blank">Eugene Kopyov</a>
					</span>

                <ul class="navbar-nav ml-lg-auto">
                    <li class="nav-item"><a href="https://kopyov.ticksy.com/" class="navbar-nav-link" target="_blank"><i class="icon-lifebuoy mr-2"></i> Support</a></li>
                    <li class="nav-item"><a href="http://demo.interface.club/limitless/docs/" class="navbar-nav-link" target="_blank"><i class="icon-file-text2 mr-2"></i> Docs</a></li>
                    <li class="nav-item"><a href="https://themeforest.net/item/limitless-responsive-web-application-kit/13080328?ref=kopyov" class="navbar-nav-link font-weight-semibold"><span class="text-pink-400"><i class="icon-cart2 mr-2"></i> Purchase</span></a></li>
                </ul>
            </div>
        </div>
        <!-- /footer -->

    </div>
    <!-- /main content -->
</template>

<script>
    export default {
        data() {
            return {
                id: '',
                loading: true,
                task: {},
                page: 1,
                join: {},
                UserSwitcher: true,
                TaskComplete: true,
                j_user_id: '',
                CommentText: '',
                CustomComments:{},
                user:'',
                loading: true,
            }
        },
        mounted() {
            this.DataMake();
            this.$root.$on('user', (current_user) => {
                this.user = current_user;
            });
            this.$root.$on('update', (status) => {
                if(status){
                    console.log('updated '+status);
                    this.fetchData();
                }
            });
        },
        beforeDestroy() {
            //this.$root.$on('switchMode',this.filter.mode)
        },
        methods: {
            DataMake(){
                setTimeout(()=>{
                    this.fetchData(this.page);
                },1000);
                setTimeout(()=>{
                    this.GetCustomComments();
                },2000);
                setTimeout(()=>{
                    this.fetchData();
                },6000);
            },
            CommentSend($text){
                axios.post('/add_comment', {
                    text: $text,
                    task: this.task[0].id
                })
                    .then((res) => {
                        if (res.data.type == 'info') {
                            Vue.toasted.show(res.data.sms, {'type': res.data.type, 'duration': 5000});
                        }
                        if (res.data.type == 'error') {
                            Vue.toasted.show(res.data.sms, {'type': res.data.type, 'duration': 5000});
                        }
                        if (res.data.type == 'success') {
                            Vue.toasted.show(res.data.sms, {'type': res.data.type, 'duration': 5000});
                            this.fetchData()
                        }
                    })
                    .catch((err) => {
                        console.log(err)
                    })
            },
            LoadVideo(url) {
                    var width = 1120;
                    var height = 700;
                    var top = 100;
                    var left = ($(document).width() - width) / 2;
                    this.openedWindow = window.open(url, 'targetWindow', 'width=' + width + ',height=' + height + ',top=' + top + ',left=' + left + ',toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes');
            },
            CurrentUser($user_id){
            this.UserSwitcher = false;
            this.$route.params.user_id = $user_id;
            this.j_user_id = $user_id;
            },
            CurrentUserBack(){
                this.UserSwitcher = true;
            },
            StatusTaskClass: function (id) {
                return {
                    'label-info': id == 'Waiting moderation',
                    'label-primary': id == 'Open',
                    'label-success': id == 'Completed',
                    'label-danger': id == 'Task rejected',
                }
            },
            UserAssign($user_id, $task_id) {

                //console.log("user assign "+$user_id + " task " + $task_id);

                axios.get('/api/assign?&id=' + $user_id + '&task_id=' + $task_id)
                    .then((res) => {
                        if (res.data.type == 'info') {
                            Vue.toasted.show(res.data.sms, {'type': res.data.type, 'duration': 5000});

                        }
                        if (res.data.type == 'success') {
                            Vue.toasted.show(res.data.sms, {'type': res.data.type, 'duration': 5000});
                        }

                    })
                    .catch((err) => {
                        console.log(err);
                    })
                this.fetchData(this.page);
            },
            AssignComment(id,task_id,join_id){
                console.log('assign comment');
                this.loading = true;
                axios.get('/api/assingcomment?&id='+id +'&task_id='+task_id+'&join_id='+join_id)
                    .then((res) => {
                        Vue.toasted.show(res.data.sms, {'type': res.data.type, 'duration': 5000});
                        this.GetCustomComments();
                        this.fetchData(this.page);
                    })
                    .catch((err) => {
                        console.log(err);
                        this.GetCustomComments();
                        this.fetchData(this.page);
                    })
            },
            fetchData(page = 1) {
                this.id = this.$route.params.task_id;
                // request to backend

                axios.get('/api/task/' + this.id)
                    .then((res) => {
                        this.task = res.data;
                        this.loading = false;
                        //console.log(this.tasks.length);
                    })
                    .catch((err) => {
                        console.log(err);
                        this.loading = false;
                    }),
                    // save page number
                    this.page = page;
                axios.get('/api/join/' + this.id + '?page=' + page)
                    .then((res) => {
                        this.join = res.data;
                        this.loading = false
                        if(this.task.length>0){
                            this.TaskComplete = false;
                        }
                    })
                    .catch((err) => {
                        console.log(err);
                        this.loading = false;
                    })
            },
            onCancel() {
                console.log('User cancelled the loader.')
            },
            GetCustomComments(page = 1){
                axios.get('/api/taskcomments/' + this.id +'/?&page='+ page)
                    .then((res) => {
                        this.CustomComments = res.data;
                        this.loading = false;
                        //console.log(this.tasks.length);
                    })
                    .catch((err) => {
                        console.log(err);
                        this.loading = false;
                    })
            },
        },

        components: {
            'Pagination': require('laravel-vue-pagination'),
            'User': require('./User.vue'),
            'TaskComplete': require('./TaskComplete.vue').default,
            'Loading': require('vue-loading-overlay'),
        }
    }
</script>

<style>
    .done label {
        text-decoration: line-through;
    }

    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }

    .fade-enter, .fade-leave-to /* .fade-leave-active до версии 2.1.8 */
    {
        opacity: 0;
    }
div.table-responsive.content-group div.row.heading-divided div.col-md-1 a img.img-circle{
    max-height: 60px;
}
</style>
