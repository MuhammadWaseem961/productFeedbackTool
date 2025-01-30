<template>
    <div class="px-3 px-lg-6 px-xxl-131 py-5 py-lg-10 add-new-invoice" data-animated-id="1">
        <div class="mb-6"> <h2 class="mb-0 text-heading fs-22 lh-15">Profile</h2> </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="row">
                    <div class="col-xl-12 mb-6 mb-xl-0">
                        <div class="card">
                            <div class="card-body p-6">
                                <Form @submit="submitForm" :validation-schema="schema">
                                    <div class="row">
                                        <div class="col-md-6 invoice-address-company">
                                            <div class="invoice-address-company-fields">
                                                <div class="form-group">
                                                    <vue-label for="name" class="text-heading" text="Name"/>
                                                    <Field name="name" :validateOnBlur="true" v-slot="{ errors }">
                                                        <input type="text" class="form-control border-0" name="name" id="name"
                                                            placeholder="Enter name" v-model="user.name"/>

                                                        <span v-if="apiErrors.name && apiErrors.name.length" class="text-danger mt-1">{{ apiErrors.name[0].charAt(0).toUpperCase() +
                                                            apiErrors.name[0].slice(1) }}</span>

                                                        <ErrorMessage name="name" v-else-if="errors && errors.length">
                                                            <span class="text-danger mt-1">{{ errors[0].charAt(0).toUpperCase() + errors[0].slice(1) }}</span>
                                                        </ErrorMessage>
                                                    </Field>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 invoice-address-company">
                                            <div class="invoice-address-company-fields">
                                                <div class="form-group">
                                                    <vue-label for="email" class="text-heading" text="Email"/>
                                                    <Field name="email" :validateOnBlur="true" v-slot="{ errors }">
                                                        <input type="email" class="form-control border-0" name="email" id="email"
                                                            placeholder="Enter email" v-model="user.email"/>

                                                        <span v-if="apiErrors.email && apiErrors.email.length" class="text-danger mt-1">{{ apiErrors.email[0].charAt(0).toUpperCase() +
                                                            apiErrors.email[0].slice(1) }}</span>

                                                        <ErrorMessage name="email" v-else-if="errors && errors.length">
                                                            <span class="text-danger mt-1">{{ errors[0].charAt(0).toUpperCase() + errors[0].slice(1) }}</span>
                                                        </ErrorMessage>
                                                    </Field>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        
                                    <div class="mt-3 text-right">
                                        <button type="submit" class="btn btn-primary btn-send   btn-lg">Save</button>
                                    </div>
                                </Form>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
</template>

<script>
    import axios from '../../config/axios';
    import vueLabel from '../../components/vueLabel.vue';
    import { Form ,Field,ErrorMessage } from 'vee-validate';
    import * as yup from 'yup';

    export default {
        data(){
            return {
                user:{
                    email:this.$store.state.user.email,
                    name:this.$store.state.user.name,
                    id:this.$store.state.user.id,
                },
                validatonsErrors:{},
            }
        },
        components:{
            vueLabel,
            Form,
            Field,
            ErrorMessage
        },
        computed: {
            schema(){
                return yup.object().shape({
                    name: yup.string().required(),
                    email: yup.string().email().required(),
                });
            },
            apiErrors() {
                return this.validatonsErrors; // Computed property to access the server response
            },
        },
        methods:{
            async submitForm(){
                const response = await axios.post('user/profile',this.user);
                if(response.data.hasOwnProperty('authentication') && !response.data.authentication){
                    if(response.data.message!=''){
                        this.$swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.data.message
                        });
                        this.$router.push('/login');
                    }
                }
                else if(response.data.success==false){
                    this.validatonsErrors= response.data.errors;
                    if(response.data.message!=''){
                        this.$swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.data.message
                        });
                    }
                }else if(response.data.success==true){
                    this.validatonsErrors = [];
                    this.$store.commit('setUser',response.data.data);
                    this.$swal(response.data.message);
                }
            }
        },
        
    }
</script>