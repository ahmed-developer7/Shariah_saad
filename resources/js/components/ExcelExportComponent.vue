<template>
    <div class="container-fluid add-project">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <label>Sectors</label>
                <v-select v-if="projectData" placeholder="Select sector" :options="projectData.sectors"
                          v-model="data.sector_id" label="name" :reduce="referrer => referrer.id" @input="forceRerender"></v-select>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <label>Product Classifications</label>
                <v-select v-if="projectData" placeholder="Select product classification"
                          :options="projectData.product_classification" v-model="data.product_classification_id"
                          label="name" :reduce="referrer => referrer.id" @input="forceRerender"></v-select>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <label>Client Name</label>
                <v-select v-if="projectData" placeholder="Select client" :options="projectData.companies"
                          v-model="data.company_client" label="name" :reduce="referrer => referrer.id" @input="forceRerender"></v-select>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <label>Type of Product</label>
                <v-select v-if="projectData" placeholder="Select type of product"
                          :options="projectData.kind_of_products" v-model="data.kind_of_product" label="name"
                          :reduce="referrer => referrer.id" @input="forceRerender"></v-select>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <label>Scholars</label>
                <v-select v-if="projectData" placeholder="Select scholar" :options="projectData.scholars"
                          v-model="data.scholar_id" label="name" :reduce="referrer => referrer.id" @input="forceRerender"></v-select>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <label>Year</label>
                <v-select placeholder="Select year" :options="years" v-model="data.year" @input="forceRerender"></v-select>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <label style="display: block">Year Range</label>
                <date-picker type="year" defaultValue="2005" rangeSeparator="-" placeholder="Select year range"
                             v-model="data.year_range" @input="setDateRange()" range></date-picker>
            </div>
        </div>
        <button type="button" class="btn btn-primary submit" @click="exportData">Export</button>
        <template v-if="show">
            <h2 style="margin-top: 50px">Projects</h2>
            <project-component :key="componentKey" :id="id" :user_id="user_id" :data="data" :year_range_1="year_range_1" :year_range_2="year_range_2"></project-component>
        </template>
        <FlashMessage :position="'right top'"></FlashMessage>
    </div>
</template>

<script>
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import moment from 'moment';

export default {
    props: ['id', 'user_id'],
    data() {
        return {
            projectData: null,
            data: [],
            year_range_1: '',
            year_range_2: '',
            show: false,
            componentKey: 0
        }
    },
    methods: {
        exportData() {
            let url = "/api/excel-export";
            if (this.data.sector_id) {
                url += '?sector_id=' + this.data.sector_id;
            } else {
                url += "?sector_id=";
            }
            if (this.data.product_classification_id) {
                url += '&product_classification_id=' + this.data.product_classification_id;
            }
            if (this.data.company_client) {
                url += '&company_client=' + this.data.company_client;
            }
            if (this.data.kind_of_product) {
                url += '&kind_of_product=' + this.data.kind_of_product;
            }
            if (this.data.scholar_id) {
                url += '&scholar_id=' + this.data.scholar_id;
            }
            if (this.data.year) {
                url += '&year=' + this.data.year;
            }
            if (this.data.year_range) {
                url += '&year_range_1=' + this.year_range_1 + '&year_range_2=' + this.year_range_2;
            }
            location.href = url;
        },
        getProjectData() {
            axios.get('/api/get-project-data/true')
                .then((response) => {
                    this.projectData = response.data;
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        setDateRange() {
            this.year_range_1 = moment(this.data.year_range[0]).year();
            this.year_range_2 = moment(this.data.year_range[1]).year();
            this.forceRerender()
        },
        forceRerender() {
            this.show = true;
            this.componentKey += 1;
        }
    },
    mounted() {
        this.getProjectData();
    },
    computed: {
        years() {
            let data = [];
            data.push('All years');
            for (let i = 2005; i <= new Date().getFullYear(); i++) {
                data.push(i);
            }
            return data;
        }
    },
    components: {DatePicker}
}
</script>
