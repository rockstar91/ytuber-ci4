<template>
    <div class="content">
        <p v-if="loading" class="notification is-info">
            Loading
        </p>
        <template v-else>

    <div class="col-lg-3 col-md-6 card">
    <div class="row">
        <div class="card-img-actions m-1" style="max-width: 320px;margin: 0 auto!important;margin-top: 10px!important;margin-bottom: 20px!important;">
            <img :src="'/uploads/avatars/'+user[0].avatar"
                 style="text-align: center;margin: 0 auto;width: 100%;"/>
            <div class="card-img-actions-overlay card-img">
                <a href="#" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round" data-popup="lightbox" rel="group">
                    <i class="icon-youtube"></i>
                </a>

                <a href="#"  @click="" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round ml-2">
                    <i class="icon-link"></i>
                </a>
            </div>
        </div>
        </div>
    </div>
            <div class="col-lg-3 col-md-6 card">

                <ul class="media-list">
                    <li class="media" v-for="page in user[0].pages" :key="user[0].pages.id">
                        <a href="#" class="media-left"><img :src="'/public/assets/images/'+page.img" class="img-sm img-circle" alt=""></a>
                        <div class="media-body">
                            <a href="#" class="media-heading text-semibold"> {{page.name}}</a>
                            <span class="text-size-mini text-muted display-block"> {{page.url}}</span>
                        </div>
                        <div class="media-right media-middle">
                            <span class="status-mark" v-bind:class="StatusPageClass(page.status_page_id)"></span>
                        </div>
                    </li>
                </ul>
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
                user:{},
                id:'',
                loading: true,
            }
        },

        methods: {
            StatusPageClass: function (id) {
                return {
                    'bg-success': id == '3',
                    'bg-danger': id == '2',
                    'bg-warning': id == '1'
                }
            },
            fetchData() {
                this.id = this.$route.params.user_id;
                // request to backend
                axios.get('/api/user/' + this.id)
                    .then((res) => {
                        this.user = res.data;
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
