<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="input-group rounded search-bar observation-search">
                    <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                           aria-describedby="search-addon" v-model="search" @input="getObservations(1)"/>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 observation-filter">
                <v-select placeholder="Select client" :options="companies" v-model="c_filter" label="name"
                          :reduce="referrer => referrer.id" @input="getObservations(1)"></v-select>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 observation-filter">
                <v-select placeholder="Select product" :options="products" v-model="p_filter" label="product"
                          :reduce="referrer => referrer.project_id" @input="getObservations(1)"></v-select>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-12">
                <a href="/admin/add-observation" class="btn btn-success add-project-btn">Add New Observation</a>
            </div>
        </div>
        <table class="table projects-table">
            <thead>
            <tr>
                <th scope="col">Client</th>
                <th scope="col">Project</th>
                <th scope="col">Year</th>
                <th scope="col">Function</th>
                <th scope="col">Description</th>
                <th scope="col">Observation Details</th>
                <th scope="col">Risk</th>
                <th scope="col">Recommendation</th>
                <th scope="col">Management Response</th>
                <th scope="col">Reason</th>
                <th scope="col">Date of Audit</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="observation in observations">
                <td>{{ observation.company.name }}</td>
                <td>{{ observation.project ? observation.project.product : 'N/A' }}</td>
                <td>{{ observation.year ? observation.year : 'N/A' }}</td>
                <td>{{ observation.function ? observation.function : 'N/A' }}</td>
                <td>{{ observation.description ? observation.description : 'N/A' }}</td>
                <td>{{ observation.observation_details ? observation.observation_details : 'N/A' }}</td>
                <td>{{ observation.risk ? observation.risk : 'N/A' }}</td>
                <td>{{ observation.recommendation ? observation.recommendation : 'N/A' }}</td>
                <td>{{ observation.management_response ? observation.management_response : 'N/A' }}</td>
                <td>{{ observation.reason ? observation.reason : 'N/A' }}</td>
                <td>{{ observation.date_of_audit ? observation.date_of_audit : 'N/A' }}</td>
                <td>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <a :href="'/admin/observation-history/' + observation.id"
                               class="btn btn-warning btn-sm custom-btn custom-btn-top"
                               style="width: 88px">History</a>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <button type="button" class="btn btn-dark btn-sm" style="margin-top: 10px; width: 88px"
                                    :disabled="observation.status == 1" @click="show(observation.id)">
                                {{ observation.status == 1 ? 'Resolved' : 'Resolve' }}
                            </button>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <a :href="'/admin/edit-observation/' + observation.id" class="btn btn-primary btn-sm"
                               style="margin-top: 10px; width: 88px;">Edit</a>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <button type="button" class="btn btn-secondary btn-sm"
                                    style="margin-top: 10px; width: 88px;"
                                    @click="deleteObservation(observation.id)">Delete
                            </button>
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <h3 v-if="!observations.length" style="text-align: center; padding: 3%">No Observations</h3>
        <div v-if="observations.length && pagination.last_page > 1" style="text-align: center">
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
        <modal name="resolve-modal" class="certificate-number-modal certificate-number-add-modal" @closed="hide">
            <h3 style="margin-top: 25px;">Resolve Observation</h3>
            <div class="container-fluid add-project">
                <div class="row">
                    <div class="col-lg-11 col-md-11 col-sm-11" style="margin: 0 auto;">
                        <label>Reason</label>
                        <input class="project-text" type="text" placeholder="Enter reason" v-model="reason">
                        <input type="submit" value="Save" class="btn btn-primary submit" style="margin-top: 20px;" @click="updateStatus(id)">
                    </div>
                </div>
            </div>
        </modal>
        <FlashMessage :position="'right top'"></FlashMessage>
    </div>
</template>

<script>

export default {
    data() {
        return {
            observations: [],
            pagination: [],
            search: '',
            companies: [],
            products: [],
            c_filter: '',
            p_filter: '',
            reason: '',
            id: ''
        }
    },
    methods: {
        getObservations(page = 1) {
            let params = '?page=' + page;
            if (this.search.length) {
                params += '&search=' + this.search;
            }
            if (this.c_filter) {
                params += '&c_filter=' + this.c_filter;
            }
            if (this.p_filter) {
                params += '&p_filter=' + this.p_filter;
            }
            axios.get('/api/get-observations' + params)
                .then((response) => {
                    this.observations = response.data.data;
                    this.pagination = response.data;
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        clickCallback(page) {
            this.getObservations(page);
        },
        show(id) {
            this.id = id;
            this.$modal.show('resolve-modal');
        },
        hide() {
            this.id = '';
            this.$modal.hide('resolve-modal');
        },
        updateStatus(id) {
            axios.post('/api/update-observation-status/' + id, {reason: this.reason})
                .then((response) => {
                    this.reason = '';
                    this.getObservations(this.pagination.current_page);
                    this.flashMessage.success({
                        message: 'Observation resolved successfully',
                        time: 5000,
                        blockClass: 'custom-block-class'
                    });
                    this.hide();
                }).catch((error) => {
                console.log(error);
            })
        },
        deleteObservation(id) {
            if (confirm("Do you really want to delete observation?")) {
                axios.post('/api/delete-observation/' + id)
                    .then((response) => {
                        this.getObservations(this.pagination.current_page);
                        this.flashMessage.success({
                            message: 'Observation successfully deleted',
                            time: 5000,
                            blockClass: 'custom-block-class'
                        });
                    }).catch((error) => {
                    console.log(error);
                })
            }
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
            axios.get('/api/get-observations-products')
                .then((response) => {
                    this.products = response.data
                }).catch((error) => {
                console.log(error);
            })
        }
    },
    mounted() {
        this.getCompanies();
        this.getProducts();
        this.getObservations();
    }
}
</script>
