<template>
    <div class="container-fluid add-project">
        <h3 v-if="productType.length === 0">Add Product Type</h3>
        <h3 v-else>Edit Product Type</h3>
        <form @submit="checkForm">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Product Type</label>
                    <input class="project-text" type="text" placeholder="Enter product type" v-model="data.name">
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Product Classifications</label>
                    <v-select v-if="classifications" multiple placeholder="Select product classifications"
                              :options="classifications" v-model="data.classifications" label="name"
                              :reduce="referrer => referrer.id" @input="selectAll" ref="select" :closeOnSelect="false"></v-select>
                </div>
            </div>
            <input v-if="productType.length === 0" type="submit" value="Save" class="btn btn-primary submit">
            <input v-else type="submit" value="Update" class="btn btn-primary submit">
        </form>
        <FlashMessage :position="'right top'"></FlashMessage>
    </div>
</template>

<script>
export default {
    props: ['productType', 'user'],
    data() {
        return {
            file: null,
            productTypeData: null,
            data: [],
            errors: [],
            classifications: []
        }
    },
    methods: {
        checkForm(e) {
            if (this.data.name && this.data.classifications.length > 0) {
                this.saveProductType()
            }

            this.errors = [];

            if (!this.data.name) {
                this.flashError('Product Type required');
            }
            if (this.data.classifications.length === 0) {
                this.flashError('Product Classifications required');
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
        saveProductType() {
            let formData = this.createFormData();
            axios.defaults.headers.common['Content-Type'] = 'multipart/form-data'
            if (this.data.id) {
                axios.post('/api/update-product-type/' + this.data.id, formData)
                    .then((response) => {
                        this.flashMessage.success({
                            message: 'Product Type successfully updated',
                            time: 5000,
                            blockClass: 'custom-block-class'
                        });
                        location.replace("/admin/product-types");
                    }).catch((error) => {
                    console.log(error);
                });
            } else {
                axios.post('/api/save-product-type', formData)
                    .then((response) => {
                        // console.log('R', response);
                        this.flashMessage.success({
                            message: 'Product Type successfully saved',
                            time: 5000,
                            blockClass: 'custom-block-class'
                        });
                        location.replace("/admin/product-types");
                    }).catch((error) => {
                    console.log(error);
                });
            }
        },
        createFormData() {
            let classifications = [];
            if (typeof this.data.classifications[0].id !== 'undefined') {
                this.data.classifications.forEach(
                    element => classifications.push(element.id)
                );
            } else {
                classifications = this.data.classifications;
            }
            const formData = new FormData();
            formData.append('name', this.data.name ? this.data.name : '');
            formData.append('user_id', this.user.id);
            formData.append('classifications', classifications);
            return formData;
        },
        selectAll() {
            if (this.data.classifications.includes('all')) {
                this.data.classifications = [];
                this.$refs.select.options.forEach(option => {
                    if (option.id === 'all') {
                        return;
                    }
                    this.data.classifications.push(option.id)
                });
            }
        },
        getProductClassification() {
            this.classifications = [];
            let data = {
                id: 'all',
                name: 'All'
            }
            this.classifications.push(data);
            axios.get('/api/get-product-classification')
                .then((response) => {
                    response.data.forEach(element => this.classifications.push(element));
                }).catch((error) => {
                console.log(error);
            })
        }
    },
    mounted() {
        // this.getCompanyData();
        this.getProductClassification();
        this.flashMessage.setStrategy('multiple');
        this.data = this.productType
    }
}
</script>

