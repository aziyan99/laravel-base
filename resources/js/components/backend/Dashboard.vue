<template>
    <div>
        <h1>Dashboard</h1>
    </div>
</template>
<script>
    export default {
        data() {
            return {}
        },
        mounted() {
            const data = {
                title: "Dashbor"
            }
            Fire.$emit('PageChange', data)
        }
    }

</script>
