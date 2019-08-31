<template>
    <div class="container login-page">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">GIF Browsing App - Login</div>

                    <div class="card-body">
                        <form method="POST" action="/login" @submit.prevent="onSubmit">
                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" v-model="email" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" v-model="password" required>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Login
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                email : '',
                password : ''
            }
        },
        
        methods: {
            onSubmit() {
               axios.post('/api/v1/auth/login', {
                    email: this.email,
                    password: this.password
                })
                .then(response => {
                    localStorage.setItem('user', response.data.user.name)
                    localStorage.setItem('jwt', response.data.access_token)
                    
                    if (localStorage.getItem('jwt') != null){
                        this.$router.push({ name: 'home' });
                    }
                })
                .catch(error => {
                    console.error(error);
                    this.email = '';
                    this.password = '';
                    alert('The email address or the password is incorrect.');
                });   
            }
        },

        beforeRouteEnter (to, from, next) { 
            if (localStorage.getItem('jwt')) {
                return next({ name: 'home' });
            }

            next();
        }
    }
</script>

<style>
    .login-page {
        margin-top: 50px;
    }
</style>