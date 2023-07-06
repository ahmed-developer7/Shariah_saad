<template>
    <div class="container-fluid add-project">
        <h3 v-if="company.length === 0">Add Client</h3>
        <h3 v-else>Edit Client</h3>
        <form @submit="checkForm">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Name</label>
                    <input class="project-text" type="text" placeholder="Enter name" v-model="data.name">
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Name (In Arabic)</label>
                    <input class="project-text" type="text" placeholder="Enter name (in arabic)" v-model="data.name_ar">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Short Code</label>
                    <input class="project-text" type="text" placeholder="Enter short code" v-model="data.short_name">
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Meeting Minute SSB Abbreviation</label>
                    <v-select v-if="shariyah_companies" placeholder="Select meeting minute SSB abbreviation" :options="shariyah_companies"
                              v-model="data.shariyah_company_id" label="name" :reduce="referrer => referrer.id">
                    </v-select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Description</label>
                    <textarea class="project-text" type="text" placeholder="Enter description" v-model="data.description">
                    </textarea>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Termination letter</label>
                    <input class="project-text" type="file" @change="uploadTerminationLetter" ref="file">
                </div>
            </div>
            <input v-if="company.length === 0" type="submit" value="Save" class="btn btn-primary submit">
            <input v-else type="submit" value="Update" class="btn btn-primary submit">
        </form>
        <FlashMessage :position="'right top'"></FlashMessage>
    </div>
</template>

<script>
export default {
    props: ['company', 'user'],
    data() {
        return {
            file: null,
            companyData: null,
            data: [],
            errors: [],
            shariyah_companies: []
        }
    },
    methods: {
        checkForm(e) {
            if (this.data.name && this.data.name_ar && this.data.shariyah_company_id && this.data.short_name) {
                this.saveCompany()
            }

            this.errors = [];

            if (!this.data.name) {
                this.flashError('Name required');
            }
            if (!this.data.name_ar) {
                this.flashError('Name (In Arabic) required');
            }
            if (!this.data.short_name) {
                this.flashError('Short Code required');
            }
            if (!this.data.shariyah_company_id) {
                this.flashError('Meeting Minute SSB Abbreviation required');
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
        saveCompany() {
            let formData = this.createFormData();
            axios.defaults.headers.common['Content-Type'] = 'multipart/form-data'
            if (this.data.id) {
                axios.post('/api/update-company/' + this.data.id, formData)
                    .then((response) => {
                        this.flashMessage.success({
                            message: 'Client successfully updated',
                            time: 5000,
                            blockClass: 'custom-block-class'
                        });
                        location.replace("/admin/companies");
                    }).catch((error) => {
                    this.flashError(error.response.data.message);
                });
            } else {
                axios.post('/api/save-company', formData)
                    .then((response) => {
                        // console.log('R', response);
                        this.flashMessage.success({
                            message: 'Client successfully saved',
                            time: 5000,
                            blockClass: 'custom-block-class'
                        });
                        location.replace("/admin/companies");
                    }).catch((error) => {
                    this.flashError(error.response.data.message);
                });
            }
        },
        createFormData() {
            const formData = new FormData();
            formData.append('name', this.data.name ? this.data.name : '');
            formData.append('name_ar', this.data.name_ar);
            formData.append('short_name', this.data.short_name ? this.data.short_name : '');
            formData.append('description', this.data.description ? this.data.description : '');
            formData.append('terminationLetter', this.data.terminationLetter ? this.data.terminationLetter : '');
            formData.append('user_id', this.user.id);
            formData.append('shariyah_company_id', this.data.shariyah_company_id ? this.data.shariyah_company_id : '');
            return formData;
        },
        uploadTerminationLetter() {
            this.data.terminationLetter = this.$refs.file.files[0];
        },
        getShariyahCompanies() {
            axios.get('/api/get-shariyah-companies')
                .then((response) => {
                    this.shariyah_companies = response.data
                }).catch((error) => {
                console.log(error);
            })
        }
    },
    mounted() {
        // this.getCompanyData();
        this.getShariyahCompanies()
        this.flashMessage.setStrategy('multiple');
        this.data = this.company
        // if (!this.data.sector_id) {
        //     this.data.sector_id = '';
        // }
        // if (!this.data.product_classification_id) {
        //     this.data.product_classification_id = '';
        // }
        // if (!this.data.kind_of_product) {
        //     this.data.kind_of_product = '';
        // }
    }
}
</script>
