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

                        <div class="input-group  mb-3">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" v-on:change="onFileChange">
                                <label class="custom-file-label">Buscar</label>
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
            onFileChange(e) {
                this.model.file = e.target.files[0];
                $('.custom-file-label').html(e.target.files[0].name);
            },
            submit() {
                let self = this;
                this.disable = true;
                let formData = new FormData();
                formData.append('file', this.model.file);

                axios.post('/files', formData)
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
                    $('#file-table').DataTable().draw();
                })
                .catch(function (error) {
                    console.log('Error:', error);
                    $('#saveBtn').html('Guardar cambios');
                });
            },
            checkBeforeSubmit() {
                this.alert = "";

                this.submit();
            },
            setModel(data) {
                this.model = data;
            },
            resetModel() {
                this.model = {
                    id: null,
                    file: null,
                };
            },
            ajustTable() {
                $('#file-table').DataTable().columns.adjust().draw();
            }
        },
        mounted() {
            let self = this;

            $('#nav-files-tab[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                self.ajustTable();
            });

            $('#createNewModel').click(function () {
                self.title = 'Añadir nuevo archivo';
                self.resetModel();
                $('#ajaxModel').modal('show');
            });

            $('body').on('click', '.deleteModel', function () {
                var id = $(this).data("id");
                self.$swal({
                    title: "¿Estas seguro?",
                    text: "¿Estas seguro de que quieres eliminar este archivo?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Eliminar',
                    cancelButtonText: "Cancelar",
                    closeOnConfirm: false,
                    closeOnCancel: false
                }).then((data) => {
                    if (data.isConfirmed) {
                        axios.delete('/files/' + id)
                        .then(function (response) {
                            $('#file-table').DataTable().draw();
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
