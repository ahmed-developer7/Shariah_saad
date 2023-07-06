<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="input-group rounded search-bar">
                    <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                           aria-describedby="search-addon" v-model="search" @input="getProjectHistory(1)"/>
                </div>
            </div>
        </div>
        <table class="table projects-table">
            <thead>
            <tr>
                <th scope="col">Field</th>
                <th scope="col">Original</th>
                <th scope="col">Changed</th>
                <th scope="col">Created at</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="history in projectHistory">
                <td>{{ history.field }}</td>
                <td>{{ history.original_value ? history.original_value : '-' }}</td>
                <td>{{ history.changed_value ? history.changed_value : '-' }}</td>
                <td>{{ history.created_at | moment("dddd, MMMM Do YYYY, h:mm:ss a")}}</td>
            </tr>
            </tbody>
        </table>
        <h3 v-if="!projectHistory.length" style="text-align: center; padding: 3%">Empty Project History</h3>
        <div v-if="projectHistory.length && pagination.last_page > 1" style="text-align: center">
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
    </div>
</template>

<script>

export default {
    props: ['id'],
    data() {
        return {
            projectHistory: [],
            pagination: [],
            search: ''
        }
    },
    methods: {
        getProjectHistory(page = 1) {
            let params = '?page=' + page;
            if (this.search.length) {
                params += '&search=' + this.search;
            }
            axios.get('/api/get-project-history/' + this.id + params)
                .then((response) => {
                    this.projectHistory = response.data.data;
                    this.pagination = response.data;
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        clickCallback(page) {
            this.getProjectHistory(page);
        }
    },
    mounted() {
        this.getProjectHistory();
    }
}
</script>
