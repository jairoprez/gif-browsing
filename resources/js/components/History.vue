<template>
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4">History</h1>
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Searched String</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="search in searchHistory">
                    <td>{{ search.keyword }}</td>
                    <td>{{ search.created_at }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                searchHistory: []
            }
        },

        mounted() {
            axios.get('/api/v1/search/history').then(response => this.searchHistory = response.data); 
        },

        beforeRouteEnter (to, from, next) { 
            if ( ! localStorage.getItem('jwt')) {
                return next('login')
            }

            next()
        }    
    };
</script>