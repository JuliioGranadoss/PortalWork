<template>
    <div class="modal fade" id="ajaxDegree" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">{{ title }}</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="checkBeforeSubmit" id="degreeForm" name="degreeForm" class="form-horizontal">
                        <div v-if="alert" class="card bg-danger text-white shadow m-2">
                            <div class="card-body p-3">
                                Alerta
                                <div class="text-white-50 small">{{ alert }}</div>
                            </div>
                        </div>
                        <input type="hidden" name="id" v-model="model.id">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="degreetitles" class="control-label">Título*</label>
                                <v-select label="name" :reduce="degreetitles => degreetitles.name" v-model="model.name"
                                    :options="degreetitles" required></v-select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="institution" class="control-label">Institución*</label>
                                <input type="text" class="form-control" v-model="model.institution" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="start" class="control-label">Fecha de inicio*</label>
                                <input type="date" class="form-control" v-model="model.start" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="end" class="control-label">Fecha de fin*</label>
                                <input type="date" class="form-control" v-model="model.end" required>
                            </div>
                        </div>

                        <div class="col-sm-12 text-right">
                            <button type="submit" class="btn btn-primary" v-bind:disabled="disable">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            title: [],
            alert: null,
            disable: false,
            degreetitles: [],
            model: {
                id: null,
                worker_id: $('#worker_id').val(),
                name: null,
                institution: null,
                start: null,
                end: null,
            }
        }
    },
    methods: {
        submit() {
            let self = this;
            this.disable = true;
            axios.post('/degrees', this.model)
                .then(function (response) {
                    $('#degreeForm').trigger("reset");
                    $('#ajaxDegree').modal('hide');
                    self.$swal({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Guardado correctamente.',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    self.disable = false;
                    $('#degree-table').DataTable().draw();
                })
                .catch(function (error) {
                    console.log('Error:', error);
                    self.disable = false;
                    self.alert = 'Error al guardar el título.';
                });
        },
        checkBeforeSubmit() {
            this.alert = "";

             if (!this.model.name || !this.model.institution || !this.model.start || !this.model.end) {
                 this.alert = "Por favor, completa todos los campos obligatorios.";
                 return;
             }

            this.submit();
        },

        setModel(data) {
            this.model = data;
            this.model.start = moment(String(this.model.start)).format('YYYY-MM-DD');
            this.model.end = moment(String(this.model.end)).format('YYYY-MM-DD');
        },
        resetModel() {
            this.model = {
                id: null,
                worker_id: $('#worker_id').val(),
                name: null,
                institution: null,
                start: null,
                end: null,
            };
        },
        ajustTable() {
            $('#degree-table').DataTable().columns.adjust().draw();
        },
        getDegreeTitles() {
            axios.get('/degreetitles/get/data')
                .then(response => {
                    this.degreetitles = response.data;
                    console.log(this.degreetitles);

                })
                .catch(error => {
                    console.error('Error al obtener las titulaciones:', error);
                });
        }
    },
    mounted() {
        let self = this;
        this.getDegreeTitles();

        $('#nav-degrees-tab[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            self.ajustTable();
        });

        $('#createNewDegree').click(function () {
            self.title = 'Añadir nuevo título';
            self.resetModel();
            $('#ajaxDegree').modal('show');
        });

        $('body').on('click', '.editDegree', function () {
            var id = $(this).data('id');
            axios.get('/degrees/' + id + '/edit')
                .then(function (response) {
                    self.title = 'Editar título';
                    $('#ajaxDegree').modal('show');
                    self.setModel(response.data);
                })
                .catch(function (error) {
                    console.log('Error:', error);
                });
        });

        $('body').on('click', '.deleteDegree', function () {
            var id = $(this).data("id");
            self.$swal({
                title: "¿Estás seguro?",
                text: "¿Estás seguro de que quieres eliminar este título?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Eliminar',
                cancelButtonText: "Cancelar",
                closeOnConfirm: false,
                closeOnCancel: false
            }).then((data) => {
                if (data.isConfirmed) {
                    axios.delete('/degrees/' + id)
                        .then(function (response) {
                            $('#degree-table').DataTable().draw();
                        })
                        .catch(function (error) {
                            console.log('Error:', error);
                        });
                }
            });
        });

    }
}
</script>
