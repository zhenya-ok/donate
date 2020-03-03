<template>
    <div>
        <router-link :to="{ name: 'main', params: {}}" class="b-breadcrumb__link">
            Главная
        </router-link>
        <router-link :to="{ name: 'dashboard.index', params: {}}" class="b-breadcrumb__link">
            dashboard
        </router-link>
        <div class="alert alert-success">Спасибо за оплату!</div>
    </div>
</template>


<script>
    export default {
        data() {
            return {

            }
        }
    }
</script>