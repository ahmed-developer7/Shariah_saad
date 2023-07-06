<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="input-group rounded search-bar">
                    <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                           aria-describedby="search-addon" v-model="search" @input="getUsers(1)"/>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <a href="/admin/add-user" class="btn btn-success add-project-btn">Add New User</a>
            </div>
        </div>
        <table class="table projects-table">
            <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">User Type</th>
                <th scope="col">Description</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="user in users">
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.usertype }}</td>
                <td v-html="user.description"></td>
                <td>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <button type="button" class="btn btn-dark btn-sm custom-btn user-btn"
                                    @click="updateStatus(user.id)">
                                {{ user.status == 1 ? 'Disable' : 'Enable' }}
                            </button>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <a :href="'/admin/update-user-password/' + user.id"
                               class="btn btn-warning btn-sm custom-btn custom-btn-top user-btn">Update Password</a>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <a :href="'/admin/edit-user/' + user.id"
                               class="btn btn-primary btn-sm custom-btn custom-btn-top user-btn">Edit</a>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <button type="button" class="btn btn-secondary btn-sm custom-btn custom-btn-top user-btn"
                                    @click="deleteUser(user.id)">
                                Delete
                            </button>
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <div v-if="users.length && pagination.last_page > 1" style="text-align: center">
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
            users: [],
            pagination: [],
            search: ''
        }
    },
    methods: {
        getUsers(page = 1) {
            let params = '?page=' + page;
            if (this.search.length) {
                params += '&search=' + this.search;
            }
            axios.get('/api/get-users' + params)
                .then((response) => {
                    this.users = response.data.data;
                    this.pagination = response.data;
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        clickCallback(page) {
            this.getUsers(page);
        },
        deleteUser(id) {
            if (confirm("Do you really want to delete user?")) {
                axios.post('/api/delete-user/' + id)
                    .then((response) => {
                        this.getUsers(this.pagination.current_page);
                        this.flashMessage.success({
                            message: 'User successfully deleted',
                            time: 5000,
                            blockClass: 'custom-block-class'
                        });
                    }).catch((error) => {
                    console.log(error);
                })
            }
        },
        updateStatus(id) {
            axios.post('/api/update-user-status/' + id)
                .then((response) => {
                    this.getUsers(this.pagination.current_page);
                    this.flashMessage.success({
                        message: 'User status successfully updated',
                        time: 5000,
                        blockClass: 'custom-block-class'
                    });
                }).catch((error) => {
                console.log(error);
            })
        }
    },
    mounted() {
        this.getUsers();
    }
}
</script>
