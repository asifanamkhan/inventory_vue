<template>
    
</template>

<script>
    import User from "../../helper/User";
    import Noty from 'noty';
    export default {
        name: "logout",
        created(){
            User.logout();
            new Noty({
                type: 'warning',
                layout: 'topRight',
                text: 'Successfully log out',
                timeout: 2000,

            }).show();
            this.$router.push({name: '/'})
        },

    }
</script>

<style scoped>

</style>