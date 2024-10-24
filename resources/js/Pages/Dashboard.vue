<template>
    <div class="container">
        <Header :auth="auth" :csrfToken="csrfToken"></Header>
    
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <span class="me-3" style="font-size: 2rem">&#x1F4C8;</span>
                            <h5 class="card-title mb-0">Транзакции</h5>
                        </div>
                        <p class="card-text mb-2">Просмотр транзакций</p>
                        <Link :href="route('transactions')" class="btn btn-primary">Перейти</Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </template>
    
    <script>
    import { Link } from '@inertiajs/inertia-vue3';
    import Header from '@/Components/Header.vue';  
    
    export default {
        name: 'Dashboard',  
        props: {
            auth: Object,  
            csrfToken: String  
        },
        components: {
            Link,  
            Header  
        }
    }
    </script>
    