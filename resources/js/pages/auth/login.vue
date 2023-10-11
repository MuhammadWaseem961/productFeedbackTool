<template>
    <div class="container mt-5">
        <div class="row login-register mx-0 justify-content-center align-items-center">
            <div class="col-lg-5">
                <div class="card border-0 shadow-xxs-2 mb-6">
                    <div class="card-body px-8 py-6">
                        <h2 class="card-title fs-30 font-weight-600 text-dark lh-16 mb-2 text-center">Login</h2>
                        <Form @submit="submitForm" :validation-schema="schema">
                            <div class="form-group mb-4">
                                <label for="username-1">Email</label>
                                <vue-input type="email" name="email" :apiError="errors.email || []" v-model="user.email" placeholder="Email" aria-label="Email" />
                            </div>
                            <div class="form-group mb-4">
                                <label for="password-2">Password</label>
                                <vue-input type="password" name="password"  required="true" v-model="user.password" placeholder="Password" aria-label="Password" />
                            </div>
                           
                            <button type="submit" class="btn btn-primary btn-lg btn-block rounded">Log in</button>
                            <div class="text-center">
                                <router-link to="/register" class="btn btn-primary mt-3 rounded">Register</router-link>
                            </div>
                        </Form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import vueInput from '../../components/vueInput.vue';
    import axios from '../../config/axios';
    import store from "../../stores";
    import { Form} from 'vee-validate';
    import * as yup from 'yup';
    export default {
        data(){
            return {
                user:{
                    email:"",
                    password:""
                },
                validatonsErrors:{},
            }
        },
        methods:{
            async submitForm(){
                const response = await axios.post('user/login',this.user);
                if(response.data.success==false){
                    this.validatonsErrors= response.data.errors;
                    if(response.data.message!=''){
                        this.$swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.data.message
                        });
                    }
                }else if(response.data.success==true){
                    store.dispatch('Login',response.data.data);
                    this.validatonsErrors = [];
                    this.$swal(response.data.message);
                    this.$router.push({ name: response.data.data.redirectUrl });
                }
            }
        },
        computed: {
            schema(){
                return yup.object().shape({
                    email: yup.string().email().required(),
                });
            },
            errors() {
                return this.validatonsErrors; // Computed property to access the server response
            },
        },
        components:{
            Form,
            vueInput,
        }
    }
</script>