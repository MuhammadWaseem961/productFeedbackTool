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
                                    <table class="table data__table table-hover bg-white border rounded-lg">
                                        <thead>
                                            <tr role="row">
                                                <th class="no-sort py-6 pl-6">#</th>
                                                <th class="py-6">Category</th>
                                                <th class="py-6">Author</th>
                                                <th class="py-6">Blog</th>
                                                <th class="py-6">Date</th>
                                                <th class="py-6">Status</th>
                                                <th class="no-sort py-6">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr role="row">
                                                <td class="no-sort py-6 pl-6">#</td>
                                                <td class="py-6">Category</td>
                                                <td class="py-6">Autdor</td>
                                                <td class="py-6">Blog</td>
                                                <td class="py-6">Date</td>
                                                <td class="py-6">Status</td>
                                                <td class="no-sort py-6">Actions</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data(){
            return {
                
            }
        },
        components:{
            
        },
        computed: {
           
        },
        
    }
</script>