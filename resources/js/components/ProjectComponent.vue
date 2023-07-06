<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="input-group rounded search-bar">
                    <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                           aria-describedby="search-addon" v-model="search" @input="getProjects(1)"/>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <a href="/admin/add-project" class="btn btn-success add-project-btn">Add New Project</a>
            </div>
        </div>
        <table class="table projects-table">
            <thead>
            <tr>
                <th scope="col">Client Name</th>
                <th scope="col">Certificate Number</th>
                <th scope="col">Sector / Product Classification</th>
                <th scope="col">Product Type</th>
                <th scope="col">Product Name</th>
                <th scope="col">Product Documents</th>
                <th scope="col">Scholars</th>
                <th scope="col">Status</th>
                <th scope="col">Date Completed</th>
                <th scope="col">Attachment</th>
                <th scope="col">Action</th>
                <th scope="col">More Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="project in projects">
                <td>{{ project.company.name }}</td>
                <td>{{ project.certificate_number }}</td>
                <td>{{ project.sector ? project.sector.name : '' }} / {{
                        project.product_classification ?
                            project.product_classification.name : ''
                    }}
                </td>
                <td>{{
                        project.kind_of_prod ? project.kind_of_prod.name : (project.kind_of_product ?
                            project.kind_of_product : 'N/A')
                    }}
                </td>
                <td>{{ project.product ? project.product : 'N/A' }}</td>
                <td>{{ documents(project.documents) }}</td>
                <td>{{ scholar(project.scholars) }}</td>
                <td>{{ project.status ? project.status : 'N/A' }}</td>
                <td>{{ project.date_completed }}</td>
                <td>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <button v-if="project.certificates && project.certificates.certificate_1 && project.certificates.certificate_1 != 'n/a'" type="button"
                                    class="btn btn-primary btn-sm"
                                    style="margin-top: 10px; width: 156px"
                                    @click="deleteCertification(project.certificates.project_certificate_id)">Delete
                                Certificate
                            </button>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <button v-if="project.certificates && project.certificates.certificate_2" type="button"
                                    class="btn btn-secondary btn-sm"
                                    style="margin-top: 10px; width: 156px"
                                    @click="deleteTermination(project.certificates.project_certificate_id)">Delete
                                Termination
                            </button>
                        </div>
                    </div>
                    {{ !(project.certificates && project.certificates.certificate_1 && project.certificates.certificate_1 != 'n/a') && !(project.certificates && project.certificates.certificate_2) ? 'N/A' : '' }}
                </td>
                <td>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <a :href="'/admin/send-certificate/' + project.project_id + '/' + cert_num(project.certificate_number) + '/null/true'"
                                       class="btn btn-dark btn-sm custom-btn" style="width: 170px">Download
                                        Certificate</a>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <a @click="sendCertificate(project.project_id, project.certificate_number)"
                                       class="btn btn-warning btn-sm custom-btn custom-btn-top" style="width: 170px">Send
                                        Certificate</a>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <a :href="'/admin/project-history/' + project.project_id"
                                       class="btn btn-primary btn-sm custom-btn custom-btn-top"
                                       style="width: 170px">History</a>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <a :href="'/admin/edit-project/' + project.project_id + '/true'"
                                       class="btn btn-secondary btn-sm custom-btn custom-btn-top"
                                       style="width: 170px">Duplicate</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <a :href="'/admin/add-documents/' + project.project_id + '/add'"
                                   class="btn btn-dark btn-sm custom-btn" style="width: 170px">Add Documents</a>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <a :href="'/admin/add-documents/' + project.project_id + '/amend'"
                                   class="btn btn-warning btn-sm custom-btn custom-btn-top" style="width: 170px">Amend Documents</a>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <a :href="'/admin/edit-project/' + project.project_id"
                                   class="btn btn-primary btn-sm custom-btn custom-btn-top" style="width: 170px">Edit</a>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <button type="button" class="btn btn-secondary btn-sm custom-btn custom-btn-top"
                                        style="width: 170px" @click="deleteProject(project.project_id)">Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <h3 v-if="!projects.length" style="text-align: center; padding: 3%">No Projects</h3>
        <div v-if="projects.length && pagination.last_page > 1" style="text-align: center">
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
    props: ['id', 'user_id', 'data', 'year_range_1', 'year_range_2'],
    data() {
        return {
            projects: [],
            pagination: [],
            search: ''
        }
    },
    methods: {
        getProjects(page = 1) {
            let params = '?page=' + page + '&id=' + this.id + '&user_id=' + this.user_id;
            if (this.search.length) {
                params += '&search=' + this.search;
            }
            if (this.data && this.data.sector_id) {
                params += '&sector_id=' + this.data && this.data.sector_id;
            }
            if (this.data && this.data.product_classification_id) {
                params += '&product_classification_id=' + this.data && this.data.product_classification_id;
            }
            if (this.data && this.data.company_client) {
                params += '&company_client=' + this.data && this.data.company_client;
            }
            if (this.data && this.data.kind_of_product) {
                params += '&kind_of_product=' + this.data && this.data.kind_of_product;
            }
            if (this.data && this.data.scholar_id) {
                params += '&scholar_id=' + this.data && this.data.scholar_id;
            }
            if (this.data && this.data.year) {
                params += '&year=' + this.data && this.data.year;
            }
            if (this.year_range_1 && this.year_range_2) {
                params += '&year_range_1=' + this.year_range_1 + '&year_range_2=' + this.year_range_2;
            }
            axios.get('/api/get-projects' + params)
                .then((response) => {
                    this.projects = response.data.data;
                    this.pagination = response.data;
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        clickCallback(page) {
            this.getProjects(page);
        },
        deleteCertification(id) {
            if (confirm("Do you really want to delete certification?")) {
                axios.post('/api/delete-certification', {
                    'id': id,
                }).then((response) => {
                    this.getProjects(this.pagination.current_page);
                    this.flashMessage.success({
                        message: 'Certificate successfully deleted',
                        time: 5000,
                        blockClass: 'custom-block-class'
                    });
                }).catch((error) => {
                    console.log(error);
                })
            }
        },
        deleteTermination(id) {
            if (confirm("Do you really want to delete termination?")) {
                axios.post('/api/delete-termination', {
                    'id': id,
                }).then((response) => {
                    this.getProjects(this.pagination.current_page);
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
        scholar(scholars) {
            let name = '';
            for (let i = 0; i < scholars.length; i++) {
                if (name) {
                    name += ', ';
                }
                name += scholars[i].name
            }
            return name;
        },
        documents(docs) {
            let name = '';
            for (let i = 0; i < docs.length; i++) {
                if (name) {
                    name += ', ';
                }
                name += docs[i].name
            }
            return name ? name : 'N/A';
        },
        deleteProject(id) {
            if (confirm("Do you really want to delete project?")) {
                axios.post('/api/delete-project/' + id)
                    .then((response) => {
                        this.getProjects(this.pagination.current_page);
                        this.flashMessage.success({
                            message: 'Project successfully deleted',
                            time: 5000,
                            blockClass: 'custom-block-class'
                        });
                    }).catch((error) => {
                    console.log(error);
                })
            }
        },
        cert_num(number) {
          if (number) {
            return number.replace("#", "%23");
          }
        },
        sendCertificate(id, number) {
            if (confirm("Do you really want to send certificate for signature?")) {
                axios.get('/api/check-signature/' + id)
                    .then((response) => {
                        if (response.data) {
                            if (confirm("The following scholars signature exists. Do you want to send certificate to these scholars?\n\n" + response.data +
                                "\n\nNOTE: By clicking 'Cancel', the certificate will be sent to the scholars who do not have signature uploaded.")) {
                                location.replace("/admin/send-certificate/" + id + "/" + this.cert_num(number) + "/" + true + "/" + false + "/" + true);
                            } else {
                                location.replace("/admin/send-certificate/" + id + "/" + this.cert_num(number) + "/" + true);
                            }
                        } else {
                            location.replace("/admin/send-certificate/" + id + "/" + this.cert_num(number) + "/" + true);
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    })
            }
        }
    },
    mounted() {
        this.getProjects();
    }
}
</script>
