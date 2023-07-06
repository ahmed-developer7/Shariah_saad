<template>
    <div class="container-fluid add-project">
        <h3 v-if="observation.length === 0">Add Observation</h3>
        <h3 v-else>Edit Observation</h3>
        <form @submit="checkForm">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Client</label>
                    <v-select v-if="companies" placeholder="Select client" :options="companies"
                              v-model="data.company_id" label="name" :reduce="referrer => referrer.id"
                              @input="getProducts"
                              :disabled="data.id != null">
                    </v-select>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Product</label>
                    <v-select v-if="products" placeholder="Select product" :options="products"
                              v-model="data.project_id" label="product"
                              :reduce="referrer => referrer.project_id"></v-select>
                </div>
            </div>
            <template v-for="field in fields">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <label>Year</label>
                        <v-select placeholder="Select year" :options="years" v-model="field.year"></v-select>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <label>Function</label>
                        <input class="project-text" type="text" placeholder="Enter function" v-model="field.function">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <label>Description</label>
                        <textarea class="project-text" placeholder="Enter description"
                                  v-model="field.description"></textarea>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <label>Observation Details</label>
                        <textarea class="project-text" placeholder="Enter observation details"
                                  v-model="field.observation_details"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <label>Risk</label>
                        <input class="project-text" type="text" placeholder="Enter risk" v-model="field.risk">
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <label>Recommendation</label>
                        <input class="project-text" type="text" placeholder="Enter recommendation"
                               v-model="field.recommendation">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <label>Management Response</label>
                        <input class="project-text" type="text" placeholder="Enter management response"
                               v-model="field.management_response">
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <label>Date of Audit</label>
                        <input class="project-text" type="date" v-model="field.date_of_audit">
                    </div>
                </div>
            </template>
            <div v-if="!edit" class="row" style="display: flex; justify-content: right;">
                <div v-if="fields.length > 1" class="col-lg-2 col-md-2 col-sm-12" style="display: flex; justify-content: right; padding-right: 0;">
                    <button type="button" class="btn btn-dark btn-sm" @click="removeField">- Remove Observation</button>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12" style="display: flex; justify-content: right; width: 12%;">
                    <button type="button" class="btn btn-primary btn-sm" @click="addField">+ Add Observation</button>
                </div>
            </div>
            <input v-if="observation.length === 0" type="submit" value="Save" class="btn btn-primary submit">
            <input v-else type="submit" value="Update" class="btn btn-primary submit">
        </form>
        <FlashMessage :position="'right top'"></FlashMessage>
    </div>
</template>

<script>
export default {
    props: ['observation'],
    data() {
        return {
            data: [],
            errors: [],
            companies: [],
            products: [],
            fields: [],
            edit: false
        }
    },
    methods: {
        checkForm(e) {
            if (this.data.company_id) {
                this.addObservation()
            }

            this.errors = [];

            if (!this.data.company_id) {
                this.flashError('Client required');
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
        addObservation() {
            let company_id = this.data.company_id, project_id = this.data.project_id ? this.data.project_id : ''
            if (this.data.id) {
                axios.post('/api/update-observation/' + this.data.id, {fields: this.fields, company_id: company_id, project_id: project_id})
                    .then((response) => {
                        this.flashMessage.success({
                            message: 'Observation successfully updated',
                            time: 5000,
                            blockClass: 'custom-block-class'
                        });
                        location.replace("/admin/observations");
                    }).catch((error) => {
                    console.log(error);
                });
            } else {
                axios.post('/api/add-observation', {fields: this.fields, company_id: company_id, project_id: project_id})
                    .then((response) => {
                        this.flashMessage.success({
                            message: 'Observation successfully saved',
                            time: 5000,
                            blockClass: 'custom-block-class'
                        });
                        location.replace("/admin/observations");
                    }).catch((error) => {
                    console.log(error);
                });
            }
        },
        createFormData() {
            const formData = new FormData();
            formData.append('company_id', this.data.company_id);
            formData.append('project_id', this.data.project_id ? this.data.project_id : '');
            formData.append('year', this.data.year ? this.data.year : '');
            formData.append('function', this.data.function ? this.data.function : '');
            formData.append('description', this.data.description ? this.data.description : '');
            formData.append('observation_details', this.data.observation_details ? this.data.observation_details : '');
            formData.append('risk', this.data.risk ? this.data.risk : '');
            formData.append('recommendation', this.data.recommendation ? this.data.recommendation : '');
            formData.append('management_response', this.data.management_response ? this.data.management_response : '');
            formData.append('date_of_audit', this.data.date_of_audit ? this.data.date_of_audit : '');
            return formData;
        },
        getCompanies() {
            axios.get('/api/get-observations-companies')
                .then((response) => {
                    this.companies = response.data
                }).catch((error) => {
                console.log(error);
            })
        },
        getProducts() {
            this.products = [];
            axios.get('/api/get-observations-products/' + this.data.company_id)
                .then((response) => {
                    this.products = response.data
                }).catch((error) => {
                console.log(error);
            })
        },
        addField(value = '') {
            if (this.fields.length > 0) {
                value = this.fields[this.fields.length - 1]
            }
            this.fields.push({value});
        },
        removeField() {
            this.fields.pop();
        }
    },
    mounted() {
        this.getCompanies();
        this.data = this.observation
        if (this.observation) {
            this.getProducts()
        }
        if (this.observation.length === 0) {
            this.addField()
        } else {
            this.edit = true
            this.fields.push(this.observation);
        }
        this.flashMessage.setStrategy('multiple');
    },
    computed: {
        years() {
            let data = [];
            for (let i = 2005; i <= new Date().getFullYear(); i++) {
                data.push(i);
            }
            return data;
        }
    }
}
</script>

