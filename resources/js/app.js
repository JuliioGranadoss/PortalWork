import './bootstrap';
import './sb-admin-2';
import.meta.glob(['../img/**',]);

import { createApp } from 'vue';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

const app = createApp({});

import ConfigCrud from './components/ConfigCrud.vue';
import UserCrud from './components/UserCrud.vue';
import FileCrud from './components/FileCrud.vue';
import IncidentCrud from './components/IncidentCrud.vue';
import WorkerCrud from './components/WorkerCrud.vue';

app.component('config-crud', ConfigCrud);
app.component('user-crud', UserCrud);
app.component('file-crud', FileCrud);
app.component('incident-crud', IncidentCrud);
app.component('worker-crud', WorkerCrud);

app.use(VueSweetalert2);
app.mount('#app');

const profile = createApp({});

import ProfileCrud from './components/ProfileCrud.vue';

profile.component('profile-crud', ProfileCrud);

profile.use(VueSweetalert2);
profile.mount('#profile');

