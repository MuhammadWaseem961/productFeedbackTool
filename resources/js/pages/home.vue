<template>
    <div class="container">
        <div class="row">
            <div class="card col-md-3 col-lg-3 col-sm-4 col-xs-12 m-2" style="width: 18rem;" v-for="product in productsList" :key="product.id">
                <img class="card-img-top" :src="product.image" :alt="product.title" style="height: 248px;object-fit: cover;object-position: center;">
                <div class="card-body">
                    <h5 class="card-title">{{product.title}}</h5>
                    <p class="card-text">{{ product.summary }}</p>
                    <router-link :to="{ path: '/product/'+product.slug+'/detail', params: { product: product } }" class="btn btn-primary">Detail</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios";
    
    export default {
        data(){
            return {
                productsList:[],
            }
        },
        mounted(){
            // get list of products on mounted
            this.getListOfProducts();
        },
        methods:{
            // get list of products using api request call
            async getListOfProducts(){
                try {
                    const response = await axios.get('http://127.0.0.1:8000/api/products');
                    if(response.status==200){
                        this.productsList = response.data.data;
                    }
                } catch (error) {
                    console.error('Error fetching products:', error);
                }
               
            }
        },
    
    }
</script>