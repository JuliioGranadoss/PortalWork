import './bootstrap';
import './sb-admin-2';
import.meta.glob(['../img/**',]);
import 'vue-select/dist/vue-select.css';

import { createApp } from 'vue';
import VueSweetalert2 from 'vue-sweetalert2';
import vSelect from 'vue-select'
import 'sweetalert2/dist/sweetalert2.min.css';
import moment from 'moment';

const app = createApp({});

import ConfigCrud from './components/ConfigCrud.vue';
import UserCrud from './components/UserCrud.vue';
import FileCrud from './components/FileCrud.vue';
import IncidentCrud from './components/IncidentCrud.vue';
import WorkerCrud from './components/WorkerCrud.vue';
import OfferCrud from './components/OfferCrud.vue';
import DegreeCrud from './components/DegreeCrud.vue';
import ExperienceCrud from './components/ExperienceCrud.vue';
import OtherCrud from './components/OtherCrud.vue';
import JobCrud from './components/JobCrud.vue';
import WorkerOffer from './components/WorkerOfferCrud.vue';
import ProviderCrud from './components/ProviderCrud.vue';
import CategoryCrud from './components/CategoryCrud.vue';
import ProductCrud from './components/ProductCrud.vue';
import StockHistoryCrud from './components/StockHistoryCrud.vue';
import BarcodeCrud from './components/BarcodeCrud.vue';
import CategoryProductCrud from './components/CategoryProductCrud.vue';
import ProductStock from './components/ProductStock.vue';

app.component('config-crud', ConfigCrud);
app.component('user-crud', UserCrud);
app.component('file-crud', FileCrud);
app.component('incident-crud', IncidentCrud);
app.component('worker-crud', WorkerCrud);
app.component('offer-crud', OfferCrud);
app.component('degree-crud', DegreeCrud);
app.component('experience-crud', ExperienceCrud);
app.component('other-crud', OtherCrud);
app.component('job-crud', JobCrud);
app.component('workeroffer-crud', WorkerOffer);
app.component('provider-crud', ProviderCrud);
app.component('category-crud', CategoryCrud);
app.component('product-crud', ProductCrud);
app.component('stockhistory-crud', StockHistoryCrud);
app.component('barcode-crud', BarcodeCrud);
app.component('categoryproduct-crud', CategoryProductCrud);
app.component('product-stock', ProductStock);

app.component("v-select", vSelect)

app.use(VueSweetalert2);
app.use(moment);
app.mount('#app');

const profile = createApp({});

import ProfileCrud from './components/ProfileCrud.vue';

profile.component('profile-crud', ProfileCrud);

profile.use(VueSweetalert2);
profile.mount('#profile');

