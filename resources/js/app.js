/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// import './bootstrap';
import Vue from 'vue';
window.axios = require('axios');
import Paginate from 'vuejs-paginate'
import FlashMessage from '@smartweb/vue-flash-message';
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import VModal from 'vue-js-modal/dist/index.nocss.js'
import 'vue-js-modal/dist/styles.css'

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

// const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
import ProjectComponent from './components/ProjectComponent';
import AddProjectComponent from './components/AddProjectComponent';
import CompanyComponent from './components/CompanyComponent.vue';
import AddCompanyComponent from './components/AddCompanyComponent.vue';
import SectorComponent from './components/SectorComponent.vue';
import AddSectorComponent from './components/AddSectorComponent.vue';
import ProductClassificationComponent from './components/ProductClassificationComponent.vue';
import AddProductClassificationComponent from './components/AddProductClassificationComponent.vue';
import ProductTypeComponent from './components/ProductTypeComponent.vue';
import AddProductTypeComponent from './components/AddProductTypeComponent.vue';
import ScholarComponent from './components/ScholarComponent.vue';
import AddScholarComponent from './components/AddScholarComponent.vue';
import LanguageComponent from './components/LanguageComponent.vue';
import AddLanguageComponent from './components/AddLanguageComponent.vue';
import ExcelExportComponent from './components/ExcelExportComponent';
import EmployeesComponent from './components/EmployeesComponent';
import AddEmployeeComponent from './components/AddEmployeeComponent';
import UsersComponent from './components/UsersComponent';
import AddUserComponent from './components/AddUserComponent';
import ProductDocumentsComponent from './components/ProductDocumentsComponent.vue';
import AddProductDocumentComponent from './components/AddProductDocumentComponent.vue';
import ProjectHistoryComponent from './components/ProjectHistoryComponent';
import AddDocumentsComponent from './components/AddDocumentsComponent';
import ObservationsComponent from './components/ObservationsComponent';
import AddObservationComponent from './components/AddObservationComponent';
import MMReportComponent from './components/MMReportComponent';
import ObservationHistoryComponent from './components/ObservationHistoryComponent';

Vue.component('example-component', ExampleComponent);
Vue.component('project-component', ProjectComponent);
Vue.component('add-project-component', AddProjectComponent);
Vue.component('company-component', CompanyComponent);
Vue.component('add-company-component', AddCompanyComponent);
Vue.component('sector-component', SectorComponent);
Vue.component('add-sector-component', AddSectorComponent);
Vue.component('product-classification-component', ProductClassificationComponent);
Vue.component('add-product-classification-component', AddProductClassificationComponent);
Vue.component('product-type-component', ProductTypeComponent);
Vue.component('add-product-type-component', AddProductTypeComponent);
Vue.component('scholar-component', ScholarComponent);
Vue.component('add-scholar-component', AddScholarComponent);
Vue.component('language-component', LanguageComponent);
Vue.component('add-language-component', AddLanguageComponent);
Vue.component('excel-export-component', ExcelExportComponent);
Vue.component('employees-component', EmployeesComponent);
Vue.component('add-employee-component', AddEmployeeComponent);
Vue.component('users-component', UsersComponent);
Vue.component('add-user-component', AddUserComponent);
Vue.component('product-documents-component', ProductDocumentsComponent);
Vue.component('add-product-document-component', AddProductDocumentComponent);
Vue.component('project-history-component', ProjectHistoryComponent);
Vue.component('add-documents-component', AddDocumentsComponent);
Vue.component('observations-component', ObservationsComponent);
Vue.component('add-observation-component', AddObservationComponent);
Vue.component('mm-report-component', MMReportComponent);
Vue.component('observation-history-component', ObservationHistoryComponent);

Vue.component('paginate', Paginate)
Vue.use(FlashMessage)
Vue.component("v-select", vSelect);
Vue.use(VModal)
Vue.use(require('vue-moment'));

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

const app = new Vue({
    el: '#app',
});
