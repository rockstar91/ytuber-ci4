<template>
    <div class="content">
        <loading :active.sync="isLoading"
                 :can-cancel="false"
                 :on-cancel="onCancel"
                 :is-full-page="true" loader="dots" color="green"></loading>
        <div class="row">
            <div class="col-md-10">
                <div style="margin-bottom: 4px;">
                    <div class="form-group row">
                        <div class="col-lg-10">
                            <div class="input-group">
                                <input class="form-control border-primary border-lg text-black" v-model="keywords"
                                       placeholder="Type text or URL here...">
                                <span class="input-group-append">
												<button class="btn btn-light" type="button"
                                                        @click="GetRating">Search</button>
											</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12" v-if="youtubemode == true">
                <i @click="CloseYoutube" class="icon-cross text-black float-right"></i>
                <div class="card">
                    <div class="card-img-actions m-1">
                        <div class="card-img embed-responsive embed-responsive-16by9">
                            <YtClient></YtClient>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div v-if="foundpage == true" class="col-4-auto" style="margin: 0 auto;">
                <div class="card social-card">
                    <div class="card-img-actions m-1"
                         style="max-width: 320px;margin: 0 auto!important;margin-top: 10px!important;margin-bottom: 20px!important;">
                        <img :src="TaskImage"
                             style="text-align: center;margin: 0 auto;width: 100%; max-height: 240px;"/>
                        <div class="card-img-actions-overlay card-img">
                            <a @click="LoadVideo(keywords)" href="#"
                               class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round"
                               data-popup="lightbox" rel="group">
                                <i class="icon-youtube"></i>
                            </a>

                            <a href="#" @click="CreateTask(keywords,TaskName,TaskImage,TaskDesc)"
                               class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round ml-2">
                                <i class="icon-link"></i>
                            </a>
                        </div>
                    </div>

                    <div class="caption text-center">
                        <h6 class="text-semibold no-margin">
                            {{TaskName| truncate(54)}}
                            <small class="display-block" v-if="TaskDesc!='0'">
                                {{TaskDesc| truncate(105) }}</small>
                            <small class="display-block" v-if="dataRegPage!=0">
                                {{dataRegPage}}</small>
                        </h6>
                        <ul class="list-icons list-icons-extended mt-3 list-likes">
                            <li v-if="viewCount!=0">
                                <i class="icon-film4"> {{viewCount}}</i>
                            </li>
                            <li>
                                <i class="icon-comment-discussion" v-if="commentCount!=0"> {{commentCount}}</i>
                            </li>
                            <li>
                                <i class="icon-thumbs-up2" v-if="TasklikeCount!=0"> {{likeCount}}</i>
                            </li>
                            <li>
                                <i class="float-left icon-thumbs-down2" v-if="TaskdislikeCount!=0">
                                    {{dislikeCount}}</i>
                            </li>
                            <li>
                                <i class="float-left icon-stack-text" v-if="postsCount!=0"> {{postsCount}}</i>
                            </li>
                            <li>
                                <i class="float-left icon-stack-picture" v-if="photosCount!=0">
                                    {{photosCount}}</i>
                            </li>
                            <li>
                                <i class="float-left icon-users" v-if="subscribesCount!=0">
                                    {{subscribesCount}}</i>
                            </li>
                            <li>
                                <i class="float-left icon-users" v-if="friendsCount!=0">
                                    {{friendsCount}}</i>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- social pages-->
            <div class="col-4-auto" style="margin: 0 auto;" v-for="page in pages.data">
                <div class="card social-card" style="min-height: 430px;">
                    <div class="caption text-center" style="margin: 3px">
                    <h6 class="text-semibold no-margin" style="min-height:22px">
                        {{page.name| truncate(42)}}
                    </h6>
                    </div>
                    <div class="card-img-actions m-1"
                         style="max-width: 320px; margin: 0 auto!important;margin-top: 10px!important;margin-bottom: 20px!important;">
                        <img :src="page.avatar"
                             style="text-align: center;margin: 0 auto; width: 100%;max-height: 240px;"/>
                        <div class="card-img-actions-overlay card-img">
                            <a @click="LoadVideo(page.url)" href="#"
                               class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round"
                               data-popup="lightbox" rel="group">
                                <i class="icon-youtube"></i>
                            </a>

                            <a href="#" @click="CreateTask(page.url,page.name,page.avatar,page.description)"
                               class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round ml-2">
                                <i class="icon-link"></i>
                            </a>
                        </div>
                    </div>

                    <div class="caption text-center" style="margin: 3px">
                        <h6 class="text-semibold no-margin" style="min-height:42px">
                        <small class="display-block" style="padding:4px">
                            {{page.description| truncate(105)}}
                        </small>
                        <small class="display-block" style="padding:4px" v-if="dataRegPage!=0">
                            {{page.dataRegPage }}
                        </small>
                        </h6>
                        <ul class="list-icons list-icons-extended mt-3 list-likes">
                            <li v-if="page.viewCount"><i class="icon-film4">&nbsp;{{page.viewCount}}</i>
                            </li>
                            <li v-if="page.commentCount"><i class="icon-comment-discussion" v-if="page.commentCount">&nbsp;{{page.commentCount}}</i>
                            </li>
                            <li v-if="page.likeCount"><i class="icon-thumbs-up2" v-if="page.likeCount">&nbsp;{{page.likeCount}}</i>
                            </li>
                            <li v-if="page.dislikeCount"><i class="float-left icon-thumbs-down2">&nbsp;{{page.dislikeCount}}</i>
                            </li>
                            <li v-if="page.postsCount"><i
                                    class="float-left icon-stack-text">&nbsp;{{page.postsCount}}</i>
                            </li>
                            <li v-if="page.photosCount"><i class="float-left icon-stack-picture">&nbsp;{{page.photosCount}}</i>
                            </li>
                            <li v-if="page.subscribersCount"><i class="float-left icon-users">&nbsp;{{page.subscribersCount}}</i>
                            </li>
                            <li v-if="page.friendsCount">
                                <i class="float-left icon-users">
                                    {{page.friendsCount}}</i>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <pagination :data="pages" @pagination-change-page="getResults">
                <span slot="prev-nav">&lt; Previous</span>
                <span slot="next-nav">Next &gt;</span>
            </pagination>
        </div>
    </div>
</template>

<script>
    // Import component
    // Import stylesheet
    import 'vue-loading-overlay/dist/vue-loading.css';

    export default {
        data() {
            return {
                isLoading: false,
                keywords: '',
                video_id: '',
                TaskName: '',
                TaskDesc: '',
                TaskImage: '',
                commentCount: '',
                dislikeCount: '',
                favoriteCount: '',
                postsCount: '',
                subscribesCount: '',
                friendsCount: '',
                photosCount: '',
                likeCount: '',
                viewCount: '',
                dataRegPage: '',
                channel_id: '',
                foundpage: false,
                pages: {},
                youtubemode: false,
                videoId: 'videoId',
            }
        },
        components: {
            'Pagination': require('laravel-vue-pagination'),
            'YtClient': require('./ytClient.vue').default,
            'Loading': require('vue-loading-overlay'),
        },
        watch: {
            keywords(after, before) {
                this.foundpage = false;
                this.video_id = false;
                if (after != '') {
                    this.GetRating();
                    this.doAjax();
                }

            }
        },
        mounted() {
            this.$gtm.enable(true);
            this.getResults();
        },
        methods: {
            CreateTask(TaskUrl, TaskName, TaskImage, TaskDesc) {
                this.$router.push({
                    name: 'CreateTaskFrom',
                    params: {'TaskUrl': TaskUrl, 'TaskName': TaskName, 'TaskImage': TaskImage, 'TaskDesc': TaskDesc}
                });
            },
            CloseYoutube() {
                this.youtubemode = false;
            },
            LoadVideo(url) {
                console.log(url);
                this.youtubemode = false;
                const regex = /(?:[?&]vi?=|\/embed\/|\/\d\d?\/|\/vi?\/|https?:\/\/(?:www\.)?youtu\.be\/)([^&\n?#]+)/g;
                const youtubevid = regex.exec(url);
                if (youtubevid) {
                    this.$route.params.videoId = url;
                    this.youtubemode = true;
                } else {
                    this.youtubemode = false;
                    var width = 1120;
                    var height = 700;
                    var top = 100;
                    var left = ($(document).width() - width) / 2;
                    this.openedWindow = window.open(url, 'targetWindow', 'width=' + width + ',height=' + height + ',top=' + top + ',left=' + left + ',toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes');
                }
            },
            WatchVideo(id) {
                this.$router.push({name: 'youtubeplayer', params: {'videoId': id}});
            },
            doAjax() {
                if (this.keywords != undefined || this.keywords != '') {
                    this.isLoading = false;

                    this.isLoading = true;
                    // simulate AJAX
                    setTimeout(() => {
                        this.isLoading = false;
                        this.foundpage = false;
                        this.GetRating();
                    }, 6000)
                }
            },
            onCancel() {
                console.log('User cancelled the loader.')
            },
            getResults(page = 1) {
                axios.get('/api/getratingall?page=' + page)
                    .then(response => {
                        this.pages = response.data;
                        this.isLoading = false;
                    });
            },
            GetRating() {
                this.isLoading = true;
                if (this.keywords == undefined || this.keywords == '') {
                    this.isLoading = false;
                }
                //Find Youtube Video or channel....
                try {
                    const regex = /(?:[?&]vi?=|\/embed\/|\/\d\d?\/|\/vi?\/|https?:\/\/(?:www\.)?youtu\.be\/)([^&\n?#]+)/g;
                    const youtubevid = regex.exec(this.keywords);
                    console.log(this.keywords);
                    var postarr = {
                        'url': this.keywords,
                        'foundpage': this.foundpage
                    };

                    axios.post('/api/getratingpage?', postarr,)
                        .then((res) => {

                            console.log('searhing videos');

                            console.log(res.data.data);

                            if (res.data != undefined && res.data.data == 'waiting') {
                                this.doAjax();
                            }
                            if (res.data != undefined) {
                                if (res.data.length != 0 && res.data.data != "waiting") {
                                    this.pages = res.data;
                                    this.isLoading = false;
                                }
                            }
                        })
                        .catch(error => {
                            //console.log(error.response.data.dataerrors.url[0]);
                            try {
                                if (error.response.data.errors.url[0] == 'The url has already been taken.') {
                                    this.$toasted.show(error.response.data.errors.url[0]);
                                }
                            } catch {
                            }

                        });
                    if (youtubevid) {
                        const video_id = youtubevid[1];
                        this.video_id = video_id;

                        if (video_id && video_id != 'watch') {
                            console.log(this.foundpage);
                            if (this.foundpage == false) {
                                console.log('parsing video youtube');
                                setTimeout(() => {
                                    axios.get('/api/youtubedatavideo/' + video_id)
                                        .then((res) => {
                                            console.log(res.data);
                                            this.TaskName = res.data.snippet.title;
                                            this.TaskDesc = res.data.snippet.description;
                                            this.TaskImage = res.data.snippet.thumbnails.high.url;
                                            this.channel_id = res.data.snippet.channelId;
                                        });
                                }, 1500);
                                setTimeout(() => {
                                    axios.get('/api/video/youtube/stat/' + video_id)
                                        .then((res) => {
                                            console.log(res.data.items[0].statistics);
                                            this.commentCount = res.data.items[0].statistics.commentCount;
                                            this.dislikeCount = res.data.items[0].statistics.dislikeCount;
                                            this.favoriteCount = res.data.items[0].statistics.favoriteCount;
                                            this.likeCount = res.data.items[0].statistics.likeCount;
                                            this.viewCount = res.data.items[0].statistics.viewCount;
                                        });
                                }, 5500);
                                this.foundpage = true;
                            }
                            console.log('posting array');
                            setTimeout(() => {
                                var postarray = {
                                    'name': this.TaskName,
                                    'url': this.keywords,
                                    'video_id': this.video_id,
                                    'channel_id': this.channel_id,
                                    'desc': this.TaskDesc,
                                    'image': this.TaskImage,
                                    'commentCount': this.commentCount,
                                    'likeCount': this.likeCount,
                                    'dislikeCount': this.dislikeCount,
                                    'viewCount': this.viewCount,
                                    'favoriteCount': this.favoriteCount
                                };
                                console.log(this.TaskName);

                                axios.post('/api/add/youtubevideo', postarray)
                                    .then((res) => {

                                        if (res.data.type == 'info') {
                                            this.$toasted.show(res.data.sms);
                                        }
                                        if (res.data.type == 'error') {
                                            this.$toasted.show(res.data.sms);
                                        }
                                        if (res.data.type == 'success') {
                                            this.isLoading = false;
                                            this.$toasted.show(res.data.sms);
                                        }
                                    })
                                    .catch((err) => {
                                        var errnum = "422";

                                        if (typeof err.stack == "string" && err.stack.indexOf(errnum) > -1) {
                                            console.log('found in base');
                                            this.foundpage = true;
                                            this.isLoading = false;
                                        }
                                        console.log(err)
                                    })
                            }, 1500);
                            this.foundpage = true;

                        }


                    }

                    const regex1 = /(?:https|http)\:\/\/(?:[\w]+\.)?youtube\.com\/(?:c\/|channel\/|user\/)?([a-zA-Z0-9\-]{1,})/g;
                    const matches1 = regex1.exec(this.keywords);

                    if (this.foundpage == false) {
                        if (matches1) {
                            console.log(this.foundpage);
                            console.log('not found channel');
                        } else {
                            try {
                                const channel_id = matches1[1];
                                console.log('get rating ' + channel_id)
                                this.isLoading = false
                            } catch {
                            }

                        }
                    }

                    //end finding Youtube Video or channel....
                    this.isLoading = false
                } catch {
                }
            }
        },
    }
</script>
<style>
    .social-card {
        max-width: 400px;
        margin: 7px;
    }

    .list-likes {
        list-style: none;
    }
</style>