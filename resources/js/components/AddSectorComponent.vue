<template>
    <div class="container-fluid add-project">
        <h3 v-if="sector.length === 0">Add Sector</h3>
        <h3 v-else>Edit Sector</h3>
        <form @submit="checkForm">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Sector Name</label>
                    <input class="project-text" type="text" placeholder="Enter sector name" v-model="data.name">
                </div>
            </div>
            <input v-if="sector.length === 0" type="submit" value="Save" class="btn btn-primary submit">
            <input v-else type="submit" value="Update" class="btn btn-primary submit">
        </form>
        <FlashMessage :position="'right top'"></FlashMessage>
    </div>
</template>

<script>
export default {
    props: ['sector', 'user'],
    data() {
        return {
            file: null,
            sectorData: null,
            data: [],
            errors: []
        }
    },
    methods: {
        checkForm(e) {
            if (this.data.name) {
                this.saveSector()
            }

            this.errors = [];

            if (!this.data.name) {
                this.flashError('Sector Name required');
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
        saveSector() {
            let formData = this.createFormData();
            console.log(formData);
            axios.defaults.headers.common['Content-Type'] = 'multipart/form-data'
            if (this.data.id) {
                axios.post('/api/update-sector/' + this.data.id, formData)
                    .then((response) => {
                        this.flashMessage.success({
                            message: 'Sector successfully updated',
                            time: 5000,
                            blockClass: 'custom-block-class'
                        });
                        location.replace("/admin/sectors");
                    }).catch((error) => {
                    console.log(error);
                });
            } else {
                axios.post('/api/save-sector', formData)
                    .then((response) => {
                        // console.log('R', response);
                        this.flashMessage.success({
                            message: 'Sector successfully saved',
                            time: 5000,
                            blockClass: 'custom-block-class'
                        });
                        location.replace("/admin/sectors");
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
        this.data = this.sector
    }
}
</script>

