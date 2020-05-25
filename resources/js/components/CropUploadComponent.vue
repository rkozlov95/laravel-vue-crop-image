<template>
    <div class="p-3 bg-white shadow rounded-lg">
        <input type="file" name="image" accept="image/*" @change="setImage" data-toggle="modal" data-target="#exampleModal"/>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Предварительный просмотр изображения</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div v-if="this.imageSrc" class="my-3 d-flex align-items-center justify-content-center mx-auto">
                            <vue-cropper class="mr-2 w-50" ref='cropper' :guides="true" :src="imageSrc"></vue-cropper>
                            <img class="ml-2 w-50 bg-light" :src="croppedImageSrc"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button v-if="this.imageSrc" @click="cropImage">Выбрать область</button>
                        <button v-if="this.croppedImageSrc" @click="uploadImage" data-dismiss="modal">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import VueCropper from 'vue-cropperjs';
    import 'cropperjs/dist/cropper.css';

    export default {
        components: {
            VueCropper
        },
        data: function() {
            return {
                imageSrc: "",
                croppedImageSrc: ""
            }
        },
        methods: {
            setImage: function (e) {
                const file = e.target.files[0];
                console.log(file.size);
                if (file.size > 30000000) {
                    alert('Размер файла превышает 30 МБ!');
                    return;
                }

                if (!file.type.includes('image/')) {
                    alert('Этот формат файла не поддерживается!');
                    return;
                }
                if (typeof FileReader === 'function') {
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        this.imageSrc = event.target.result;
                        this.$refs.cropper.replace(event.target.result);
                    };
                    reader.readAsDataURL(file);
                } else {
                    alert('FileReader не поддерживается вашим браузером!');
                }
            },
            cropImage() {
                this.croppedImageSrc = this.$refs.cropper.getCroppedCanvas().toDataURL();
            },
            uploadImage() {
                this.$refs.cropper.getCroppedCanvas().toBlob(function (blob) {
                    let formData = new FormData();

                    formData.append('name', "image-name-"+(new Date()).getTime());

                    formData.append('file', blob);

                    axios.post(
                        '/api/store', formData
                    ).then(response => {
                        console.log(response.data);
                    }).catch(function (error) {
                        console.log(error);
                    });
                });
            }
        }
    }
</script>
