<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="input-group rounded search-bar">
                    <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                           aria-describedby="search-addon" v-model="search" @input="getSectors(1)"/>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <a href="/admin/add-sector" class="btn btn-success add-project-btn">Add New Sector</a>
            </div>
        </div>
        <table class="table projects-table">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <!--                <th scope="col">Link</th>-->
                <th scope="col">Name</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="sector in sectors">
                <td>{{ sector.id }}</td>
                <td>{{ sector.name }}</td>
                <td>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <button type="button" class="btn btn-dark btn-sm custom-btn"
                                    @click="updateStatus(sector.id)">
                                {{ sector.status ? 'Disable' : 'Enable' }}
                            </button>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <a :href="'/admin/edit-sector/' + sector.id"
                               class="btn btn-primary btn-sm custom-btn custom-btn-top">Edit</a>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <button type="button" class="btn btn-secondary btn-sm custom-btn custom-btn-top"
                                    @click="deleteSector(sector.id)">Delete
                            </button>
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <div v-if="sectors.length && pagination.last_page > 1" style="text-align: center">
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
            sectors: [],
            pagination: [],
            search: ''
        }
    },
    methods: {
        getSectors(page = 1) {
            let params = '?page=' + page;
            if (this.search.length) {
                params += '&search=' + this.search;
            }
            axios.get('/api/get-sectors' + params)
                .then((response) => {
                    this.sectors = response.data.data;
                    // console.log(this.sectors);
                    this.pagination = response.data;
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        clickCallback(page) {
            this.getSectors(page);
        },
        deleteSector(id) {
            if (confirm("Do you really want to delete sector?")) {
                axios.post('/api/delete-sector/' + id)
                    .then((response) => {
                        this.getSectors(this.pagination.current_page);
                        this.flashMessage.success({
                            message: 'Sector successfully deleted',
                            time: 5000,
                            blockClass: 'custom-block-class'
                        });
                    }).catch((error) => {
                    console.log(error);
                })
            }
        },
        updateStatus(id) {
            axios.post('/api/update-sector-status/' + id)
                .then((response) => {
                    this.getSectors(this.pagination.current_page);
                    this.flashMessage.success({
                        message: 'Sector status successfully updated',
                        time: 5000,
                        blockClass: 'custom-block-class'
                    });
                }).catch((error) => {
                console.log(error);
            })
        }
    },
    mounted() {
        this.getSectors();
    }
}
</script>

