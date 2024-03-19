<template>
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">{{ title }}</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="checkBeforeSubmit" id="modelForm" name="modelForm" class="form-horizontal">
                        <div v-if="alert" class="card bg-danger text-white shadow m-2">
                            <div class="card-body p-3">
                                Alerta
                                <div class="text-white-50 small">{{ alert }}</div>
                            </div>
                        </div>
                        <input type="hidden" name="id" v-model="model.id">

                        <div class="form-group">
                            <label for="name" class="col-sm-12 control-label">Título*</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" placeholder="Título" v-model="model.title" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-12 control-label">Descripción*</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" placeholder="Descripción" v-model="model.description">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-12 control-label">Prioridad*</label>
                            <div class="col-sm-12">
                                <select class="select form-control" name="priority" id="priority" v-model="model.priority">
                                    <option value="1">Alta</option>      
                                    <option value="2">Media</option>                                            
                                    <option value="3">Alta</option>                                            
                                </select>
                            </div>
                        </div>                            
                        <div class="form-group">
                            <label for="email" class="col-sm-12 control-label">Estado*</label>
                            <div class="col-sm-12">
                                <select class="select form-control" name="status" id="status" v-model="model.status">
                                    <option value="1">No asignado</option>      
                                    <option value="2">En progreso</option>                                            
                                    <option value="3">En pausa</option>
                                    <option value="4">Resuelto</option>                                            
                                </select>
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
                model: {}
            }
        },
        methods: {
            submit() {
                let self = this;
                this.disable = true;
                axios.post('/incidents', this.model)
                .then(function (response) {
                    $('#modelForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    self.$swal({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Guardado correctamente.',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    self.disable = false;
                    $('#incident-table').DataTable().draw();
                })
                .catch(function (error) {
                    console.log('Error:', error);
                    $('#saveBtn').html('Guardar cambios');
                });
            },
            checkBeforeSubmit() {
                this.alert = "";

                if (!this.model.title) {
                    this.alert = "Título es un campo obligatorio";
                    return;
                }

                this.submit();
            },
            setModel(data) {
                this.model = data;
            },
            resetModel() {
                this.model = {
                    id: null,
                    title: null,
                    description: null,
                    priority: null,
                    status: null
                };
            },
            ajustTable() {
                $('#incident-table').DataTable().columns.adjust().draw();
            }
        },
        mounted() {
            let self = this;

            $('#nav-incidents-tab[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                self.ajustTable();
            });

            $('#createNewModel').click(function () {
                self.title = 'Añadir nueva incidencia';
                self.resetModel();
                $('#ajaxModel').modal('show');
            });

            $('body').on('click', '.editModel', function () {
                var id = $(this).data('id');
                axios.get('/incidents/' + id + '/edit')
                .then(function (response) {
                    self.title = 'Editar incidencia';
                    $('#ajaxModel').modal('show');
                    self.setModel(response.data);
                })
                .catch(function (error) {
                    console.log('Error:', error);
                });
            });

            $('body').on('click', '.deleteModel', function () {
                var id = $(this).data("id");
                self.$swal({
                    title: "¿Estas seguro?",
                    text: "¿Estas seguro de que quieres eliminar esta incidencia?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Eliminar',
                    cancelButtonText: "Cancelar",
                    closeOnConfirm: false,
                    closeOnCancel: false
                }).then((data) => {
                    if (data.isConfirmed) {
                        axios.delete('/incidents/' + id)
                        .then(function (response) {
                            $('#incident-table').DataTable().draw();
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
