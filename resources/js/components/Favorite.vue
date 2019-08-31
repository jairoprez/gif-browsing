<template>
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4">Favorite</h1>
        
        <hr>

        <div class="row">
            <div class="col-3 gif-item" v-for="(image, index) in images">
                <img v-lazy="image.thumb" @click="openGallery(index)">
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
                images: []
            }
        },

        mounted() {
            axios.get('/api/v1/gif/favorite').then(response => {
                response.data.data.forEach((gif) => { 
                    this.images.push({
                        thumb: gif.images.fixed_height_small_still.url,
                        src: gif.images.original.url,
                    }); 
                });
            }); 
        },

        methods: {
            openGallery(index) {
                this.$refs.lightbox.showImage(index)
            }
        },

        beforeRouteEnter (to, from, next) { 
            if ( ! localStorage.getItem('jwt')) {
                return next({ name: 'login' });
            }

            next()
        }
    };
</script>