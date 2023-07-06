<template>
    <div class="container-fluid add-project">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <label>Client</label>
                <v-select v-if="companies" placeholder="Select client" :options="companies"
                          v-model="data.company_id" label="name" :reduce="referrer => referrer.id"></v-select>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <label>Year</label>
                <v-select placeholder="Select year" :options="years" v-model="data.year"></v-select>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <label>Quarter</label>
                <v-select placeholder="Select quarter" :options="['Q1', 'Q2', 'Q3', 'Q4', 'First Six Months', 'Last Six Months', 'Full Year']"
                          v-model="data.quarter"></v-select>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <label>Language</label>
                <v-select placeholder="Select language" :options="['English', 'Arabic']" v-model="data.language"></v-select>
            </div>
        </div>
        <button type="button" class="btn btn-primary submit" @click="generateMMReport">Generate</button>
        <FlashMessage :position="'right top'"></FlashMessage>
    </div>
</template>

<script>
export default {
    data() {
        return {
            data: [],
            companies: []
        }
    },
    methods: {
        generateMMReport() {
            if (!this.data.company_id || !this.data.year || !this.data.quarter || !this.data.language) {
                this.flashMessage.error({
                    message: 'All fields required',
                    time: 5000,
                    blockClass: 'custom-block-class'
                });
                return;
            }
            let url = "/api/generate-mm-report";
            if (this.data.company_id) {
                url += '?company_id=' + this.data.company_id;
            }
            if (this.data.year) {
                url += '&year=' + this.data.year;
            }
            if (this.data.quarter) {
                url += '&quarter=' + this.data.quarter;
            }
            if (this.data.language) {
                url += '&language=' + this.data.language;
            }
            location.href = url;
        },
        getCompanies() {
            axios.get('/api/get-observations-companies')
                .then((response) => {
                    this.companies = response.data
                }).catch((error) => {
                console.log(error);
            })
        }
    },
    mounted() {
        this.getCompanies();
    },
    computed: {
        years() {
            let data = [];
            for (let i = 2005; i <= new Date().getFullYear(); i++) {
                data.push(i);
            }
            return data;
        }
    }
}
</script>
