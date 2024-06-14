<template>
    <div class="row mb-3 no-gutters">
        <div class="col-md-12">
            <h5 class="border-bottom">Filtros</h5>
        </div>
        <div class="form-group pl-2">
            <label><strong>Lugar:</strong></label>
            <select id="place" class="form-control" v-model="selectedPlace">
                <option value="">Selecciona lugar</option>
                <option v-for="place in places" :value="place.id" :key="place.id">
                    {{ place.name }}
                </option>
            </select>
        </div>
        <div class="form-group pl-2">
            <label><strong>Personal:</strong></label>
            <select id="personal" class="form-control" v-model="selectedPersonal">
                <option value="">Selecciona personal</option>
                <option v-for="personal in personals" :value="personal.id" :key="personal.id">
                    {{ personal.name }} {{ personal.surname }}
                </option>
            </select>
        </div>
        <div class="form-group pl-2">
            <label><strong>Fecha:</strong></label>
            <flat-pickr class="form-control" v-model="selectedDateRange" :config="datePickerConfig" placeholder="Selecciona dos fechas"></flat-pickr>
        </div>
    </div>
</template>

<script>
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';

export default {
    components: {
      flatPickr
    },
    data() {
        return {
            places: [],
            personals: [],
            selectedPlace: "",
            selectedPersonal: "",
            selectedDateRange: "",
            datePickerConfig: {
            mode: "range",
            dateFormat: "Y-m-d"
            }
        };
    },
    watch: {
        selectedPlace() {
            $('#stock-movement-table').DataTable().columns(1).search(this.selectedPlace).draw();
        },
        selectedPersonal() {
            $('#stock-movement-table').DataTable().columns(2).search(this.selectedPersonal).draw();
        },
        selectedDateRange() {
            $('#stock-movement-table').DataTable().columns(3).search(this.selectedDateRange).draw();
        }
    },
    methods: {
        getPlaces() {
            axios.get('/stockplaces/get/data')
                .then(response => {
                    this.places = response.data;
                })
                .catch(error => {
                    console.error('Error al obtener los lugares:', error);
                });
        },
        getPersonal() {
            axios.get('/stockpersonals/get/data')
                .then(response => {
                    this.personals = response.data;
                })
                .catch(error => {
                    console.error('Error al obtener el personal:', error);
                });
        },
    },
    mounted() {
        this.getPlaces();
        this.getPersonal();
    }
};
</script>
