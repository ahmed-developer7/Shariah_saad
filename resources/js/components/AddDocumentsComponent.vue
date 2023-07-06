<template>
    <div class="container-fluid add-project">
        <h3 v-if="type == 'add'">Add Documents</h3>
        <h3 v-else>Amend Documents</h3>
        <form @submit="checkForm">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Documents</label>
                    <v-select v-if="documentsData" multiple placeholder="Select documents"
                              :options="documentsData" v-model="data.documents" label="name"
                              :reduce="referrer => referrer.id" @input="selectAll" ref="select"
                              :closeOnSelect="false"></v-select>
                </div>
            </div>
            <input type="submit" value="Save" class="btn btn-primary submit">
        </form>
        <FlashMessage :position="'right top'"></FlashMessage>
        <modal name="certificate-number-modal" class="certificate-number-modal certificate-number-add-modal" @closed="hide">
            <h3>Certificate Number Updated</h3>
            <div class="input-field">
                <input type="text" ref="inputField" :value="certificate_number" @input="handleInput" readonly/>
                <button class="copy-btn" @click="copyToClipboard">
                    <img src="/images/copy-icon.png">
                </button>
                <a href="/admin/projects" class="btn btn-primary" style="display: block; margin: 25px auto">Certification</a>
            </div>
        </modal>
    </div>
</template>

<script>
export default {
    props: ['id', 'type', 'documents'],
    data() {
        return {
            data: [],
            errors: [],
            documentsData: [],
            certificate_number: '',
            value: ''
        }
    },
    methods: {
        checkForm(e) {
            if (this.data.documents.length > 0) {
                this.saveDocuments()
            }

            this.errors = [];

            if (this.data.documents.length === 0) {
                this.flashError('Documents required');
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
        saveDocuments() {
            let formData = this.createFormData();
            axios.post('/api/save-documents/' + this.id + '/' + this.type, formData)
                .then((response) => {
                    console.log(response.data);
                    this.certificate_number = response.data.number
                    this.flashMessage.success({
                        message: 'Documents successfully saved',
                        time: 5000,
                        blockClass: 'custom-block-class'
                    });
                    this.$modal.show('certificate-number-modal');
                }).catch((error) => {
                console.log(error);
            });
        },
        createFormData() {
            let documents = [];
            if (typeof this.data.documents[0].id !== 'undefined') {
                this.data.documents.forEach(
                    element => documents.push(element.id)
                );
            } else {
                documents = this.data.documents;
            }
            const formData = new FormData();
            formData.append('documents', documents);
            return formData;
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
        },
        getProductDocuments() {
            this.documentsData = [];
            let data = {
                id: 'all',
                name: 'All'
            }
            this.documentsData.push(data);
            axios.get('/api/get-product-document')
                .then((response) => {
                    response.data.forEach(element => this.documentsData.push(element));
                }).catch((error) => {
                console.log(error);
            })
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
    },
    mounted() {
        this.getProductDocuments();
        this.data = this.documents;
    }
}
</script>

