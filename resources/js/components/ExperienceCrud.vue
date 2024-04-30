<template>
    <div class="modal fade" id="ajaxExperience" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">{{ title }}</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="checkBeforeSubmit" id="experienceForm" name="experienceForm"
                        class="form-horizontal">
                        <div v-if="alert" class="card bg-danger text-white shadow m-2">
                            <div class="card-body p-3">
                                Alerta
                                <div class="text-white-50 small">{{ alert }}</div>
                            </div>
                        </div>
                        <input type="hidden" name="id" v-model="model.id">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name" class="control-label">Nombre*</label>
                                <input type="text" class="form-control" v-model="model.name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="company" class="control-label">Nombre de la compañía*</label>
                                <input type="text" class="form-control" v-model="model.company" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="start" class="control-label">Fecha de inicio*</label>
                                <input type="date" class="form-control" v-model="model.start" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="end" class="control-label">Fecha de fin*</label>
                                <input type="date" class="form-control" v-model="model.end" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="score" class="control-label">Puntuación</label>
                                <input type="number" class="form-control" v-model="model.score" min="0" max="10">
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
            title: null,
            alert: null,
            disable: false,
            model: {
                id: null,
                worker_id: $('#worker_id').val(),
                name: null,
                company: null,
                start: null,
                end: null,
                score: null
            }
        }
    },
    methods: {
        submit() {
            let self = this;
            this.disable = true;
            axios.post('/experiencies', this.model)
                .then(function (response) {
                    $('#experienceForm').trigger("reset");
                    $('#ajaxExperience').modal('hide');
                    self.$swal({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Guardado correctamente.',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    self.disable = false;
                    $('#experience-table').DataTable().draw();
                })
                .catch(function (error) {
                    console.log('Error:', error);
                    self.disable = false;
                    self.alert = 'Error al guardar experiencia laboral.';
                });
        },
        checkBeforeSubmit() {
            this.alert = "";

            if (!this.model.name || !this.model.company || !this.model.start || !this.model.end) {
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
                company: null,
                start: null,
                end: null,
                score: null
            };
        },
        ajustTable() {
            $('#experience-table').DataTable().columns.adjust().draw();
        }
    },
    mounted() {
        let self = this;

        $('#nav-experiencies-tab[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            self.ajustTable();
        });

        $('#createNewExperience').click(function () {
            self.title = 'Añadir nueva experiencia laboral';
            self.resetModel();
            $('#ajaxExperience').modal('show');
        });

        $('body').on('click', '.editExperience', function () {
            var id = $(this).data('id');
            axios.get('/experiencies/' + id + '/edit')
                .then(function (response) {
                    self.title = 'Editar experiencia laboral';
                    $('#ajaxExperience').modal('show');
                    self.setModel(response.data);
                })
                .catch(function (error) {
                    console.log('Error:', error);
                });
        });

        $('body').on('click', '.deleteExperience', function () {
            var id = $(this).data("id");
            self.$swal({
                title: "¿Estás seguro?",
                text: "¿Estás seguro de que quieres eliminar?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Eliminar',
                cancelButtonText: "Cancelar",
                closeOnConfirm: false,
                closeOnCancel: false
            }).then((data) => {
                if (data.isConfirmed) {
                    axios.delete('/experiencies/' + id)
                        .then(function (response) {
                            $('#experience-table').DataTable().draw();
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
