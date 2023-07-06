<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="input-group rounded search-bar">
                    <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                           aria-describedby="search-addon" v-model="search" @input="getEmployees(1)"/>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <a href="/admin/add-employee" class="btn btn-success add-project-btn">Add New Employee</a>
            </div>
        </div>
        <table class="table projects-table">
            <thead>
            <tr>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Short Name</th>
                <th scope="col">Description</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="employee in employees">
                <td>{{ employee.first_name }}</td>
                <td>{{ employee.last_name }}</td>
                <td>{{ employee.short_name ? employee.short_name : 'N/A' }}</td>
                <td v-if="employee.description" v-html="employee.description"></td>
                <td v-else>N/A</td>
                <td>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <button type="button" class="btn btn-dark btn-sm custom-btn" @click="updateStatus(employee.id)">
                                {{ employee.status ? 'Disable' : 'Enable' }}
                            </button>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <a :href="'/admin/edit-employee/' + employee.id" class="btn btn-primary btn-sm custom-btn custom-btn-top">Edit</a>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <button type="button" class="btn btn-secondary btn-sm custom-btn custom-btn-top" @click="deleteEmployee(employee.id)">
                                Delete
                            </button>
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <div v-if="employees.length && pagination.last_page > 1" style="text-align: center">
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
            employees: [],
            pagination: [],
            search: ''
        }
    },
    methods: {
        getEmployees(page = 1) {
            let params = '?page=' + page;
            if (this.search.length) {
                params += '&search=' + this.search;
            }
            axios.get('/api/get-employees' + params)
                .then((response) => {
                    this.employees = response.data.data;
                    this.pagination = response.data;
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        clickCallback(page) {
            this.getEmployees(page);
        },
        deleteEmployee(id) {
            if (confirm("Do you really want to delete employee?")) {
                axios.post('/api/delete-employee/' + id)
                    .then((response) => {
                        this.getEmployees(this.pagination.current_page);
                        this.flashMessage.success({
                            message: 'Employee successfully deleted',
                            time: 5000,
                            blockClass: 'custom-block-class'
                        });
                    }).catch((error) => {
                    console.log(error);
                })
            }
        },
        updateStatus(id) {
            axios.post('/api/update-employee-status/' + id)
                .then((response) => {
                    this.getEmployees(this.pagination.current_page);
                    this.flashMessage.success({
                        message: 'Employee status successfully updated',
                        time: 5000,
                        blockClass: 'custom-block-class'
                    });
                }).catch((error) => {
                console.log(error);
            })
        }
    },
    mounted() {
        this.getEmployees();
    }
}
</script>
