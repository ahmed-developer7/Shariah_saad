<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="input-group rounded search-bar">
                    <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                           aria-describedby="search-addon" v-model="search" @input="getProductDocuments(1)"/>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <a href="/admin/add-product-document" class="btn btn-success add-project-btn">Add New Product Document</a>
            </div>
        </div>
        <table class="table projects-table">
            <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Name (In Arabic)</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="productDocument in productDocuments">
                <td>{{ productDocument.name }}</td>
                <td>{{ productDocument.name_ar }}</td>
                <td>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <button type="button" class="btn btn-dark btn-sm custom-btn"
                                    @click="updateStatus(productDocument.id)">
                                {{ productDocument.status ? 'Disable' : 'Enable' }}
                            </button>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <a :href="'/admin/edit-product-document/' + productDocument.id"
                               class="btn btn-primary btn-sm custom-btn custom-btn-top">Edit</a>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <button type="button" class="btn btn-secondary btn-sm custom-btn custom-btn-top"
                                    @click="deleteProductDocument(productDocument.id)">Delete
                            </button>
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <h3 v-if="!productDocuments.length" style="text-align: center; padding: 3%">No Product Documents</h3>
        <div v-if="productDocuments.length && pagination.last_page > 1" style="text-align: center">
            <paginate
                v-model="pagination.current_page"
                :page-count="pagination.last_page"
                :page-range="3"
                :margin-pages="2"
                :click-handler="clickCallback"
                :prev-text="'Prev'"
                :next-text="'Next'"
                :container-class="'pagination'"
                :page-class="'page-item'">
            </paginate>
        </div>
        <FlashMessage :position="'right top'"></FlashMessage>
    </div>
</template>

<script>
export default {
    data() {
        return {
            productDocuments: [],
            pagination: [],
            search: ''
        }
    },
    methods: {
        getProductDocuments(page = 1) {
            let params = '?page=' + page;
            if (this.search.length) {
                params += '&search=' + this.search;
            }
            axios.get('/api/get-product-documents' + params)
                .then((response) => {
                    this.productDocuments = response.data.data;
                    this.pagination = response.data;
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        clickCallback(page) {
            this.getProductDocuments(page);
        },
        deleteProductDocument(id) {
            if (confirm("Do you really want to delete product document?")) {
                axios.post('/api/delete-product-document/' + id)
                    .then((response) => {
                        this.getProductDocuments(this.pagination.current_page);
                        this.flashMessage.success({
                            message: 'Product Document successfully deleted',
                            time: 5000,
                            blockClass: 'custom-block-class'
                        });
                    }).catch((error) => {
                    console.log(error);
                })
            }
        },
        updateStatus(id) {
            axios.post('/api/update-product-document-status/' + id)
                .then((response) => {
                    this.getProductDocuments(this.pagination.current_page);
                    this.flashMessage.success({
                        message: 'Product Document status successfully updated',
                        time: 5000,
                        blockClass: 'custom-block-class'
                    });
                }).catch((error) => {
                console.log(error);
            })
        }
    },
    mounted() {
        this.getProductDocuments();
    }
}
</script>

