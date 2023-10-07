<template>
    <div class="container">
        <div class="row login-register mx-0 justify-content-center align-items-center">
            <div class="col-lg-5">
                <div class="card border-0 shadow-xxs-2 mb-6">
                    <div class="card-body px-8 py-6">
                        <h2 class="card-title fs-30 font-weight-600 text-dark lh-16 mb-2 text-center">Register</h2>
                        <Form @submit="submitForm" :validation-schema="schema">
                            <div class="form-group mb-4">
                                <label for="username-1">Name</label>
                                <vue-input type="text" name="name" :apiError="errors.email || []" v-model="user.name" placeholder="Name"/>
                            </div>

                            <div class="form-group mb-4">
                                <label for="username-1">Email</label>
                                <vue-input type="email" name="email" :apiError="errors.email || []" v-model="user.email" placeholder="Email" />
                            </div>
                            <div class="form-group mb-4">
                                <label for="password-2">Password</label>
                                <vue-input type="password" name="password"  required="true" v-model="user.password" placeholder="Password"/>
                            </div>
                           
                            <button type="submit" class="btn btn-primary btn-lg btn-block rounded">Register</button>
                            <div class="text-center">
                                <router-link to="/login" class="btn btn-primary mt-3 rounded">Login</router-link>
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
    import axios from "axios";
    // import store from "../../store";
    import { Form} from 'vee-validate';
    import * as yup from 'yup';
    export default {
        data(){
            return {
                user:{
                    name:"",
                    email:"",
                    password:""
                },
                validatonsErrors:{}
            }
        },
        methods:{
            async submitForm(){
                const response = await axios.post('http://127.0.0.1:8000/api/user/register',this.user);
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
                    this.$store.dispatch('Login',response.data.data);
                    this.validatonsErrors = [];
                    this.$swal(response.data.message);
                    // this.$router.push({ name: 'Dashboard' });
                }
            }
        },
        computed: {
            schema(){
                return yup.object().shape({
                    name: yup.string().required(),
                    email: yup.string().email().required(),
                    password: yup.string().min(8).required(),
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