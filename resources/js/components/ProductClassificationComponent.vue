<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="input-group rounded search-bar">
                    <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                           aria-describedby="search-addon" v-model="search" @input="getProductClassifications(1)"/>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <a href="/admin/add-product-classification" class="btn btn-success add-project-btn">Add New Product
                    Classification</a>
            </div>
        </div>
        <table class="table projects-table">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="productClassification in productClassifications">
                <td>{{ productClassification.id }}</td>
                <td>{{ productClassification.name }}</td>
                <td>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <button type="button" class="btn btn-dark btn-sm custom-btn"
                                    @click="updateStatus(productClassification.id)">
                                {{ productClassification.status ? 'Disable' : 'Enable' }}
                            </button>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <a :href="'/admin/edit-product-classification/' + productClassification.id"
                               class="btn btn-primary btn-sm custom-btn custom-btn-top">Edit</a>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <button type="button" class="btn btn-secondary btn-sm custom-btn custom-btn-top"
                                    @click="deleteProductClassification(productClassification.id)">Delete
                            </button>
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <div v-if="productClassifications.length && pagination.last_page > 1" style="text-align: center">
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
            productClassifications: [],
            pagination: [],
            search: ''
        }
    },
    methods: {
        getProductClassifications(page = 1) {
            let params = '?page=' + page;
            if (this.search.length) {
                params += '&search=' + this.search;
            }
            axios.get('/api/get-product-classifications' + params)
                .then((response) => {
                    this.productClassifications = response.data.data;
                    this.pagination = response.data;
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        clickCallback(page) {
            this.getProductClassifications(page);
        },
        deleteProductClassification(id) {
            if (confirm("Do you really want to delete Product Classification?")) {
                axios.post('/api/delete-product-classification/' + id)
                    .then((response) => {
                        this.getProductClassifications(this.pagination.current_page);
                        this.flashMessage.success({
                            message: 'Product Classification successfully deleted',
                            time: 5000,
                            blockClass: 'custom-block-class'
                        });
                    }).catch((error) => {
                    console.log(error);
                })
            }
        },
        updateStatus(id) {
            axios.post('/api/update-product-classification-status/' + id)
                .then((response) => {
                    this.getProductClassifications(this.pagination.current_page);
                    this.flashMessage.success({
                        message: 'Product Classification status successfully updated',
                        time: 5000,
                        blockClass: 'custom-block-class'
                    });
                }).catch((error) => {
                console.log(error);
            })
        }
    },
    mounted() {
        this.getProductClassifications();
    }
}
// export default {
//     name: "Company"
// }
</script>

<!--<style scoped>-->

<!--</style>-->
