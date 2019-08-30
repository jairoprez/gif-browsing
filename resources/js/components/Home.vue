<template>
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4">Home</h1>
        
        <form method="post" action="/gif/search" @submit.prevent="onSubmit">
            <div class="form-group">
                <input type="text" class="form-control" id="keyword" v-model="keyword" placeholder="Search all the Gifs">
            </div>
        </form>

        <hr>
        
        <div class="row">
            <div class="col-3 gif-item" v-for="(image, index) in images">
                <img v-lazy="image.thumb" @click="openGallery(index)">
                <br>
                <a href="#" @click="saveAsFavorite(image)">Save as favorite</a>
            </div>
        </div>

        <LightBox :images="images" ref="lightbox" :show-light-box="false"></LightBox>
    </div> 
</template>

<script>
    import LightBox from 'vue-image-lightbox'

    export default {
        components: {
            LightBox
        },

        data() {
            return {
                keyword: '',
                images: []
            }
        },

        methods: {
            onSubmit() {
               axios.get('/api/v1/gif/search', {
                    params: {
                        keyword: this.keyword
                    }
                })
                .then(response => {
                    this.images = [];
                    response.data.data.forEach((gif) => { 
                        this.images.push({
                            thumb: gif.images.fixed_height_small_still.url,
                            src: gif.images.original.url,
                            id: gif.id,
                        }); 
                    });
                });     
            },

            openGallery(index) {
                this.$refs.lightbox.showImage(index)
            },

            saveAsFavorite(selectedGif) {
                axios.post('/api/v1/gif/favorite', {
                    gif_id: selectedGif.id
                })
                .then(response => {
                    console.log(response);
                    alert('Saved as favorite!')
                });
            }
        },

        beforeRouteEnter (to, from, next) { 
            if ( ! localStorage.getItem('jwt')) {
                return next('login')
            }

            next()
        }
    };
</script>

<style>
    .gif-item {
        margin-bottom: 15px;
    }
</style>