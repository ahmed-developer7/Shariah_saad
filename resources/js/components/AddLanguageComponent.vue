<template>
    <div class="container-fluid add-project">
        <h3 v-if="language.length === 0">Add Language</h3>
        <h3 v-else>Edit Language</h3>
        <form @submit="checkForm">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Language</label>
                    <input class="project-text" type="text" placeholder="Enter language" v-model="data.name">
                </div>
            </div>
            <input v-if="language.length === 0" type="submit" value="Save" class="btn btn-primary submit">
            <input v-else type="submit" value="Update" class="btn btn-primary submit">
        </form>
        <FlashMessage :position="'right top'"></FlashMessage>
    </div>
</template>

<script>
export default {
    props: ['language', 'user'],
    data() {
        return {
            file: null,
            languageData: null,
            data: [],
            errors: []
        }
    },
    methods: {
        checkForm(e) {
            if (this.data.name) {
                this.saveLanguage()
            }

            this.errors = [];

            if (!this.data.name) {
                this.flashError('Language required');
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
        saveLanguage() {
            let formData = this.createFormData();
            console.log(formData);
            axios.defaults.headers.common['Content-Type'] = 'multipart/form-data'
            if (this.data.id) {
                axios.post('/api/update-language/' + this.data.id, formData)
                    .then((response) => {
                        this.flashMessage.success({
                            message: 'language successfully updated',
                            time: 5000,
                            blockClass: 'custom-block-class'
                        });
                        location.replace("/admin/languages");
                    }).catch((error) => {
                    console.log(error);
                });
            } else {
                axios.post('/api/save-language', formData)
                    .then((response) => {
                        // console.log('R', response);
                        this.flashMessage.success({
                            message: 'language successfully saved',
                            time: 5000,
                            blockClass: 'custom-block-class'
                        });
                        location.replace("/admin/languages");
                    }).catch((error) => {
                    console.log(error);
                });
            }
        },
        createFormData() {
            const formData = new FormData();
            formData.append('name', this.data.name ? this.data.name : '');
            formData.append('user_id', this.user.id);
            return formData;
        },
    },
    mounted() {
        // this.getCompanyData();
        this.flashMessage.setStrategy('multiple');
        this.data = this.language
    }
}
</script>

