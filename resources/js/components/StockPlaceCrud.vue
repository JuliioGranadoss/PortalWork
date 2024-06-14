<template>
    <div class="modal fade" id="ajaxModelPlace" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">{{ title }}</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="checkBeforeSubmit" id="modelFormPlace" name="modelFormPlace" class="form-horizontal">
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
                                <label for="status" class="control-label">Estado*</label>
                                <select class="form-control" v-model="model.status" required>
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
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
            model: {
                id: null,
                name: null,
                status: 1
            }
        }
    },
    methods: {
        submit() {
            let self = this;
            this.disable = true;
            axios.post('/stockplaces', this.model)
                .then(function (response) {
                    $('#modelFormPlace').trigger("reset");
                    $('#ajaxModelPlace').modal('hide');
                    self.$swal({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Guardado correctamente.',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    self.disable = false;
                    $('#stock-place-table').DataTable().draw();
                })
                .catch(function (error) {
                    console.log('Error:', error);
                    self.disable = false;
                    self.alert = 'Error al guardar el lugar.';
                });
        },
        checkBeforeSubmit() {
            this.alert = "";

            if (!this.model.name || this.model.status === null) {
                this.alert = "Por favor, completa todos los campos obligatorios.";
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
                name: null,
                status: 1
            };
        },
        ajustTable() {
            $('#stockplace-table').DataTable().columns.adjust().draw();
        }
    },
    mounted() {
        let self = this;

        $('#nav-stockplaces-tab[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            self.ajustTable();
        });

        $('#createNewModelPlace').click(function () {
            self.title = 'Añadir nuevo lugar';
            self.resetModel();
            $('#ajaxModelPlace').modal('show');
        });

        $('body').on('click', '.editModelPlace', function () {
            var id = $(this).data('id');
            axios.get('/stockplaces/' + id + '/edit')
                .then(function (response) {
                    self.title = 'Editar lugar';
                    $('#ajaxModelPlace').modal('show');
                    self.setModel(response.data);
                })
                .catch(function (error) {
                    console.log('Error:', error);
                });
        });

        $('body').on('click', '.deleteModelPlace', function () {
            var id = $(this).data("id");
            self.$swal({
                title: "¿Estás seguro?",
                text: "¿Estás seguro de que quieres eliminar este lugar?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Eliminar',
                cancelButtonText: "Cancelar",
                closeOnConfirm: false,
                closeOnCancel: false
            }).then((data) => {
                if (data.isConfirmed) {
                    axios.delete('/stockplaces/' + id)
                        .then(function (response) {
                            $('#stock-place-table').DataTable().draw();
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
