<template>


    <section class="bg-white shadow-5 pb-1">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb py-3">
                    <li class="breadcrumb-item fs-12 letter-spacing-087"> <router-link to="/">Home </router-link> </li>
                    <li class="breadcrumb-item fs-12 letter-spacing-087 active">{{product.title || ''}} </li>
                </ol>
            </nav>

            <!-- <div class="px-3 px-lg-6" data-animated-id="1" v-if="isAuthenticated && "> -->
            <!-- <div class="px-3 px-lg-6" data-animated-id="1" v-if="isAuthenticated && isAbleToFeedback"> -->
            <div class="px-3 px-lg-6" data-animated-id="1">
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

            <div class="px-3 px-lg-6" data-animated-id="1" v-if="feedbacks.length>0">
                <div class="mb-6"> <h2 class="mb-0 text-heading fs-22 lh-15">Feedbacks</h2> </div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="row">
                            <div class="col-xl-12 mb-6 mb-xl-0">
                                <div class="card">
                                    <div class="card-body p-5">
                                        <div class="row">
                                            <div class="container__  col-lg-12" v-for="(feedback,index) in feedbacks" :key="index">
                                                <img src="/images/avatar.jpeg" alt="Ronald Hunter" class="rounded-circle user-image">
                                                <div class="d-flex flex-direction-column">
                                                    <span>{{feedback.user.name}}</span>
                                                    <p><span>{{feedback.title}}</span> {{feedback.category.title}}</p>
                                                </div>
                                                <p>{{feedback.description}}</p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="date-time">{{feedback.created_at}}</span>
                                                    <div class="d-flex w-100 align-items-end justify-content-end">
                                                        <div class="d-flex flex-direction-column align-items-baseline">
                                                            <i class="fas fa-angle-up f-24 text-bold" @click="feedbackVote(feedback,1)"></i>
                                                            <span :id="'feedbackVotes'+feedback.id">{{ feedback.total_votes!=null?feedback.total_votes:0 }}</span>
                                                            <i class="fas fa-angle-down f-24 text-bold" @click="feedbackVote(feedback,-1)" :disabled="isAbleToVote(feedback)"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button class="btn btn-primary btn-sm mb-2" v-if="feedback.comments.length>0" @click="toggleCommentsVisibility(index)">{{ showComments[index] ? 'Hide Comments' : 'Show Comments' }}</button>
                                                </div>
                                                <div class="card p-3" v-if="showComments[index]" style="border:1px solid #eee;" >
                                                    <div :id="'feedback'+feedback.id+'comments'">
                                                        <div class="container__  col-lg-12" v-for="(comment ,index) in feedback.comments" :key="index">
                                                            <img src="/images/avatar.jpeg" alt="Ronald Hunter" class="rounded-circle user-image">
                                                            <p>{{ comment.user.name }}</p>
                                                            <p>{{comment.comment}}</p>
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <span class="date-time">{{comment.created_at}}</span>
                                                            </div>
                                                        </div>
                                                    </div>  
                                                </div>
                                                <div class="input-group mb-3 mt-3" v-if="isAuthenticated">
                                                    <input type="text" :id="'commentField'+feedback.id" class="form-control h-40" placeholder="Comment here">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary h-40" type="button" @click="addCommnent(feedback.id)">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                                                                <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"></path>
                                                            </svg>
                                                        </button>
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
    .flex-direction-column{
        flex-direction: column;
    }
    .f-24{ font-size: 24px;}
    .date-time{ font-size: 14px; width: 100px; white-space: nowrap;}
    .card{border: none;}
    .container__{border: 1px solid #eee;background-color: #fff;}
</style>

<script>
    import axios from '../config/axios';
    import vueInput from '../components/vueInput.vue';
    import vueLabel from '../components/vueLabel.vue';
    import vueSelect from '../components/vueSelect.vue';
    import vueTextarea from '../components/vueTextarea.vue';
    import { Form } from 'vee-validate';
    import * as yup from 'yup';
    import Echo from 'laravel-echo';
    import Pusher from 'pusher-js';
    var pusher = new Pusher('52ee5f73df2414959072', {
      cluster: 'mt1'
    });
    
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
                feedbacksList: [],
                showComments: []
            }
        },
        mounted(){
            // get detail of product  on mounted
            this.getProductDetail();
            this.showComments = Array(this.feedbacksList.length).fill(false);
            console.clear();
        },
        methods:{
            //add comment
            async addCommnent(feedback_id){
                const targetElem = `commentField${feedback_id}`;
                const comment = document.getElementById(targetElem).value;
                const response = await axios.post('comments/store',{feedback_id:feedback_id,user_id:this.$store.state.user.id,comment:comment});
                console.log('ss',response.data.data.success);
                if(response.data.success){
                    const findIndexOfFeedback = this.feedbacksList.findIndex(item => item.id === feedback_id)
                    const feedback = this.feedbacksList[findIndexOfFeedback];
                    console.log("feedback",feedback);
                    let comments = feedback.comments;
                    console.log('comments before',comments);
                    comments = comments.push(response.data.data);
                    console.log("after",comments);
                    console.log("comment",comment);
                    feedback.comments = comments;
                    console.log(comments);
                    this.feedbacksList[findIndexOfFeedback] = feedback;
                }
            },
            // show and hide comments section of feedback
            toggleCommentsVisibility(index) {
                this.showComments[index] = !this.showComments[index]; // Toggle comments visibility for the feedback at the specified index
            },
            // add feedback vote
            async feedbackVote(feedback,vote){
                if(this.isAbleToVote(feedback)){
                    const response = await axios.post(`add/feedback/vote`,{feedback_id:feedback.id,vote:vote,user_id:this.$store.state.user.id});
                    if(response.data.success){
                        document.getElementById('feedbackVotes'+feedback.id).innerHTML =response.data.data.total_votes;
                    }
                }
            },
            // get list of products using api request call
            async getProductDetail(){
                const response = await axios.get(`products/${this.slug}/detail`);
                if(response.data.success){
                    this.product = response.data.data.product;
                    this.feedbackCategories = response.data.data.feedbackCategories;
                    this.feedbacksList = this.product.feedbacks;
                    this.commentListen();
                    this.feedbackListen();
                }
               
            },
            
            onFileChange(event) {
                this.feedback.files = Array.from(event.target.files);
            },
            feedbackListen(){
                var feedback = pusher.subscribe('product-'+this.product.id);
                feedback.bind('NewFeedback', function(data) {
                    if(typeof(this.feedbacksList) !="undefined"){
                        const feedbackExists = this.feedbacksList.some(obj => obj.id === data.feedback.id);
                        if (!feedbackExists) {
                            this.feedbacksList.unshift(data.feedback);
                        }
                    }
                }.bind(this));
            },
            commentListen(){
                var comment = pusher.subscribe('feedback-'+this.product.id+'-comments');
                comment.bind('feedback-new-comment', function(data) {
                    console.log("this is new comment",data);
                }.bind(this));
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

                const response = await axios.post('feedbacks/store',formData);
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
                }
            },
            isAbleToVote(feedback){
                return feedback.user_ids!=null? feedback.user_ids.split(',').includes(this.$store.state.user.id):true;
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
            },
           
            isAbleToFeedback(){
                return (this.product && this.product.feedback_user_ids && !this.product.feedback_user_ids.includes(this.$store.state.user.id));
            },
            feedbacks(){
                return this.feedbacksList;
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