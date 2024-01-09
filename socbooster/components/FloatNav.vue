<template>
    <!-- Clickable menu -->
    <ul class="fab-menu" data-fab-toggle="click">
        <li>
            <a href="/create-task" class="fab-menu-btn btn bg-blue btn-float rounded-round btn-icon">
                <i class="fab-icon-open icon-plus3"></i>
                <i class="fab-icon-close icon-cross2"></i>
            </a>

                <li>
                    <div data-fab-label="Play button">
                        <a href="/autoview" class="btn btn-light rounded-round btn-icon btn-float">
                            <i class="icon-play"></i>
                        </a>
                    </div>
                </li>
    </ul>
    <!-- /clickable menu -->

</template>
<script>
    export default {
        data () {
            return {
            }
        },
        mounted() {
        },
        methods:{
        }
    }
</script>