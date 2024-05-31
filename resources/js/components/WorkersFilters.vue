<template>
    <div class="row mb-3 no-gutters">
        <div class="col-md-12">
            <h5 class="border-bottom">Filtros</h5>
        </div>
        <div class="form-group pl-2">
            <label><strong>Bolsa de trabajo:</strong></label>
            <select id="jobboard" class="form-control" v-model="selectedJobboard">
                <option value="">Selecciona una bolsa de trabajo</option>
                <option v-for="jobboard in jobboards" :value="jobboard.id" :key="jobboard.id">
                    {{ jobboard.name }}
                </option>
            </select>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            jobboards: [],
            selectedJobboard: '',
        };
    },
    watch: {
        selectedJobboard(newValue) {
            $('#worker-table').DataTable().columns(9).search(newValue).draw();
        },
    },
    methods: {
        getJobBoards() {
            axios.get('/jobboards/get/data')
                .then(response => {
                    this.jobboards = response.data;
                })
                .catch(error => {
                    console.error('Error al obtener las bolsas de trabajo:', error);
                });
        }
    },
    mounted() {
        this.getJobBoards();
    },
};
</script>