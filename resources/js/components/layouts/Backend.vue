<template>
    <div>
        <Sidemenu />
        <div class="c-wrapper c-fixed-components">
            <Topmenu />
            <div class="c-body">
                <main class="c-main">
                    <div class="container-fluid">
                        <div class="fade-in">
                            <router-view></router-view>
                            <vue-progress-bar></vue-progress-bar>
                        </div>
                    </div>
                </main>
                <Footermenu />
            </div>
        </div>
    </div>
</template>
<script>
    import Sidemenu from './../backend/partials/Sidemenu';
    import Topmenu from './../backend/partials/Topmenu';
    import Footermenu from './../backend/partials/Footermenu';
    export default {
        data() {
            return {}
        },
        components: {
            Sidemenu,
            Topmenu,
            Footermenu
        },
        watch: {
            '$route'(to, from) {
                document.title = to.meta.title || 'Admin Area'
                this.pageTitle = to.meta.page_title
            },
        },
        created() {
            Fire.$on('PageChange', (data) => {
                this.pageTitle = data.title;
            });
        },
        mounted() {
            const data = {
                title: "Profile"
            }
            Fire.$emit('PageChange', data)
        }
    }

</script>
