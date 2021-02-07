<template>
    <div>
        <h1>Profile</h1>
    </div>
</template>
<script>
    export default {
        data() {
            return {}
        },
        mounted() {
            const data = {
                title: "Profil"
            }
            Fire.$emit('PageChange', data)
        }
    }

</script>
