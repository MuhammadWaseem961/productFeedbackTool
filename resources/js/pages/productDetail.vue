<template>
    <section class="bg-white shadow-5 pb-1">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb py-3">
                    <li class="breadcrumb-item fs-12 letter-spacing-087"> <router-link to="/">Home</router-link> </li>
                    <li class="breadcrumb-item fs-12 letter-spacing-087 active">{{product.title || ''}}</li>
                </ol>
            </nav>

            <div class="px-3 px-lg-6" data-animated-id="1">
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
                                                            <vue-label for="title" class="text-heading" text="Title"/>
                                                            <vue-input type="text" id="title" name="title" :apiError="errors.name || []" placeholder="Title" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 invoice-address-company">
                                                    <div class="invoice-address-company-fields">
                                                        <div class="form-group">
                                                            <vue-label for="title" class="text-heading" text="Title"/>
                                                            <vue-input type="text" id="title" name="title" :apiError="errors.name || []" placeholder="Title" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 invoice-address-company">
                                                    <div class="invoice-address-company-fields">
                                                        <div class="form-group">
                                                            <vue-label for="feedback_category_id" class="text-heading" text="Email"/>
                                                            <vue-select  id="feedback_category_id" name="feedback_category_id" :options="categories" :apiError="errors.feedback_category_id || []" v-model="user.feedback_category_id" />
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
        </div>
</section>
</template>

<script>
    import axios from "axios";
    import vueInput from '../components/vueInput.vue';
    import vueLabel from '../components/vueLabel.vue';
    import vueSelect from '../components/vueSelect.vue';
    import { Form } from 'vee-validate';
    import * as yup from 'yup';
    
    export default {
        data(){
            return {
                slug:this.$route.params.slug,
                product:{},
                user:{
                    email:'',
                    name:'',
                    id:'',
                },
                validatonsErrors:{},
                categories: [
                    { value: 'option1', label: 'Option 1' },
                    { value: 'option2', label: 'Option 2' },
                    { value: 'option3', label: 'Option 3' },
                ],
            }
        },
        mounted(){
            // get detail of product  on mounted
            this.getProductDetail();
        },
        methods:{
            // get list of products using api request call
            async getProductDetail(){
                const response = await axios.get(`http://127.0.0.1:8000/api/products/${this.slug}/detail`);
                if(response.data.success){
                    this.product = response.data.data;
                }
               
            },
            async submitForm(){
                const response = await axios.post('http://127.0.0.1:8000/api/user/profile',this.user);
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
                    this.validatonsErrors = [];
                    this.$store.commit('setUser',response.data.data);
                    this.$swal(response.data.message);
                }
            }
        },
        computed: {
            schema(){
                return yup.object().shape({
                    name: yup.string().required(),
                    email: yup.string().email().required(),
                });
            },
            errors() {
                return this.validatonsErrors; // Computed property to access the server response
            },
        },
        components:{
            vueInput,
            vueLabel,
            vueSelect,
            Form,
        },
        
    
    }
</script>