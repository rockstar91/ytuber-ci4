<template>
    <div class="content" v-if="loading = true">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <form @submit="formSubmit">
                    <div class="form-group-row" id="choose_task">
                        <label>Choose type of tasks</label>
                        <div class="form-control" style="min-height: 58px;">
                            <ul class="nav">
                                <li class="dropdown" style="margin-top: 4px;">
                                    <div class="dropdown-toggle" data-toggle="dropdown">
                                        <div class="col-md-1" style="max-width: 60px;float: left;">
                                            <img class="rounded-circle float-left filter-avatar"
                                                 :src="'/storage/'+category_image"/>
                                        </div>
                                        <div class="col-md-10" style="max-width: 200px;margin-top:0px">
                                            <p style="font-size: 16px;margin-top: 5px;">{{category_name}}<span
                                                    class="caret"></span></p>
                                        </div>
                                    </div>
                                    <ul class="dropdown-menu" style="top: 30px;left: 50px;">
                                        <li class="dropdown-item" v-for="category in categories"
                                            @click="loadSubCategories(category.id,category.image,category.name)">

                                            <div class="rounded-circle filter-avatar" :style="{'background-image': 'url('+'/storage/'+category.image + ')'}"></div>

                                            <a style="display:inline" href="#"
                                               @click="loadSubCategories(category.id,category.image,category.name)">{{category.name}}</a>
                                        </li>
                                    </ul>
                                    <br/>
                                </li>
                            </ul>

                        </div>
                    </div>


                    <div class="form-group-row" v-if="category_name != 'Choose task type'">
                        <label>Social types</label>
                        <!--                            <select v-model="subcategory_id" @change="loadSocialType($event)"class="form-control">-->
                        <!--                                <option v-for="(subcategory,x) in subcategories" :value="subcategory.id" :name="subcategory.name" :key="x">{{subcategory.name}}</option>-->
                        <!--                            </select>-->
                        <div class="form-control" style="min-height: 58px;">
                            <ul class="nav">
                                <li class="dropdown" style="margin-top: 4px;">
                                    <div class="row dropdown-toggle" data-toggle="dropdown">

                                        <div class="col-md-10" style="max-width: 200px;float: left;margin-top:0px">
                               <span class="label label-flat text-blue-600 label-icon float-left"
                                     style="float:left;margin-right: 30px;">

                                            <i v-bind:class="SocialStatusClass(socialtype_name)" class="icon-2x"></i>

                                        </span>
                                            <p style="font-size: 16px;margin-top: 5px;">
                                                {{socialtype_name}}
                                                <span class="caret">
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    <ul class="dropdown-menu">
                                        <li class="dropdown-item" v-for="subcategory in subcategories" @click="loadSocialType(subcategory.name,subcategory.id)">
                                            <span class="img-circle img-sm"><i
                                                    class="img-circle img-sm float-left icon-2x"
                                                    style="position: relative;left: -8px;"
                                                    v-bind:class="SocialStatusClass(subcategory.name)"></i></span>
                                            <a style="display:inline" href="#"
                                               @click="loadSocialType(subcategory.name,subcategory.id)">
                                                {{subcategory.name}}</a>
                                        </li>
                                    </ul>
                                    <br/>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!--                        Multitasks-->
                    <div class="card" v-show="socialtype_name == 'Multitask'" style="margin-top: 15px;font-size: 14px;">
                        <br />
                    <div class="form-group">
                        <br />
                        <div class="form-check">
                            <label class="form-check-label" v-for="(MultiTask,z) in MultiTask" :key="z" >
                                <input type="checkbox" class="form-check-input-styled-primary" v-model="MultiTask.value"
                                       @click="MultiTaskSort(MultiTask.name,MultiTask.value)" style="margin-left:3px">&nbsp;
                                {{MultiTask.name}}
                            </label>
                        </div>

                    </div>
                </div>
                    <div class="form-group">
                        <label>Enter task URL:</label>
                        <input v-model="TaskUrl" type="url" class="form-control"
                               placeholder="https://youtu.be/neSHAWdE44c"
                               name="url" @change="ParseDataUrl(TaskUrl)">
                    </div>
                    <div class="form-group" v-if="TaskImage != ''">
                        <div class="input-group">
                            <div class="thumb thumb-slide">
                                <img :src="TaskImage" :alt="TaskName" style="max-height: 95px;width: auto;float: left;">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Enter task name:</label>
                        <input v-model="TaskName" type="text" class="form-control" placeholder="My task 1" name="name">
                    </div>
                    <div class="form-group">
                        <label>Automatically approve users:</label>
                        <div class="form-control">

                            <toggle-button v-model="autoapprove"
                                           :value="false"
                                           color="#3498db"
                                           :sync="true"
                                           :labels="true"
                                           :width="60"
                                           :height="26"
                                           :font-size="14"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Description:</label>
                        <textarea v-model="TaskDesc" rows="4" cols="4" class="form-control elastic"
                                  placeholder="Type description"
                                  name="description"></textarea>
                    </div>

                    <!--                        comments add dinamicly form-->

                    <div class="form-group"
                         v-show="socialtype_name == 'Custom comments' || multicustomcomments == true">
                        <label>Add your own comments here</label>
                        <div class="input-group" v-for="(CommentsInput,k) in CommentsInput" :key="k"
                             style="margin-bottom: 4px;">
                            <input type="text" class="form-control" placeholder="Write your own comment here"
                                   v-model="CommentsInput.text" @click="CommentInputInfo(k)">
                            <span class="input-group-addon">

                                <i class="icon-plus2" @click="addComment(k)"
                                   v-show="!k || k == CommentsInput.length-1"></i>

                                <i class="icon-cancel-circle2" @click="removeComment(k)"
                                   v-show="k || ( !k && CommentsInput.length > 1)"></i>
                            </span>
                        </div>
                    </div>

                    <!--                        task count info-->

                    <labeL v-if="category_name != 'Choose task type'">You will get: {{task_targets}} {{category_name}}
                        {{socialtype_name}} </labeL>

                    <!--                        sliders-->

                    <div class="panel panel-body">
                        <div class="text-center">
                            <h6 class="no-margin text-semibold">Setup your task budget {{Slider1value}} points</h6>
                        </div>

                        <div class="" v-show="show">
                            <vue-slider ref="slider1" v-model="Slider1value" :min="1" :max="budget"></vue-slider>
                        </div>
                    </div>
                    <div class="panel panel-body">
                        <div class="text-center">
                            <h6 class="no-margin text-semibold">{{task_type_name}} {{Slider2value}} points</h6>
                        </div>
                        <div class="" v-show="show">
                            <vue-slider ref="slider2" v-model="Slider2value"></vue-slider>
                        </div>
                    </div>
                    <div class="panel panel-body">
                        <div class="text-center">
                            <h6 class="no-margin text-semibold">Time {{Slider3value}} sec</h6>
                        </div>
                        <div class="" v-show="show">
                            <vue-slider ref="slider3" v-model="Slider3value" :min="30" :max="maxtime"></vue-slider>
                        </div>
                    </div>
                    <input type="hidden" value="0" class="budget" name="budget"/>
                    <input type="hidden" value="0" class="price" name="price"/>
                    <div class="text-right">
                        <button type="submit" class="btn btn-success">Submit form
                            <i class="icon-arrow-right14 position-right"></i></button>
                    </div>
                </form>

                <!--                        <pre>{{ $data | json }}</pre>-->

                <div v-if="this.budget<=0">
                    You don't have money to create task!
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                loading: false,
                categories: [],
                subcategories: [],
                category_image: 'placeholder.jpg',
                category_name: 'Choose task type',
                socialtype_name: 'Choose social types',
                task_targets: '',
                socialtype_icon: ' icon-sphere',
                multicustomcomments: false,
                CommentsInput: [
                    {
                        text: ''
                    }
                ],
                MultiTask: [],
                value: '',
                output: '',
                task_type_name: 'Per action price',
                category_id: 0,
                subcategory_id: 0,
                Slider1value: 10,
                Slider2H1: '',
                Slider2value: 10,
                Slider3value: 30,
                show: true,
                TaskUrl: '',
                TaskDesc: '',
                TaskName: '',
                TaskImage: '',
                budget: 10,
                maxtime: 600,
                autoapprove: false,
                multimode:false,
            }
        },
        mounted() {
            this.loadCategories();
            this.GetBalance();
            this.loadfromrouter();
            // let switcherjs = document.createElement('script');
            // switcherjs.setAttribute('src', "public/js/switchery.min.js");
            // document.head.appendChild(switcherjs);
        },
        methods: {
            SocialStatusClass(name) {
                return {
                    'icon-film4': name == 'Views',
                    'icon-comment': name == 'Negative comments',
                    'icon-stack-up': name == 'Multitask',
                    'icon-stack-empty': name == 'Reposts',
                    'icon-thumbs-up2': name == 'Likes',
                    'icon-thumbs-down2': name == 'DisLikes',
                    'icon-comments': name == 'Positive comments',
                    'icon-comment-discussion': name == 'Custom comments',
                    'icon-users4': name == 'Subsribers',
                    'icon-sphere3': name == 'Choose social types',
                    'icon-sphere3': name == 'Choose task type'
                }
            },
            ParseDataUrl(Url) {
                const regex = /(?:[?&]vi?=|\/embed\/|\/\d\d?\/|\/vi?\/|https?:\/\/(?:www\.)?youtu\.be\/)([^&\n?#]+)/g;
                const matches = regex.exec(Url);
                const video_id = matches[1];

                axios.get('/api/youtubedatavideo/' + video_id)
                    .then((res) => {
                        this.TaskName = res.data.snippet.title;
                        this.TaskDesc = res.data.snippet.description;
                        this.TaskImage = res.data.snippet.thumbnails.default.url;
                    })
            },
            PerTaskName() {
                if (this.socialtype_name == 'Views') {
                    this.task_type_name = 'Price per View';
                }
                ;
                if (this.socialtype_name == 'Reposts') {
                    this.task_type_name = 'Price per Repost';
                }
                ;
                if (this.socialtype_name == 'Negative comments') {
                    this.task_type_name = 'Price per Comment';
                }
                ;
                if (this.socialtype_name == 'Multitask') {
                    this.task_type_name = 'Price per Task';
                    this.multimode = true;
                }
                else{
                    this.multimode = false;
                }
                ;
                if (this.socialtype_name == 'Likes') {
                    this.task_type_name = 'Price per Like';
                }
                ;
                if (this.socialtype_name == 'DisLikes') {
                    this.task_type_name = 'Price per DisLikes';
                }
                ;
                if (this.socialtype_name == 'Positive comments') {
                    this.task_type_name = 'Price per Comment';
                }
                ;
                if (this.socialtype_name == 'Custom comments') {
                    this.task_type_name = 'Price per Comment';
                }
                ;
                if (this.socialtype_name == 'Subsribers') {
                    this.task_type_name = 'Price per Subsriber';
                }
                ;
            },
            MultiTaskSort(name, value) {
                console.log(name, value);
                if (name == 'Custom comments' ||name == 'Positive comments' || name == 'Negative comments' ) {
                    this.multicustomcomments = true;
                }
            },
            CommentInputInfo(k) {
                console.log(this.CommentsInput.length + ' ' + k)
            },
            GetBalance() {
                axios.get('/api/user_balance')
                    .then((res) => {
                        this.budget = res.data.data.balance;
                        //this.$refs.slider1.max = this.budget;
                        this.loading = true;
                    })

            },
            addComment(index) {
                this.CommentsInput.push({text: ''});
            },
            removeComment(index) {
                this.CommentsInput.splice(index, 1);
            },
            loadCategories() {
                let url = '/api/task_types',
                    img = this.image
                this.dynamicDropdown(url, 'categories')
            },
            loadfromrouter() {
                this.TaskDesc = this.$route.params.TaskDesc;
                this.TaskName = this.$route.params.TaskName;
                this.TaskUrl = this.$route.params.TaskUrl;
                this.TaskImage = this.$route.params.TaskImage;
            },
            loadSubCategories(id, image, name) {
                this.category_name = name;
                this.category_id = id;
                this.category_image = image;
                let url = '/api/social_types/' + id;
                this.dynamicDropdown(url, 'subcategories');
                this.multicustomcomments = false;
                this.socialtype_name = 'Choose social types';
                this.MultiTask = [];
                if(this.socialtype_name == 'Multitask'){
                    this.multimode = true;
                }
                else{
                    this.multimode = false;
                }

            },
            dynamicDropdown(url, data) {
                axios.get(url)
                    .then(response => this[data] = response.data)
                    .catch(error => console.log(error))
            },
            loadSocialType(name, id) {

                this.socialtype_name = name;
                this.socialtype_icon = this.SocialStatusClass(name);
                console.log(this.socialtype_icon);
                this.subcategory_id = id;
                this.PerTaskName();

            },
            formSubmit(e) {

                e.preventDefault();

                let currentObj = this;

                //validation
                if (this.category_name == 'Choose task type') {
                    Vue.toasted.show('Pls choose task type first!', {'type': 'warning', 'duration': 7000});
                    return "500";
                }
                if (this.socialtype_name == 'Choose social types') {
                    Vue.toasted.show('Pls choose social type, before create task', {'type': 'warning', 'duration': 7000});
                    return "500";
                }
                if (this.TaskUrl == null) {
                    Vue.toasted.show('Task url is empty, fill url before create task', {'type': 'warning', 'duration': 7000});
                    return "500";
                }
                if (this.TaskName == null) {
                    Vue.toasted.show('Task name is empty, fill name before create task', {'type': 'warning', 'duration': 7000});
                    return "500";
                }
                if (this.TaskDesc == null) {
                    Vue.toasted.show('Task description is empty, fill description before create task', {'warning': 'error', 'duration': 7000});
                    return "500";
                }

                //Post task
                console.log(this);
                axios.post('/api/create-task', {

                    name: this.TaskName,
                    description: this.TaskDesc,
                    url: this.TaskUrl,
                    task_types: this.category_id,
                    social_types: this.subcategory_id,
                    budget: this.Slider1value,
                    price: this.Slider2value,
                    time: this.Slider3value,
                    image: this.TaskImage,
                    multitask: this.MultiTask,
                    autojoin: this.autoapprove,
                    customcomments: this.CommentsInput,
                    multimode: this.multimode,
                    socialtype_name: this.socialtype_name,
                })
                    .then(function (response) {
                        if (response.data.type == 'success') {
                            console.log('success');
                            currentObj.$route.params.mine = true;
                            currentObj.$router.push({path: 'mytasks'});
                            currentObj.$toasted.success(response.data.sms);
                            //this.$router.push({ name: 'MainComponent' }));
                        }
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            }
        },
        watch: {
            Slider1value: {
                immediate: true,
                deep: true,
                handler() {
                    this.task_targets = parseInt(this.Slider1value / this.Slider2value);
                }
            },
            Slider2value: {
                immediate: true,
                deep: true,
                handler() {
                    this.task_targets = parseInt(this.Slider1value / this.Slider2value);
                },

            },
            subcategories: {
                immediate: true,
                deep: true,
                handler() {
                    this.subcategories.forEach((key) => {
                        if (key.name != 'Multitask' && this.MultiTask.length < this.subcategories.length) {
                            this.MultiTask.push({name: key.name, value: false});
                        }
                    });
                },

            }
        },
    }

</script>
<style>
    .icon-plus2 {
        color: green;
    }

    .filter-avatar {
        background-size: cover;
        border-radius: 50% 50% 50% 50%;
        width: 100px;
        height: 100px;
        max-height: 32px;
        max-width: 32px;
        float: left;
        margin-right: 16px;
        position: relative;
        top: -4px;
        left: -4px;
    }

    .form-control .dropdown-toggle::after {
        display: none;
    }
</style>


