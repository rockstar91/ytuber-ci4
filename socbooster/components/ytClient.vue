<template>
    <div>
        <div class="d-flex-row" v-if="progressbar == 'true'">
            <b-progress ref="limit" :value="time" variant="dark" :max="maxtime" striped :animated="animate"
                        class="mt-2"></b-progress>
        </div>
        <div>
            <youtube @playing="playing" @ready="ready" @paused="paused" :video-id="videoId" @change="change"
                     player-width="100%"
                     player-height="750" :player-vars="{autoplay: 1}"></youtube>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                videoId: 'videoId',
                isRunning: false,
                interval: null,
                time: 0,
                maxtime:'maxtime',
                animate: '',
                progressbar: 'true',
                user:[],
            }
        },
        mounted() {
        },
        methods: {
            StartTimer() {
                //console.log('clicked');
            },
            ready(event) {
                this.player = event.player
            },
            paused(event) {
                clearInterval(this.interval);
                this.isRunning = !this.isRunning;
                //console.log('paused video');
            },
            change() {
               // console.log('changing...');
            },
            playing(event) {
                this.maxtime = this.$route.params.maxtime;
                this.toggleTimer();
                //console.log('playing video');
                // The player is playing a video.
            },
            OpenTask() {
                this.videoId = this.$youtube.getIdFromURL(this.$route.params.videoId);
                this.time = 0;
                this.$gtm.trackEvent({
                    event: null, // Event type [default = 'interaction'] (Optional)
                    category: 'Yt Videos',
                    action: 'click',
                    label: 'Open video task',
                    value: 5000,
                    noninteraction: false // Optional
                });
                axios.get('/api/user_balance/')
                    .then((res) => {
                        this.user = res.data.data;
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            },
            toggleTimer() {
                if (!this.isRunning) {
                    clearInterval(this.interval);
                } else {
                    this.interval = setInterval(this.incrementTime, 1000);
                }
                this.isRunning = !this.isRunning
            },
            incrementTime() {
                this.time = parseInt(this.time) + 1;
            },
        },
        mounted() {
            this.$gtm.trackView('MyScreenName', 'currentpath');
        },
        watch: {
            time: function () {
                if (this.$route.params.videoId.length > 20) {
                    this.videoId = this.$youtube.getIdFromURL(this.$route.params.videoId);
                }
                if (this.time > this.maxtime && this.$refs.limit.value > this.maxtime) {
                    const str = String(String('ytbe'+this.maxtime+this.user.balance)+String(this.videoId+'fsdfsl34DFfe45huererjtwe'));
                    this.toggleTimer();
                    this.progressbar = false;
                    const bcrypt = require('bcryptjs');
                    var hash = bcrypt.hashSync(str, 10);
                    this.$root.$emit('ytfinish',hash,str,this.user.balance);
                    this.$root.$emit('update',true);
                }
            },
            '$route.params.videoId': {
                handler: function () {
                    this.isRunning = false;
                    this.toggleTimer();
                    this.time = 0;
                    this.OpenTask();
                },
                deep: true,
                immediate: true
            },
        },
        components: {
            'VueYoutube': require('vue-youtube-embed'),
            'BootstrapVue': require('bootstrap-vue'),
        }
    }
</script>