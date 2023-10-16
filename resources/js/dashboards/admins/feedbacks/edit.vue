<template>
    <div class="px-3 px-lg-6 px-xxl-131 py-5 py-lg-10 add-new-invoice" data-animated-id="1">
        <div class="mb-6"> <h2 class="mb-0 text-heading fs-22 lh-15">Feedbacks</h2> </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="row">
                    <div class="col-xl-12 mb-6 mb-xl-0">
                        <div class="card">
                            <div class="card-body p-6">
                                <div class="table-responsive pb-4">
                                    <DataTable :data='feedbacks' class="table data__table table-hover bg-white border rounded-lg">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Username</th>
                                                <th>Product</th>
                                                <th>Title</th>
                                                <th>Category</th>
                                                <th>Total Votes</th>
                                                <th>Votes Sum</th>
                                                <th>Actions</th>

                                            </tr>
                                        </thead>

                                    </DataTable>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
</template>

<style>
    .dataTables_wrapper:nth-child(1).col-md-6{
        /* display: flex;
        justify-content: end; */
        background-color: red;
    }

</style>

<script>
    import axios from '../../../config/axios';
    import DataTable from "datatables.net-vue3";
    import DataTableLib from "datatables.net-bs5";
    import ButtonsHtml5 from "datatables.net-buttons-bs5";
    import "datatables.net-responsive-bs5";
    DataTable.use(DataTableLib);
    DataTable.use(ButtonsHtml5);

    export default {
        data(){
            return {
                feedbacksList:[]
            }
        },
        mounted(){
            this.getListOfUserFeedbacks();
        },
        components:{
            DataTable
        },
        methods: {
            async getListOfUserFeedbacks(){
                const response = await axios.get('admin/feedbacks');
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
                else if(response.data.success){
                    this.feedbacksList = response.data.data;
                }
            }
        },
        computed:{
            feedbacks(){
                if(this.feedbacksList.length>0){
                    let items = [];
                    this.feedbacksList.forEach((item,index)=>{
                        items.push([
                            ++index,item.user.name,item.product.title,item.title
                            ,item.category.title,item.votes_count,item.total_votes!=null?item.total_votes:0,
                            `<router-link class="btn btn-sm btn-primary" to='feedbacls/${item.id}/edit' ><i class="fas fa-edit"></i></router-link>
                            <router-link class="btn btn-sm btn-danger" to='#' type="button" ><i class="fas fa-trash"></i></router-link>
                            `
                        ]);
                    });
                    return items;
                }
                return [];
            }
        }
        
    }
</script>