<template>
    <div class="container-fluid add-project">
        <h3 v-if="document.length === 0">Add Product Document</h3>
        <h3 v-else>Edit Product Document</h3>
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
                    <label>Pages</label>
                    <input class="project-text" type="text" placeholder="Enter pages" v-model="data.pages">
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Product Types</label>
                    <v-select v-if="types" multiple placeholder="Select product types"
                              :options="types" v-model="data.types" label="name"
                              :reduce="referrer => referrer.id" @input="selectAll" ref="select" :closeOnSelect="false"></v-select>
                </div>
            </div>
            <input v-if="document.length === 0" type="submit" value="Save" class="btn btn-primary submit">
            <input v-else type="submit" value="Update" class="btn btn-primary submit">
        </form>
        <FlashMessage :position="'right top'"></FlashMessage>
    </div>
</template>

<script>
export default {
    props: ['document'],
    data() {
        return {
            data: [],
            errors: [],
            types: []
        }
    },
    methods: {
        checkForm(e) {
            if (this.data.name && this.data.types.length > 0) {
                this.saveProductDocument()
            }

            this.errors = [];

            if (!this.data.name) {
                this.flashError('Name required');
            }
            if (this.data.types.length === 0) {
                this.flashError('Product Types required');
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
        saveProductDocument() {
            let formData = this.createFormData();
            if (this.data.id) {
                axios.post('/api/update-product-document/' + this.data.id, formData)
                    .then((response) => {
                        this.flashMessage.success({
                            message: 'Product Document successfully updated',
                            time: 5000,
                            blockClass: 'custom-block-class'
                        });
                        location.replace("/admin/product-documents");
                    }).catch((error) => {
                    console.log(error);
                });
            } else {
                axios.post('/api/save-product-document', formData)
                    .then((response) => {
                        this.flashMessage.success({
                            message: 'Product Document successfully saved',
                            time: 5000,
                            blockClass: 'custom-block-class'
                        });
                        location.replace("/admin/product-documents");
                    }).catch((error) => {
                    console.log(error);
                });
            }
        },
        createFormData() {
            let types = [];
            if (typeof this.data.types[0].id !== 'undefined') {
                this.data.types.forEach(
                    element => types.push(element.id)
                );
            } else {
                types = this.data.types;
            }
            const formData = new FormData();
            formData.append('name', this.data.name);
            formData.append('name_ar', this.data.name_ar ? this.data.name_ar : '');
            formData.append('pages', this.data.pages ? this.data.pages : '');
            formData.append('types', types);
            return formData;
        },
        selectAll() {
            if (this.data.types.includes('all')) {
                this.data.types = [];
                this.$refs.select.options.forEach(option => {
                    if (option.id === 'all') {
                        return;
                    }
                    this.data.types.push(option.id)
                });
            }
        },
        getProductType() {
            this.types = [];
            let data = {
                id: 'all',
                name: 'All'
            }
            this.types.push(data);
            axios.get('/api/get-product-type')
                .then((response) => {
                    response.data.forEach(element => this.types.push(element));
                }).catch((error) => {
                console.log(error);
            })
        }
    },
    mounted() {
        this.getProductType();
        this.flashMessage.setStrategy('multiple');
        this.data = this.document
    }
}
</script>

