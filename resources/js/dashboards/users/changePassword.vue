<template>
    <div class="px-3 px-lg-6 px-xxl-131 py-5 py-lg-10 add-new-invoice" data-animated-id="1">
        <div class="mb-6"> <h2 class="mb-0 text-heading fs-22 lh-15">Change Password</h2> </div>
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
                                                    <vue-label for="current_password" class="text-heading" text="Current Password"/>
                                                    <vue-input type="password" id="current_password" name="current_password" :apiError="errors.current_password || []" v-model="user.current_password" placeholder="Current password" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 invoice-address-company">
                                            <div class="invoice-address-company-fields">
                                                <div class="form-group">
                                                    <vue-label for="password" class="text-heading" text="Password"/>
                                                    <vue-input type="password" id="password" name="password" :apiError="errors.password || []" v-model="user.password" placeholder="Password" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 invoice-address-company">
                                            <div class="invoice-address-company-fields">
                                                <div class="form-group">
                                                    <vue-label for="password_confirmation" class="text-heading" text="Confirm Password"/>
                                                    <vue-input type="password" id="password_confirmation" name="password_confirmation" :apiError="errors.password_confirmation || []" v-model="user.password_confirmation" placeholder="Confirm password" />
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
    import vueInput from '../../components/vueInput.vue';
    import vueLabel from '../../components/vueLabel.vue';
    import { Form } from 'vee-validate';
    import * as yup from 'yup';

    export default {
        data(){
            return {
                user:{
                    current_password:'',
                    password:'',
                    password_confirmation:'',
                    id:this.$store.state.user.id
                },
                validatonsErrors:{},
            }
        },
        components:{
            vueInput,
            vueLabel,
            Form
        },
        computed: {
            schema(){
                return yup.object().shape({
                    current_password: yup.string().required("Current password field is required"),
                    password: yup.string().min(6).required(),
                    password_confirmation: yup.string().oneOf([yup.ref("password")], "Passwords must match"),
                });
            },
            errors() {
                return this.validatonsErrors; // Computed property to access the server response
            },
        },
        methods:{
            async submitForm(){
                const response = await axios.post('user/update/password',this.user);
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
                    this.user={ current_password:'', password:'', password_confirmation:'', id:this.$store.state.user.id }
                    this.$swal(response.data.message);
                }
            }
        },
        
    }
</script>