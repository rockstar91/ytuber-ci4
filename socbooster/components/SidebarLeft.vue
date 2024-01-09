<template>
    <!-- Main sidebar -->
    <div>

        <!-- Sidebar mobile toggler -->
        <div class="sidebar-mobile-toggler text-center">
            <a href="#" class="sidebar-mobile-main-toggle">
                <i class="icon-arrow-left8"></i>
            </a>
            Navigation
            <a href="#" class="sidebar-mobile-expand">
                <i class="icon-screen-full"></i>
                <i class="icon-screen-normal"></i>
            </a>
        </div>
        <!-- /sidebar mobile toggler -->


        <!-- Sidebar content -->
        <div class="sidebar-content">

            <!-- User menu -->
            <div class="sidebar-user">
                <div class="card-body">
                    <div class="media">
                        <div class="mr-3">
                            <a href="#">
                                <div class="rounded-circle avatarheader"
                                     :style="{'background-image': 'url(' + '/uploads/avatars/'+user.avatar + ')'}"></div>
                            </a>
                        </div>

                        <div class="media-body">
                            <div class="media-title font-weight-semibold">{{user.name}}</div>
                            <div class="font-size-xs opacity-50">
                                <i class="icon-coins font-size-sm"></i> {{user.balance}}&nbsp;
                            </div>
                        </div>

                        <div class="ml-3 align-self-center">
                            <a href="#" class="text-white"><i class="icon-cog3"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /user menu -->


            <!-- Main navigation -->
            <div class="card card-sidebar-mobile">
                <ul class="nav nav-sidebar" data-nav-type="accordion">

                    <!-- Main -->
                    <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li>
                    <li class="nav-item">
                        <a href="/" class="nav-link">
                            <i class="icon-home4"></i>
                            <span>
									Dashboard
									<span class="d-block font-weight-normal opacity-50">No active orders</span>
								</span>
                        </a>
                    </li>
                    <!-- /main -->


                </ul>
            </div>
            <!-- /main navigation -->

        </div>
        <!-- /sidebar content -->

    </div>
    <!-- /main sidebar -->
</template>
<script>
    export default {

        mounted() {
            this.fetchData();
        },
        data() {
            return {
                joined_avatar: '/uploads/avatars/placeholder.jpg',
                user:{},
                id:'',
                loading: true,
            }
        },

        methods: {
            fetchData() {
                axios.get('/api/user_balance/')
                    .then((res) => {
                        this.user = res.data.data;
                        this.$root.$emit('user', this.user);
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
