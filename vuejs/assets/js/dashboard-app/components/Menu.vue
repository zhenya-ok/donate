<template>
    <div>
        <router-link :to="{ name: 'dashboard.index', params: {}}" class="b-breadcrumb__link">
            dashboard
        </router-link>
        <router-link :to="{ name: 'success', params: {}}" class="b-breadcrumb__link">
            Главная
        </router-link>
    </div>
</template>


<script>
    export default {
        data() {
            return {}
        }
    }
</script>