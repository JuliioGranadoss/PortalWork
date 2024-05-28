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
            <input type="date" id="updated_at" class="form-control" v-model="selectedDate">
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            places: [],
            personals: [],
            selectedPlace: "",
            selectedPersonal: "",
            selectedDate: ""
        };
    },
    watch: {
        selectedPlace() {
            $('#stock-history-table').DataTable().columns(2).search(this.selectedPlace).draw();
        },
        selectedPersonal() {
            $('#stock-history-table').DataTable().columns(3).search(this.selectedPersonal).draw();
        },
        selectedDate() {
            $('#stock-history-table').DataTable().columns(6).search(this.selectedDate).draw();
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
