<template>
    <div class="container-fluid add-project">
        <h3 v-if="user.length === 0">Add User</h3>
        <h3 v-else>Edit User</h3>
        <form @submit="checkForm">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Name</label>
                    <input class="project-text" type="text" placeholder="Enter name" v-model="data.name">
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>User Type</label>
                    <v-select placeholder="Select user type" :options="['Super Admin', 'SAM']"
                              v-model="data.usertype" :disabled="currentUser.usertype == 'SAM'"></v-select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Email</label>
                    <input class="project-text" type="text" placeholder="Enter email" v-model="data.email">
                </div>
                <div v-if="user.length === 0" class="col-lg-6 col-md-6 col-sm-12">
                    <label>Password</label>
                    <input class="project-text" type="text" placeholder="Enter password" v-model="data.password">
                </div>
                <div v-else class="col-lg-6 col-md-6 col-sm-12">
                    <label>Password</label>
                    <input class="project-text" type="text" placeholder="Enter password" value="-" readonly>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Sectors</label>
                    <v-select v-if="projectData && projectData.sectors && sectors" multiple placeholder="Select sectors"
                              :options="sectors" v-model="data.sectors" label="name" :reduce="referrer => referrer.id"
                              :disabled="currentUser.usertype == 'SAM'" @input="selectAll" ref="select" :closeOnSelect="false"></v-select>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Description</label>
                    <textarea class="project-text" placeholder="Enter description" rows="4" cols="50"
                              v-model="data.description"></textarea>
                </div>
            </div>
            <input v-if="user.length === 0" type="submit" value="Save" class="btn btn-primary submit">
            <input v-else type="submit" value="Update" class="btn btn-primary submit">
        </form>
        <FlashMessage :position="'right top'"></FlashMessage>
    </div>
</template>

<script>

export default {
    props: ['user', 'currentUser'],
    data() {
        return {
            data: [],
            errors: [],
            projectData: [],
            sectors: []
        }
    },
    methods: {
        checkForm(e) {
            if (this.data.name && this.data.email && this.data.password && this.data.usertype && this.data.description) {
                this.saveUser()
            }

            this.errors = [];

            if (!this.data.name) {
                this.flashError('Name required');
            }
            if (!this.data.email) {
                this.flashError('Email required');
            }
            if (!this.data.password) {
                this.flashError('Password required');
            }
            if (!this.data.usertype) {
                this.flashError('User Type required');
            }
            if (!this.data.description) {
                this.flashError('Description required');
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
        saveUser() {
            let formData = this.createFormData();
            axios.defaults.headers.common['Content-Type'] = 'multipart/form-data'
            if (this.data.id) {
                axios.post('/api/update-user/' + this.data.id, formData)
                    .then((response) => {
                        this.flashMessage.success({
                            message: 'User successfully updated',
                            time: 5000,
                            blockClass: 'custom-block-class'
                        });
                        if (this.currentUser.usertype == 'SAM') {
                            location.replace("/admin");
                        } else {
                            location.replace("/admin/users");
                        }
                    }).catch((error) => {
                    console.log(error);
                })
            } else {
                axios.post('/api/save-user', formData)
                    .then((response) => {
                        this.flashMessage.success({
                            message: 'User successfully saved',
                            time: 5000,
                            blockClass: 'custom-block-class'
                        });
                        location.replace("/admin/users");
                    }).catch((error) => {
                    console.log(error);
                })
            }
        },
        createFormData() {
            const formData = new FormData();
            formData.append('name', this.data.name);
            formData.append('email', this.data.email);
            formData.append('password', this.data.password);
            formData.append('usertype', this.data.usertype);
            formData.append('description', this.data.description);
            formData.append('sectors', this.data.sectors);
            return formData;
        },
        getProjectData() {
            this.sectors = [];
            let data = {
                id: 'all',
                name: 'All'
            }
            this.sectors.push(data);
            axios.get('/api/get-project-data')
                .then((response) => {
                    this.projectData = response.data;
                    this.projectData.sectors.forEach(element => this.sectors.push(element));
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        selectAll() {
            if (this.data.sectors.includes('all')) {
                this.data.sectors = [];
                this.$refs.select.options.forEach(option => {
                    if (option.id === 'all') {
                        return;
                    }
                    this.data.sectors.push(option.id)
                });
            }
        }
    },
    mounted() {
        this.getProjectData();
        this.flashMessage.setStrategy('multiple');
        this.data = this.user;
    }
}
</script>
