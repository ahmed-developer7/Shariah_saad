<template>
    <div class="container-fluid add-project">
        <h3 v-if="employee.length === 0">Add Employee</h3>
        <h3 v-else>Edit Employee</h3>
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
                    <label>Short Name</label>
                    <input class="project-text" type="text" placeholder="Enter short name" v-model="data.short_name">
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Description</label>
                    <input class="project-text" type="text" placeholder="Enter description" v-model="data.description">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Picture</label>
                    <input class="project-text" type="file" @change="uploadPicture" ref="file">
                </div>
            </div>
            <input v-if="employee.length === 0" type="submit" value="Save" class="btn btn-primary submit">
            <input v-else type="submit" value="Update" class="btn btn-primary submit">
        </form>
        <FlashMessage :position="'right top'"></FlashMessage>
    </div>
</template>

<script>

export default {
    props: ['employee', 'user'],
    data() {
        return {
            data: [],
            errors: []
        }
    },
    methods: {
        checkForm(e) {
            if (this.data.first_name && this.data.last_name && this.data.short_name && this.data.picture &&
                this.data.description && this.data.first_name_ar && this.data.last_name_ar) {
                this.saveEmployee()
            }

            this.errors = [];

            if (!this.data.first_name) {
                this.flashError('First Name required');
            }
            if (!this.data.last_name) {
                this.flashError('Last Name required');
            }
            if (!this.data.short_name) {
                this.flashError('Short Name required');
            }
            if (!this.data.description) {
                this.flashError('Description required');
            }
            if (!this.data.picture) {
                this.flashError('Picture required');
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
        saveEmployee() {
            let formData = this.createFormData();
            axios.defaults.headers.common['Content-Type'] = 'multipart/form-data'
            if (this.data.id) {
                axios.post('/api/update-employee/' + this.data.id, formData)
                    .then((response) => {
                        this.flashMessage.success({
                            message: 'Employee successfully updated',
                            time: 5000,
                            blockClass: 'custom-block-class'
                        });
                        location.replace("/admin/employees");
                    }).catch((error) => {
                    console.log(error);
                })
            } else {
                axios.post('/api/save-employee', formData)
                    .then((response) => {
                        this.flashMessage.success({
                            message: 'Employee successfully saved',
                            time: 5000,
                            blockClass: 'custom-block-class'
                        });
                        location.replace("/admin/employees");
                    }).catch((error) => {
                    console.log(error);
                })
            }
        },
        createFormData() {
            const formData = new FormData();
            formData.append('first_name', this.data.first_name);
            formData.append('last_name', this.data.last_name);
            formData.append('short_name', this.data.short_name);
            formData.append('picture', this.data.picture);
            formData.append('description', this.data.description);
            formData.append('user_id', this.user.id);
            formData.append('first_name_ar', this.data.first_name_ar);
            formData.append('last_name_ar', this.data.last_name_ar);
            return formData;
        },
        uploadPicture() {
            this.data.picture = this.$refs.file.files[0];
        }
    },
    mounted() {
        this.flashMessage.setStrategy('multiple');
        this.data = this.employee;
    }
}
</script>
