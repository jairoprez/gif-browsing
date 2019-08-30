<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>GIF Browsing App</title>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <link rel="stylesheet" href="/css/app.css">
    </head>
    <body>
        <div id="app" class="container">
            <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm" v-if="isLoggedIn">
                <h5 class="my-0 mr-md-auto font-weight-normal">GIF Browsing App</h5>
                <nav class="my-2 my-md-0 mr-md-3">
                    <router-link class="p-2 text-dark" :to="{ name: 'home' }" exact>Home</router-link>
                    <router-link class="p-2 text-dark" :to="{ name: 'history' }">History</router-link>
                    <router-link class="p-2 text-dark" :to="{ name: 'favorite' }">Favorites</router-link>
                </nav>

                <div class="dropdown">
                    <a class="btn  btn-outline-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Hi, @{{name}}
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="#" @click="logout">Log Out</a>
                    </div>
                </div>
            </div>
            
            <router-view></router-view>
        </div>

        <script type="text/javascript" src="/js/app.js"></script>
    </body>
</html>
