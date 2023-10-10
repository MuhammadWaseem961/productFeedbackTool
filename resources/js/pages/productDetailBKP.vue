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
                <div class="mb-6"> <h2 class="mb-0 text-heading fs-22 lh-15">Feedbacks</h2> </div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="row">
                            <div class="col-xl-12 mb-6 mb-xl-0">
                                <div class="card">
                                    <div class="card-body p-6">
                                        <div class="row">
                                                <DataTable class="w-100" :options="{select: true}">
                                                    <tbody>
                                                        <tr v-for="feedback in feedbacks" :key="feedback.id">
                                                            <td>
                                                                <div class="container__  col-lg-12" >
                                                                    <img src="/images/avatar.jpeg" alt="Ronald Hunter" class="rounded-circle user-image">
                                                                    <p><span>{{feedback.title}}</span> {{feedback.category.title}}</p>
                                                                    <p>{{feedback.description}}</p>
                                                                    <span>{{feedback.created_at}}</span>
                                                                    <div class="d-flex w-100 align-items-end justify-content-end">
                                                                        <button class="btn btn-primary d-flex align-items-center btn-sm">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up-circle" viewBox="0 0 16 16">
                                                                                <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z"></path>
                                                                            </svg> &nbsp;
                                                                            <span>6</span>
                                                                        </button>
                                                                        <button class="btn btn-primary ml-1 d-flex align-items-center btn-sm"> 
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-circle" viewBox="0 0 16 16">
                                                                                <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"></path>
                                                                            </svg> &nbsp;
                                                                            <span>5</span>
                                                                        </button>
                                                                    </div>

                                                                    <div class="container__  col-lg-12" >
                                                                        <img src="/images/avatar.jpeg" alt="Ronald Hunter" class="rounded-circle user-image">
                                                                        <p><span>{{feedback.title}}</span></p>
                                                                        <p>{{feedback.description}}</p>
                                                                        <span>{{feedback.created_at}}</span>
                                                                    </div>

                                                                    <div class="input-group mb-3">
                                                                        <input type="text" class="form-control h-40" placeholder="Comment here">
                                                                        <div class="input-group-append">
                                                                            <button class="btn btn-primary h-40" type="button">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                                                                                    <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"></path>
                                                                                </svg>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                               
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </DataTable >
                                                
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

<style scope>
    .user-image{
        height: 60px !important;
        width: 55px !important;
    }
    .h-40{
        height:40px !important; 
    }
</style>

<script>
    import DataTable from 'datatables.net-vue3'
    import Select from 'datatables.net-select';
    DataTable.use(Select);
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
            DataTable
        },
        
    
    }
</script>