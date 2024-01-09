<template>
    <div class="navbar navbar-expand-lg navbar-light navbar-component rounded">
        <div class="text-center d-lg-none w-100">
            <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse"
                    data-target="#navbar-filter">
                <i class="icon-unfold mr-2"></i>
                Filters
            </button>
        </div>

        <div class="navbar-collapse collapse" id="navbar-filter">
            <span class="navbar-text font-weight-semibold mr-3">Filter:</span>
            <ul class="navbar-nav flex-wrap">
                <li class="dropdown">
                    <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown"><i
                            class=" icon-arrow-down7 position-left"></i> By Social <span
                            class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li class="text-center text-slate"><a href="#" @click="SocialType('all')">Show all</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-item text-center text-slate" v-for="tasktype in tasktypes" @click="SocialType(tasktype.name)">
                            <div class="rounded-circle filter-avatar"
                                 :style="{'background-image': 'url('+'/storage/'+tasktype.image + ')'}"></div>
                            <a class="font-size-base text-muted d-block" style="display:inline"
                               @click="SocialType(tasktype.name)">{{tasktype.name}}</a>
                        </li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown"><i
                            class="icon-arrow-down7 position-left"></i> By type <span
                            class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li class="text-center text-slate"><a href="#" @click="SocialType2('all')">Show all</a></li>
                        <li class="divider"></li>
                        <li v-for="soctype in socialtypes" class="text-center text-slate">
                            <a href="#" @click="SocialType2(soctype.name)">{{soctype.name}}</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-sort-amount-desc position-left">
                        </i> By status<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li class="text-center text-slate" @click="TaskStatus('all')"><a href="#">Show all</a></li>
                        <li class="divider"></li>
                        <li class="text-center text-slate"><a href="#" @click="TaskStatus('Free')">User waiting approve</a></li>
                        <li class="text-center text-slate"><a href="#" @click="TaskStatus('Open')">User complete assigned</a></li>
                        <li class="text-center text-slate"><a href="#" @click="TaskStatus('Auto')">User auto assigned</a></li>
                        <li class="text-center text-slate"><a href="#" @click="TaskStatus('Completed')">Task is completed</a></li>
                        <li class="text-center text-slate"><a href="#" @click="TaskStatus('Rejected')">User was rejected</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
    export default {
        mounted() {
            this.LoadTaskTypes();
        },
        props: [],
        data() {
            return {
                mode: true,
                tasktypes: [],
                socialtypes:[],
            }
        },
        methods: {
            SocialType(socmode){
                axios.get('/api/getsoctype?social_type='+socmode)
                    .then((resp) => {
                        //console.log(res);
                        this.socialtypes = resp.data;
                    })
                    .catch(error => console.log(error));
                this.$root.$emit('soctype', socmode);
                //console.log(socmode);
            },
            SocialType2(soc) {
                this.$root.$emit('soctype2', soc);
            },
            TaskStatus(soc) {
                this.$root.$emit('statustype', soc);
                //console.log(soc);
            },
            LoadTaskTypes(){
                axios.get('/api/task_types')
                    .then((res) => {
                        //console.log(res);
                        this.tasktypes = res.data;
                    })
                    .catch(error => console.log(error))
            },
        }
    }
</script>
