<template>
    <div class="container-fluid add-project">
        <br>
        <h4>Certificate Info</h4>
        <form @submit="checkForm">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <label>Template</label>
                    <v-select placeholder="Select template"
                              :reduce="(option) => option.id"
                              label="name"
                              :options="[{ name: 'SRB template', id: 'srb_template' }, { name: 'Al-Marjea template', id: 'al_marjea_template' }]"
                              v-model="data.template"></v-select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Sector</label>
                    <v-select v-if="projectData" placeholder="Select sector" :options="projectData.sectors"
                              v-model="data.sector_id" label="name" :reduce="referrer => referrer.id"></v-select>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Client</label>
                    <v-select v-if="projectData" placeholder="Select client" :options="projectData.companies"
                              v-model="data.company_client" label="name" :reduce="referrer => referrer.id"
                              @input="getCode" :disabled="data.project_id != null"></v-select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Name of Product</label>
                    <input class="project-text" type="text" placeholder="Enter name of product" v-model="data.product">
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Name of Product (In Arabic)</label>
                    <input class="project-text" type="text" placeholder="Enter name of product (in arabic)" v-model="data.product_ar">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Certificate Number</label>
                    <input class="project-text" type="text" placeholder="Enter certificate number"
                           v-model="certificate_number" readonly>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Date Received</label>
                    <input class="project-text" type="date" v-model="data.date_received">
                </div>
            </div>
            <br>
            <h4>Product Info</h4>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <label>Product Classification</label>
                    <v-select v-if="projectData" placeholder="Select product classification"
                              :options="projectData.product_classification" v-model="data.product_classification_id"
                              label="name" :reduce="referrer => referrer.id" @input="getProductType"></v-select>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <label>Product Type</label>
                    <v-select v-if="types" placeholder="Select product type"
                              :options="types" v-model="data.kind_of_product" label="name"
                              :reduce="referrer => referrer.id" @input="getProductDocuments"></v-select>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <label>Product Documents</label>
                    <v-select v-if="documents" multiple placeholder="Select product documents"
                              :options="documents" v-model="data.documents" label="name"
                              :reduce="referrer => referrer.id" :closeOnSelect="false" ref="select" @input="selectAll"></v-select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Language 1</label>
                    <v-select v-if="projectData" placeholder="Select language 1" :options="projectData.languages"
                              v-model="data.language_1" label="name" :reduce="referrer => referrer.id" @input="getHours"></v-select>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Language 2</label>
                    <v-select v-if="projectData" placeholder="Select language 2" :options="projectData.languages"
                              v-model="data.language_2" label="name" :reduce="referrer => referrer.id" @input="getHours"></v-select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <label>Product Currency</label>
                    <v-select placeholder="Select product currency"
                              :options="['USD', 'BHD', 'SR', 'KWD', 'OMR', 'QAR', 'GBP', 'EUR', 'CHF', 'CAD', 'PKR', 'INR', 'KZT']"
                              v-model="data.fund_currency"></v-select>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <label>Product Size</label>
                    <input class="project-text" type="text" placeholder="Enter product size" v-model="data.fund_size">
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <label>Guideline</label>
                    <v-select v-if="projectData" placeholder="Select guideline" :options="projectData.guidelines"
                              label="name" :selectable="option => !option.hasOwnProperty('heading')"
                              v-model="data.guideline_id" :reduce="referrer => referrer.id">
                        <template #option="{ heading, name }">
                            <div v-if="heading" class="group" style="font-weight: bold">
                                {{ heading }}
                            </div>
                            {{ name }}
                        </template>
                    </v-select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Hours for Review by Scholar</label>
                    <input class="project-text" type="text" placeholder="Enter hours for review by scholar"
                           v-model="hours_for_review">
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Hours for Review by SAM</label>
                    <input class="project-text" type="text" placeholder="Enter hours for review by SAM"
                           v-model="hours_for_review_by_sam">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Estimated Calls</label>
                    <input class="project-text" type="text" placeholder="Enter estimated calls"
                           v-model="data.estimated_calls">
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Call timings (minutes)</label>
                    <input class="project-text" type="text" placeholder="Enter call timings (minutes)"
                           v-model="data.call_timing">
                </div>
            </div>
            <div v-for="(field, index) in fields" class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <label>Scholar {{index+1}}</label>
                    <v-select v-if="projectData" placeholder="Select scholar" :options="projectData.scholars"
                              v-model="field.scholar" :reduce="referrer => referrer.id" :getOptionLabel="referrer => referrer.name"></v-select>
                </div>
            </div>
            <div class="row" style="display: flex; justify-content: right;">
                <div v-if="fields.length > 1" class="col-lg-2 col-md-2 col-sm-12" style="display: flex; justify-content: right; padding-right: 0;">
                    <button type="button" class="btn btn-dark btn-sm" @click="removeField">- Remove Scholar</button>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12" style="display: flex; justify-content: right; width: 10%">
                    <button type="button" class="btn btn-primary btn-sm" @click="addField">+ Add Scholar</button>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Individual 1</label>
                    <v-select v-if="projectData" placeholder="Select individual 1" :options="projectData.employees"
                              v-model="data.employee_1" label="name" :reduce="referrer => referrer.id"></v-select>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Individual 2</label>
                    <v-select v-if="projectData" placeholder="Select individual 2" :options="projectData.employees"
                              v-model="data.employee_2" label="name" :reduce="referrer => referrer.id"></v-select>
                </div>
            </div>
            <br>
            <h4>Search Engine</h4>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Status</label>
                    <v-select placeholder="Select status" :options="['active', 'in-active']"
                              v-model="data.status"></v-select>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Remarks</label>
                    <input class="project-text" type="text" placeholder="Enter remarks" v-model="data.remarks_1">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Certificate</label>
                    <input style="padding-left: 0" class="project-text" type="file" @change="uploadCertificate" ref="file">
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Terminate Certificate</label>
                    <input style="padding-left: 0" class="project-text" type="file" @change="uploadCertificate2" ref="file2">
                </div>
            </div>
            <br>
            <input v-if="project.length === 0 || duplicate" type="submit" value="Save" class="btn btn-primary submit">
            <input v-else type="submit" value="Update" class="btn btn-primary submit">
            <br>
        </form>
        <FlashMessage :position="'right top'"></FlashMessage>

        <modal name="certificate-number-modal" class="certificate-number-modal" @closed="hide">
            <h3>Certificate Number Generated</h3>
            <div class="input-field">
                <input type="text" ref="inputField" :value="certificate_number" @input="handleInput" readonly/>
                <button class="copy-btn" @click="copyToClipboard">
                    <img src="/images/copy-icon.png">
                </button>
                <h4 style="margin-top: 20px">Do you want to send the email for signature?</h4>
                <div class="row" style="margin-top: 15px">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <a @click="sendCertificate(project_id, certificate_number)" class="btn btn-primary">Yes</a>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <button type="button" class="btn btn-secondary" @click="hide">No</button>
                    </div>
                </div>
                <a :href="'/admin/send-certificate/' + project_id + '/' + certificate_number + '/null/true'" class="btn btn-dark" style="display: block; margin: -15px auto">Download Certificate</a>
            </div>
        </modal>
    </div>
</template>

<script>

export default {
    props: ['project', 'user', 'duplicate'],
    data() {
        return {
            projectData: null,
            data: [],
            errors: [],
            client_code: this.project.client_code ? this.project.client_code : '',
            certificate_number: this.project.certificate_number ? this.project.certificate_number : '',
            value: "",
            project_id: '',
            fields: [],
            types: [],
            documents: [],
            hours_for_review: '',
            hours_for_review_by_sam: ''
        }
    },
    methods: {
        checkForm(e) {
            if (this.data.company_client && this.data.language_1 && (this.fields[0] && this.fields[0].scholar) &&
                this.data.sector_id && this.data.product && this.data.product_ar && this.data.date_received &&
                this.data.product_classification_id && this.data.kind_of_product && (this.data.documents && this.data.documents.length > 0) &&
                this.data.template && this.data.status) {
                this.saveProject()
            }

            this.errors = [];

            if (!this.data.template) {
                this.flashError('Template required');
            }
            if (!this.data.sector_id) {
                this.flashError('Sector required');
            }
            if (!this.data.company_client) {
                this.flashError('Client required');
            }
            if (!this.data.product) {
                this.flashError('Name of Product required');
            }
            if (!this.data.product_ar) {
                this.flashError('Name of Product (In Arabic) required');
            }
            if (!this.data.date_received) {
                this.flashError('Date Received required');
            }
            if (!this.data.product_classification_id) {
                this.flashError('Product Classification required');
            }
            if (!this.data.kind_of_product) {
                this.flashError('Product Type required');
            }
            if (!this.data.documents || this.data.documents.length <= 0) {
                this.flashError('Product Documents required');
            }
            if (!this.data.language_1) {
                this.flashError('Language 1 required');
            }
            if (!this.fields[0] || !this.fields[0].scholar) {
                this.flashError("Scholar 1 required");
            }
            if (!this.data.status) {
                this.flashError('Status required');
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
        saveProject() {
            let formData = this.createFormData();
            axios.defaults.headers.common['Content-Type'] = 'multipart/form-data'
            if (this.data.project_id && !this.duplicate) {
                axios.post('/api/update-project/' + this.data.project_id, formData)
                    .then((response) => {
                        this.flashMessage.success({
                            message: 'Project successfully updated',
                            time: 5000,
                            blockClass: 'custom-block-class'
                        });
                        this.project_id = this.data.project_id;
                        this.$modal.show('certificate-number-modal');
                    }).catch((error) => {
                    console.log(error);
                })
            } else {
                axios.post('/api/save-project', formData)
                    .then((response) => {
                        this.flashMessage.success({
                            message: 'Project successfully saved',
                            time: 5000,
                            blockClass: 'custom-block-class'
                        });
                        this.project_id = response.data.project_id;
                        this.$modal.show('certificate-number-modal');
                    }).catch((error) => {
                    console.log(error);
                })
            }
        },
        createFormData() {
            const formData = new FormData();
            let scholars = [];
            this.fields.forEach(option => {
                if (option.scholar) {
                    scholars.push(option.scholar)
                }
            });
            let documents = [];
            if (this.data.documents && this.data.documents.length > 0) {
                if (typeof this.data.documents[0].id !== 'undefined') {
                    this.data.documents.forEach(
                        element => documents.push(element.id)
                    );
                } else {
                    documents = this.data.documents;
                }
            }
            formData.append('scholars', scholars);
            formData.append('sector_id', this.data.sector_id ? this.data.sector_id : '');
            formData.append('product_classification_id', this.data.product_classification_id ? this.data.product_classification_id : '');
            formData.append('company_client', this.data.company_client);
            formData.append('client_code', this.client_code);
            formData.append('certificate_number', this.certificate_number ? this.certificate_number : '');
            formData.append('status', this.data.status ? this.data.status : '');
            formData.append('remarks_1', this.data.remarks_1 ? this.data.remarks_1 : '');
            formData.append('date_received', this.data.date_received ? this.data.date_received : '');
            formData.append('date_completed', '');
            formData.append('kind_of_product', this.data.kind_of_product ? this.data.kind_of_product : '');
            formData.append('product', this.data.product ? this.data.product : '');
            formData.append('product_ar', this.data.product_ar ? this.data.product_ar : '');
            formData.append('documents', documents);
            formData.append('fund_size', this.data.fund_size ? this.data.fund_size : '');
            formData.append('fund_currency', this.data.fund_currency ? this.data.fund_currency : '');
            formData.append('hours_for_review', this.hours_for_review ? this.hours_for_review : '');
            formData.append('hours_for_review_by_sam', this.hours_for_review_by_sam ? this.hours_for_review_by_sam : '');
            formData.append('no_of_days', 'N/A');
            formData.append('no_of_touchpoints', 'N/A');
            formData.append('estimated_calls', this.data.estimated_calls ? this.data.estimated_calls : '');
            formData.append('call_timing', this.data.call_timing ? this.data.call_timing : '');
            formData.append('language_1', this.data.language_1);
            formData.append('language_2', this.data.language_2 ? this.data.language_2 : '');
            formData.append('employee_1', this.data.employee_1 ? this.data.employee_1 : '');
            formData.append('employee_2', this.data.employee_2 ? this.data.employee_2 : '');
            formData.append('certificate_1', this.data.certificate_1 ? this.data.certificate_1 : '');
            formData.append('certificate_2', this.data.certificate_2 ? this.data.certificate_2 : '');
            formData.append('updated_by', this.user.id);
            formData.append('template', this.data.template);
            formData.append('guideline_id', this.data.guideline_id ? this.data.guideline_id : '');
            return formData;
        },
        getProjectData() {
            axios.get('/api/get-project-data')
                .then((response) => {
                    this.projectData = response.data;
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        uploadCertificate() {
            this.data.certificate_1 = this.$refs.file.files[0];
        },
        uploadCertificate2() {
            this.data.certificate_2 = this.$refs.file2.files[0];
        },
        getCode() {
            if (this.data.company_client) {
                axios.get('/api/get-code/' + this.data.company_client)
                    .then((response) => {
                        this.client_code = response.data.code;
                        this.certificate_number = response.data.certificate_number
                    })
                    .catch((error) => {
                        console.log(error);
                    })
            }
        },
        hide() {
            this.$modal.hide('certificate-number-modal');
            location.replace("/admin/projects");
        },
        handleInput(event) {
            this.value = event.target.value;
        },
        copyToClipboard() {
            this.$refs.inputField.select();
            document.execCommand("copy");
            window.getSelection().removeAllRanges();
            this.flashMessage.success({
                message: 'Certificate number copied to clipboard',
                time: 5000,
                blockClass: 'custom-block-class'
            });
        },
        addField(value = '') {
            this.fields.push({scholar: value});
        },
        removeField() {
            this.fields.pop();
        },
        getProductType() {
            this.types = [];
            axios.get('/api/get-product-type/' + this.data.product_classification_id)
                .then((response) => {
                    response.data.forEach(element => this.types.push(element));
                }).catch((error) => {
                console.log(error);
            })
        },
        getProductDocuments() {
            this.documents = [];
            let data = {
                id: 'all',
                name: 'All'
            }
            this.documents.push(data);
            axios.get('/api/get-product-document/' + this.data.kind_of_product)
                .then((response) => {
                    response.data.forEach(element => this.documents.push(element));
                }).catch((error) => {
                console.log(error);
            })
        },
        selectAll() {
            if (this.data.documents.includes('all')) {
                this.data.documents = [];
                this.$refs.select.options.forEach(option => {
                    if (option.id === 'all') {
                        return;
                    }
                    this.data.documents.push(option.id)
                });
            }
            this.getHours()
        },
        getHours() {
            let documents = [];
            if (this.data.documents && this.data.documents.length > 0) {
                if (typeof this.data.documents[0].id !== 'undefined') {
                    this.data.documents.forEach(
                        element => documents.push(element.id)
                    );
                } else {
                    documents = this.data.documents;
                }
            }
            axios.get('/api/get-documents-estimate', {
                params: {
                    documents: documents,
                    language_1: this.data.language_1,
                    language_2: this.data.language_2
                }
            })
                .then((response) => {
                    this.hours_for_review = response.data.hours_for_review
                    this.hours_for_review_by_sam = response.data.hours_for_review_by_sam
                }).catch((error) => {
                console.log(error);
            })
        },
        cert_num(number) {
            if (number) {
                return number.replace("#", "%23");
            }
        },
        sendCertificate(id, number) {
            axios.get('/api/check-signature/' + id)
                .then((response) => {
                    if (response.data) {
                        if (confirm("The following scholars signature exists. Do you want to send certificate to these scholars?\n\n" + response.data +
                            "\n\nNOTE: By clicking 'Cancel', the certificate will be sent to the scholars who do not have signature uploaded.")) {
                            location.replace("/admin/send-certificate/" + id + "/" + this.cert_num(number) + "/" + true + "/" + false + "/" + true);
                        } else {
                            location.replace("/admin/send-certificate/" + id + "/" + this.cert_num(number) + "/" + true);
                        }
                    } else {
                        location.replace("/admin/send-certificate/" + id + "/" + this.cert_num(number) + "/" + true);
                    }
                })
                .catch((error) => {
                    console.log(error);
                })
        }
    },
    mounted() {
        this.getProjectData();
        this.flashMessage.setStrategy('multiple');
        this.data = this.project;
        if (this.duplicate) {
            this.getCode();
        }
        if (this.project.length === 0 && !this.duplicate) {
            this.addField()
        } else {
            for (let i = 0; i < this.project.scholars.length; i++) {
                this.addField(this.project.scholars[i].id)
            }
        }
        if (this.data) {
            this.hours_for_review = this.data.hours_for_review;
            this.hours_for_review_by_sam = this.data.hours_for_review_by_sam;
            this.getProductType();
            this.getProductDocuments();
        }
    }
}
</script>
