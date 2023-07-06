<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="input-group rounded search-bar">
                    <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                           aria-describedby="search-addon" v-model="search" @input="getCompanies(1)"/>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <a href="/admin/add-company" class="btn btn-success add-project-btn">Add New Client</a>
            </div>
        </div>
        <table class="table projects-table">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Link</th>
                <th scope="col">Name</th>
                <th scope="col">Subject</th>
                <th scope="col">Description</th>
                <th scope="col">Attachments</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="company in companies">
                <td>{{ company.id }}</td>
                <td><a target="_blank" :href="'/admin/projects/' + company.id">Projects</a></td>
                <td>{{ company.name }}</td>
                <td>{{ company.short_name }}</td>
                <td v-html="company.description"></td>
                <td>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <button
                                v-if="company.picture && company.picture != 'n/a'"
                                type="button" class="btn btn-primary btn-sm" style="width: 156px"
                                @click="deleteTermination(company.id)">Delete Termination
                            </button>
                        </div>
                    </div>
                    {{ !(company.picture && company.picture != 'n/a') ? 'N/A' : '' }}
                </td>


                <!--                <td><a :href="project.link">Link</a><br>{{ project.certificate_number }}</td>-->
                <!--                <td>{{ project.sector ? project.sector.name : '' }} / {{-->
                <!--                        project.product_classification ?-->
                <!--                            project.product_classification.name : ''-->
                <!--                    }}-->
                <!--                </td>-->
                <!--                <td>{{-->
                <!--                        project.kind_of_prod ? project.kind_of_prod.name : (project.kind_of_product ?-->
                <!--                            project.kind_of_product : 'N/A')-->
                <!--                    }}-->
                <!--                </td>-->
                <!--                <td>{{ project.product ? project.product : 'N/A' }}</td>-->
                <!--                <td>{{ project.product_document ? project.product_document : 'N/A' }}</td>-->
                <!--                <td>{{ scholar(project.scholar_1, project.scholar_2, project.scholar_3, project.scholar_4) }}</td>-->
                <!--                <td>{{ project.date_completed }}</td>-->
                <!--                <td>-->
                <!--                    <button-->
                <!--                        v-if="project.certificates && project.certificates.certificate_1 && project.certificates.certificate_1 != 'n/a'"-->
                <!--                        type="button" class="btn btn-primary"-->
                <!--                        @click="deleteCertification(project.certificates.project_certificate_id)">Delete-->
                <!--                        Certification-->
                <!--                    </button>-->
                <!--                    <button v-if="project.certificates && project.certificates.certificate_2" type="button"-->
                <!--                            class="btn btn-secondary"-->
                <!--                            style="margin-top: 10px;"-->
                <!--                            @click="deleteTermination(project.certificates.project_certificate_id)">Delete Termination-->
                <!--                    </button>-->
                <!--                    {{-->
                <!--                        !(project.certificates && project.certificates.certificate_1 && project.certificates.certificate_1-->
                <!--                            != 'n/a') &&-->
                <!--                        !(project.certificates && project.certificates.certificate_2) ? 'N/A' : ''-->
                <!--                    }}-->
                <!--                </td>-->
                <td>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <button type="button" class="btn btn-dark btn-sm" style="width: 78px"
                                    @click="updateStatus(company.id)">
                                {{ company.status == 1 ? 'Disable' : 'Enable' }}
                            </button>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <a :href="'/admin/edit-company/' + company.id" class="btn btn-primary btn-sm"
                               style="margin-top: 10px; width: 78px;">Edit</a>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <button type="button" class="btn btn-secondary btn-sm"
                                    style="margin-top: 10px; width: 78px;"
                                    @click="deleteCompany(company.id)">Delete
                            </button>
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <div v-if="companies.length && pagination.last_page > 1" style="text-align: center">
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
            companies: [],
            pagination: [],
            search: ''
        }
    },
    methods: {
        getCompanies(page = 1) {
            let params = '?page=' + page;
            if (this.search.length) {
                params += '&search=' + this.search;
            }
            axios.get('/api/get-companies' + params)
                .then((response) => {
                    this.companies = response.data.data;
                    this.pagination = response.data;
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        clickCallback(page) {
            this.getCompanies(page);
        },
        // deleteCertification(id) {
        //     if (confirm("Do you really want to delete certification?")) {
        //         axios.post('/api/delete-certification', {
        //             'id': id,
        //         }).then((response) => {
        //             this.getCompanies(this.pagination.current_page);
        //             this.flashMessage.success({
        //                 message: 'Certificate successfully deleted',
        //                 time: 5000,
        //                 blockClass: 'custom-block-class'
        //             });
        //         }).catch((error) => {
        //             console.log(error);
        //         })
        //     }
        // },
        // deleteTermination(id) {
        //     if (confirm("Do you really want to delete termination?")) {
        //         axios.post('/api/delete-termination', {
        //             'id': id,
        //         }).then((response) => {
        //             this.getCompanies(this.pagination.current_page);
        //             this.flashMessage.success({
        //                 message: 'Termination successfully deleted',
        //                 time: 5000,
        //                 blockClass: 'custom-block-class'
        //             });
        //         }).catch((error) => {
        //             console.log(error);
        //         })
        //     }
        // },
        // scholar(s1, s2, s3, s4) {
        //     let name = '';
        //     if (s1 !== null) {
        //         name = s1.first_name + '' + s1.last_name
        //     }
        //     if (s2 !== null) {
        //         if (name) {
        //             name += ', ';
        //         }
        //         name += s2.first_name + '' + s2.last_name
        //     }
        //     if (s3 !== null) {
        //         if (name) {
        //             name += ', ';
        //         }
        //         name += s3.first_name + '' + s3.last_name
        //     }
        //     if (s4 !== null) {
        //         if (name) {
        //             name += ', ';
        //         }
        //         name += s4.first_name + '' + s4.last_name
        //     }
        //     return name;
        // },
        deleteCompany(id) {
            if (confirm("Do you really want to delete client?")) {
                axios.post('/api/delete-company/' + id)
                    .then((response) => {
                        this.getCompanies(this.pagination.current_page);
                        this.flashMessage.success({
                            message: 'Client successfully deleted',
                            time: 5000,
                            blockClass: 'custom-block-class'
                        });
                    }).catch((error) => {
                    console.log(error);
                })
            }
        },
        updateStatus(id) {
            axios.post('/api/update-company-status/' + id)
                .then((response) => {
                    this.getCompanies(this.pagination.current_page);
                    this.flashMessage.success({
                        message: 'Client status successfully updated',
                        time: 5000,
                        blockClass: 'custom-block-class'
                    });
                }).catch((error) => {
                console.log(error);
            })
        },
        deleteTermination(id) {
            if (confirm("Do you really want to delete termination?")) {
                axios.post('/api/delete-company-termination/' + id)
                    .then((response) => {
                        this.getCompanies(this.pagination.current_page);
                        this.flashMessage.success({
                            message: 'Termination successfully deleted',
                            time: 5000,
                            blockClass: 'custom-block-class'
                        });
                    }).catch((error) => {
                    console.log(error);
                })
            }
        },
    },
    mounted() {
        this.getCompanies();
    }
}
// export default {
//     name: "Company"
// }
</script>

<!--<style scoped>-->

<!--</style>-->
