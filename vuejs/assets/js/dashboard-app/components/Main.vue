<template>
    <div>
        <router-link :to="{ name: 'dashboard.index', params: {}}" class="b-breadcrumb__link">
            dashboard
        </router-link>
        <vue-form-generator :schema="schema" :model="model" :options="formOptions"></vue-form-generator>
    </div>
</template>

<script>
    import Vue from 'vue'
    import VueFormGenerator from 'vue-form-generator'
    import 'vue-form-generator/dist/vfg.css'
    import Menu from './Menu';
    //
    Vue.use(VueFormGenerator)
    export default {
        components: [
            VueFormGenerator,
            Menu
        ],
        data () {
            return {
                companies: [],
                model: {
                    name: '',
                    cost: '',
                    company: [],
                    email: '',
                    comment: '',
                },
                schema: {
                    fields: {
                        name:{
                            type: 'input',
                            inputType: 'text',
                            label: 'Имя',
                            model: 'name',
                            placeholder: 'Имя',
                            featured: true,
                            required: true,
                            min: 2,
                            validator: VueFormGenerator.validators.string
                        },
                        cost:{
                            type: 'input',
                            inputType: 'number',
                            label: 'Сумма',
                            model: 'cost',
                            required: true,
                            validator: VueFormGenerator.validators.number
                        },
                        company:{
                            type: 'select',
                            label: 'Компания',
                            model: 'company',
                            required: true,
                            values: []
                        },
                        email:{
                            type: 'input',
                            inputType: 'email',
                            label: 'E-mail',
                            model: 'email',
                            required: true,
                            placeholder: 'e-mail',
                            validator: VueFormGenerator.validators.email
                        },
                        comment:{
                            type: "textArea",
                            label: 'Комментарий',
                            model: 'comment',
                            hint: "Max 255 characters",
                            max: 255,
                            placeholder: "Комментарий",
                            rows: 4,
                            validator: VueFormGenerator.validators.string
                        },
                        submit:{
                            type: 'submit',
                            onSubmit: () => {},
                            validateBeforeSubmit: true
                        }
                    }
                },
                formOptions: {
                    validateAfterLoad: true,
                    validateAfterChanged: true,
                    validateAsync: true
                }
            }
        },
        mounted () {
            this.getCompanies()
            this.schema.fields.company.values = () => { return this.companies }
            this.schema.fields.submit.onSubmit = this.save;
        },
        created () {
        },
        methods: {
            getCompanies(){
                var self = this;
                this.$http
                    .post('/ajax/getCompanies', {

                    }, {emulateJSON: true})
                    .then((response) => {
                        if(response.body.companies){
                            self.companies = response.body.companies;
                        }
                    });
            },
            save(){
                this.$http
                    .post('/ajax/addDonate', this.model, {emulateJSON: true})
                    .then((response) => {
                        if(response.body.success){
                            this.$router.push('/success/');
                        }
                    });
            }
        },
    }
</script>
