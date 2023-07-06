<template>
    <div class="container-fluid add-project">
        <h3 v-if="scholar.length === 0">Add Scholar</h3>
        <h3 v-else>Edit Scholar</h3>
        <form @submit="checkForm">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>First Name</label>
                    <input class="project-text" type="text" placeholder="Enter first name" v-model="data.first_name">
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Last Name</label>
                    <input class="project-text" type="text" placeholder="Enter last name" v-model="data.last_name">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>First Name (In Arabic)</label>
                    <input class="project-text" type="text" placeholder="Enter first name (in arabic)" v-model="data.first_name_ar">
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Last Name (In Arabic)</label>
                    <input class="project-text" type="text" placeholder="Enter last name (in arabic)" v-model="data.last_name_ar">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Email</label>
                    <input class="project-text" type="text" placeholder="Enter email" v-model="data.email">
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Signature</label>
                    <input class="project-text" type="file" @change="uploadPicture" ref="file" style="padding-left: 0">
                    <template v-if="data.picture && (typeof data.picture === 'string' || data.picture instanceof String)">
                        <img style="border: 1px solid grey; width: 100px; padding: 5px" :src="'/uploads/' + data.picture">
                        <div @click="data.picture = ''" style="top: 452px; position: absolute; cursor: pointer; right: 680px;">
                            <i data-feather="x"></i>
                        </div>
                    </template>
                </div>
            </div>
            <input v-if="scholar.length === 0" type="submit" value="Save" class="btn btn-primary submit">
            <input v-else type="submit" value="Update" class="btn btn-primary submit">
        </form>
        <FlashMessage :position="'right top'"></FlashMessage>
    </div>
</template>

<script>
export default {
    props: ['scholar', 'user'],
    data() {
        return {
            file: null,
            scholarData: null,
            data: [],
            errors: []
        }
    },
    methods: {
        checkForm(e) {
            if (this.data.first_name && this.data.last_name && this.data.email && this.data.first_name_ar && this.data.last_name_ar) {
                this.saveScholar()
            }

            this.errors = [];

            if (!this.data.first_name) {
                this.flashError('First Name required');
            }
            if (!this.data.last_name) {
                this.flashError('Last Name required');
            }
            if (!this.data.email) {
                this.flashError('Email required');
            }
            if (!this.data.first_name_ar) {
                this.flashError('First Name (In Arabic) required');
            }
            if (!this.data.last_name_ar) {
                this.flashError('Last Name (In Arabic) required');
            }
            e.preventDefault();
        },
        flashError(message) {
            this.flashMessage.error({
                message: message,
                time: 10000,
                blockClass: 'custom-block-class'
            });
        },
        saveScholar() {
            let formData = this.createFormData();
            axios.defaults.headers.common['Content-Type'] = 'multipart/form-data'
            if (this.data.id) {
                axios.post('/api/update-scholar/' + this.data.id, formData)
                    .then((response) => {
                        this.flashMessage.success({
                            message: 'scholar successfully updated',
                            time: 5000,
                            blockClass: 'custom-block-class'
                        });
                        location.replace("/admin/scholars");
                    }).catch((error) => {
                    console.log(error);
                });
            } else {
                axios.post('/api/save-scholar', formData)
                    .then((response) => {
                        // console.log('R', response);
                        this.flashMessage.success({
                            message: 'scholar successfully saved',
                            time: 5000,
                            blockClass: 'custom-block-class'
                        });
                        location.replace("/admin/scholars");
                    }).catch((error) => {
                    console.log(error);
                });
            }
        },
        createFormData() {
            const formData = new FormData();
            formData.append('first_name', this.data.first_name ? this.data.first_name : '');
            formData.append('last_name', this.data.last_name ? this.data.last_name : '');
            formData.append('picture', this.data.picture ? this.data.picture : '');
            formData.append('user_id', this.user.id);
            formData.append('email', this.data.email);
            formData.append('first_name_ar', this.data.first_name_ar);
            formData.append('last_name_ar', this.data.last_name_ar);
            return formData;
        },
        uploadPicture() {
            this.data.picture = this.$refs.file.files[0];
        }
    },
    mounted() {
        // this.getCompanyData();
        this.flashMessage.setStrategy('multiple');
        this.data = this.scholar
    }
}
</script>

