<template>
    <!-- Main navbar -->
    <div class="navbar navbar-expand-md navbar-dark">
        <div class="navbar-brand">
            <a href="/" class="d-inline-block">
                <i class="icon-planet"></i>&nbsp;Socbooster.com
            </a>
        </div>

        <div class="d-md-none">
            <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
                <i class="icon-paragraph-justify3"></i>
            </button>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
                <i class="icon-user"></i>
            </button>
            <button class="navbar-toggler sidebar-mobile-secondary-toggle" type="button">
                <i class="icon-unfold"></i>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbar-mobile">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
                        <i class="icon-paragraph-justify3"></i>
                    </a>
                </li>
            </ul>
            <span class="badge bg-success ml-md-3 mr-md-auto">Online</span>
            <ul class="navbar-nav">
           <li class="nav-item dropdown dropdown-user">
                    <a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown">
                        <div class="rounded-circle avatarheader"
                             :style="{'background-image': 'url(' + '/uploads/avatars/'+user.avatar + ')'}"></div>
                        <span>&nbsp;&nbsp;&nbsp;{{user.name}}</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <router-link to="/profile" href="#" class="dropdown-item"><i class="icon-user-plus"></i> My profile</router-link>
                        <a href="#" class="dropdown-item"><i class="icon-coins"></i> My balance&nbsp;&nbsp;&nbsp;{{user.balance}}</a>
                        <router-link to="/mytasks" href="#" class="dropdown-item"><i class="icon-comment-discussion"></i> My tasks <span class="badge badge-pill bg-blue ml-auto">58</span></router-link>
                        <div class="dropdown-divider"></div>
                        <a href="/logout" class="dropdown-item"><i class="icon-switch2"></i> Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <!-- /main navbar -->
</template>
<script>
    export default {
        data() {
            return {
                user:[],
            }
        },
        mounted() {
            this.GetUser()
        },
        methods: {
            GetUser(){
                this.$root.$on('user', (current_user) => {
                    this.user = current_user;
                });
            },
            RouteToTasks(){
                this.$root.$emit('minestatus', true);
                this.$router.push({name: 'MyTasks', params: {'filter.mode': true }});
            },
            RouteToProfile(){
                this.$router.push({name: 'Profile'});
            },
            RouteToUsers(){
                this.$router.push('Users');
            },
            RouteToAllTasks(){
                this.$router.push('all_tasks');
            }
        },
    }
</script>
<style>
    .avatarheader{
        max-width: 35px;
        width: 35px;
        max-height: 35px;
        height: 35px;
        background-size: cover;
    }
</style>