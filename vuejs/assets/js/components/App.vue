<template>
  <span>
    <router-view></router-view>
    <div id="app"></div>
  </span>
</template>


<script>
    export default {
        provide() {
            const popup = {};
            Object.defineProperty(popup, 'isShow', {
                enumerable: true,
                get: () => this.popup.isShow,
                set: (val) => this.popup.isShow = val,
            });
            Object.defineProperty(popup, 'type', {
                enumerable: true,
                get: () => this.popup.type,
                set: (val) => this.popup.type = val,
            });
            return { popup };
        },
        data() {
            return {
                popup: {
                    isShow: false,
                    type: "group"
                },
                account: null,
                currency: null
            }
        },
        methods: {
        }
    }
</script>