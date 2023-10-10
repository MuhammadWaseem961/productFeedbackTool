<template>
    <section class="bg-white shadow-5 pb-1">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb py-3">
                    <li class="breadcrumb-item fs-12 letter-spacing-087"> <router-link to="/">Home </router-link> </li>
                    <li class="breadcrumb-item fs-12 letter-spacing-087 active">{{product.title || ''}} </li>
                </ol>
            </nav>

            <div class="px-3 px-lg-6" data-animated-id="1" v-if="isAuthenticated">
                <div class="mb-6"> <h2 class="mb-0 text-heading fs-22 lh-15">Add Feedback</h2> </div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="row">
                            <div class="col-xl-12 mb-6 mb-xl-0">
                                <div class="card">
                                    <div class="card-body p-6">
                                        <Form @submit="submitForm" :validation-schema="schema" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-md-6 invoice-address-company">
                                                    <div class="invoice-address-company-fields">
                                                        <div class="form-group">
                                                            <vue-label for="title" class="text-heading" text="Title"/>
                                                            <vue-input type="text" id="title" name="title" :apiError="errors.title || []" v-model="feedback.title" placeholder="Title" />
                                                        </div>
                                                    </div>
                                                </div>

                                                
                                                <div class="col-md-6 invoice-address-company">
                                                    <div class="invoice-address-company-fields">
                                                        <div class="form-group">
                                                            <vue-label for="feedback_category_id" class="text-heading" text="Category"/>
                                                            <vue-select  id="feedback_category_id"  v-model="feedback.feedback_category_id" name="feedback_category_id" :options="feedbackCategories" :apiError="errors.feedback_category_id || []" />
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6 invoice-address-company">
                                                    <div class="invoice-address-company-fields">
                                                        <div class="form-group">
                                                            <vue-label for="description" class="text-heading" text="Description"/>
                                                            <vue-textarea  id="description"  v-model="feedback.description" name="description" :apiError="errors.description || []" placeholder="Description" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 invoice-address-company">
                                                    <div class="invoice-address-company-fields">
                                                        <div class="form-group">
                                                            <vue-label for="file" class="text-heading" text="Screenshosts/Files"/>
                                                            <input type="file" class="form-control" @change="onFileChange" multiple />
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

            <div class="px-3 px-lg-6" data-animated-id="1" v-if="isAuthenticated">
                <div class="mb-6"> <h2 class="mb-0 text-heading fs-22 lh-15">Add Feedback</h2> </div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="row">
                            <div class="col-xl-12 mb-6 mb-xl-0">
                                <div class="card">
                                    <div class="card-body p-6">
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" v-for="feedback in feedbacks" :key="feedback.id">
                                                <div>{{feedback.title}}</div>
                                            </div>
                                        </div>
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
    import vueTextarea from '../components/vueTextarea.vue';
    import { Form } from 'vee-validate';
    import * as yup from 'yup';
    
    export default {
        data(){
            return {
                slug:this.$route.params.slug,
                product:{},
                feedback:{
                    title:'',
                    user_id:this.$store.state.user.id,
                    feedback_category_id:'',
                    product_id:'',
                    description:'',
                    files:[],
                },
                validatonsErrors:{},
                feedbackCategories: [],
                feedbacks: [],
            }
        },
        mounted(){
            // get detail of product  on mounted
            this.getProductDetail();
            console.clear();
        },
        methods:{
            // get list of products using api request call
            async getProductDetail(){
                const response = await axios.get(`http://127.0.0.1:8000/api/products/${this.slug}/detail`);
                if(response.data.success){
                    this.product = response.data.data.product;
                    this.feedbackCategories = response.data.data.feedbackCategories;
                    this.feedbacks = this.product.feedbacks;
                }
               
            },
            
            onFileChange(event) {
                this.feedback.files = Array.from(event.target.files);
            },
            listen(){
                Echo.channel('product.'+this.product.id)
                .listen('NewFeedback',(feedback)=>{
                    this.feedbacks.unshift(feedback);
                });
            },
            async submitForm(){
                let formData = new FormData();
                formData.append('title',this.feedback.title);
                formData.append('feedback_category_id',this.feedback.feedback_category_id);
                formData.append('description',this.feedback.description);
                formData.append('product_id',this.product.id);
                formData.append('user_id',this.feedback.user_id);
                this.feedback.files.forEach((file) => {
                    formData.append('files[]', file);
                });

                const response = await axios.post(this.$store.state.apiUrl+'feedbacks/store',formData);
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
                    this.$swal(response.data.message);
                    this.feedbacks.unshift(response.data.data);
                }
            },
        },
        computed: {
            schema(){
                return yup.object().shape({
                    title: yup.string().required(),
                    description: yup.string().required(),
                    feedback_category_id: yup.string().required("Category field is required"),
                });
            },
            errors() {
                return this.validatonsErrors; // Computed property to access the server response
            },
            isAuthenticated(){
                // return this.$store.state.user!=null && (parseInt(new Date()/1000) < this.$store.state.user.expire_at) && (this.product.userIDs.length>0 && !this.product.userIDs.includes(this.$store.state.user.id));
                return this.$store.state.user!=null && (parseInt(new Date()/1000) < this.$store.state.user.expire_at);
            }
        },
        components:{
            vueInput,
            vueLabel,
            vueSelect,
            vueTextarea,
            Form,
        },
        
    
    }
</script>