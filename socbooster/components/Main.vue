<template>
    <div>
        <!-- Page header -->
        <div class="page-header page-header-light border-bottom-0">

            <!-- Top breadcrumb line -->
            <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                <div class="d-flex">
                    <div class="breadcrumb">
                        <a href="/" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Socbooster</a>
                        <span class="breadcrumb-item active">Home</span>
                    </div>

                    <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                </div>
            </div>
            <!-- /breadcrumb line -->


            <!-- Page header content -->
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Search and add social pages</span> -
                        get free rating</h4>
                    <a href="/" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                </div>
            </div>
            <!-- /page header content -->


            <!-- Profile navigation -->
            <div class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="text-center d-lg-none w-100">
                    <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse"
                            data-target="#navbar-second">
                        <i class="icon-menu7 mr-2"></i>
                        MENU
                    </button>
                </div>
            </div>
            <!-- /profile navigation -->

        </div>
        <!-- /page header -->
        <div class="content"><AddRatingPage></AddRatingPage></div>


    </div>
</template>
<script>
    export default {
        data() {
            return {}
        },
        mounted() {
        },
        methods: {
            GetUser($id){
                $id = document.querySelector("meta[name='user-id']").getAttribute('content');
                this.$router.push({name: 'User', params: {'user_id': $id }});
            },
            CheckRouter2() {
                this.$router.push({name: 'Task', params: {'id': '1'}});
            },
            CheckRouter3() {
                this.$router.push({name: 'youtubeplayer', params: {'videoId': 'https://www.youtube.com/watch?v=0X_7HfjfSUk'}});
            },
            CheckRouter(){
                this.$toasted.info('Hello world!',{icon:'icon-mail-read',duration: 6500,
                    // you can pass a single action as below
                    action : {
                        text : 'Cancel',
                        onClick : (e, toastObject) => {
                            toastObject.goAway(0);
                        }
                    },

                    // you can pass a multiple actions as an array of actions
                    action : [
                        {
                            text : 'Cancel',
                            onClick : (e, toastObject) => {
                                toastObject.goAway(0);
                            }
                        },
                        {
                            text : 'Undo',
                            // router navigation
                            push : {
                                name : 'somewhere',
                                // this will prevent toast from closing
                                dontClose : true
                            }
                        }
                    ]
                })
            },
        },
        components:{
            'AddRatingPage': require('./AddRatingPage.vue').default,
        }
    }
</script>
