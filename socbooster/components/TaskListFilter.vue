<template>
    <!-- Filter toolbar -->
    <div class="navbar navbar-expand-lg navbar-light navbar-component rounded">
        <div class="text-center d-lg-none w-100">
            <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse"
                    data-target="#navbar-filter">
                <i class="icon-unfold mr-2"></i>
                Filters
            </button>
        </div>

        <div class="navbar-collapse collapse" id="navbar-filter">
								<span class="navbar-text font-weight-semibold mr-3">
									Filter:
								</span>

            <ul class="navbar-nav flex-wrap">
                <li class="nav-item dropdown">
                    <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-sort-time-asc mr-2"></i>
                        By task type
                    </a>

                    <ul class="dropdown-menu">
                        <li class="text-center text-slate">
                            <a href="#" class="dropdown-item" @click="TaskType('all')">Show all</a>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li class="dropdown-item" v-for="tasktype in tasktypes" @click="TaskType(tasktype.name)">
                            <div class="rounded-circle filter-avatar"
                                 :style="{'background-image': 'url('+'/storage/'+tasktype.image + ')'}"></div>
                            <a class="font-size-base text-muted d-block" style="display:inline"
                               @click="TaskType(tasktype.name)">{{tasktype.name}}</a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-sort-time-asc mr-2"></i>
                        By social type
                    </a>

                    <ul class="dropdown-menu">
                        <li class="text-center text-slate">
                            <a href="#" class="dropdown-item" @click="SocialType('all')">Show all</a>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li class="dropdown-item" v-for="soctype in socialtypes" @click="SocialType(soctype.name)">
                            <!--                            <div class="rounded-circle filter-avatar" :style="{'background-image': 'url('+'/storage/'+tasktype.image + ')'}"></div>-->
                            <a class="font-size-base text-muted d-block" style="display:inline"
                               @click="SocialType(soctype.name)">{{soctype.name}}</a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-sort-numeric-asc mr-2"></i>
                        By status
                    </a>

                    <ul class="dropdown-menu">
                        <li class="dropdown-item">
                            <a href="#" class="dropdown-item" @click="TaskStatus('All')">Show all</a>
                            <div class="dropdown-divider"></div>
                        </li>

                        <li class="dropdown-item">
                            <a href="#" @click="TaskStatus('Free')">Free to join</a>
                        </li>
                        <li class="dropdown-item">
                            <a href="#" @click="TaskStatus('Open')">Open</a>
                        </li>
                        <li class="dropdown-item">
                            <a href="#" @click="TaskStatus('Moderation')">Moderation</a>
                        </li>
                    </ul>
                </li>
            </ul>

            <span class="navbar-text font-weight-semibold mr-3 ml-md-auto">
									View mode:
								</span>

            <div class="form-check form-check-switchery form-check-switchery-double mb-3 mb-lg-0"
                 style="margin-top: 8px;">
                <label class="form-check-label">
                    &nbsp;
                    <toggle-button v-model="mode"
                                   :value="false"
                                   color="#3498db"
                                   :sync="true"
                                   :labels="true"
                                   :width="60"
                                   :height="26"
                                   :font-size="14" @change="$root.$emit('viewmode', mode)"/>
                    &nbsp;
                </label>
            </div>
        </div>
    </div>
    <!-- /filter toolbar -->

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
                socialtypes: [],
            }
        },
        methods: {
            SocialType(soc) {
                this.$root.$emit('soctype', soc);
                //console.log(socmode);
            },
            TaskType(soc) {
                console.log(soc);
                axios.get('/api/getsoctype?social_type=' + soc)
                    .then((resp) => {
                        //console.log(res);
                        this.socialtypes = resp.data;
                    })
                    .catch(error => console.log(error));
                this.$root.$emit('tasktype', soc);
            },
            TaskStatus(soc) {
                console.log(soc);
                this.$root.$emit('statustype', soc);
                //console.log(soc);
            },
            LoadTaskTypes() {
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
<style>
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
</style>