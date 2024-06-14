<template>
    <div class="modal fade" id="ajaxProviderModel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
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
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name" class="control-label">Nombre del proveedor*</label>
                                <input type="text" class="form-control" v-model="model.name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="status" class="control-label">Estado del proveedor*</label>
                                <select class="select form-control" name="status" id="status" v-model="model.status"
                                    required>
                                    <option value="0">Baja</option>
                                    <option value="1">Alta</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 text-right">
                            <button type="submit" class="btn btn-primary" :disabled="disable">Guardar proveedor</button>
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
        };
    },
    methods: {
        submit() {
            let self = this;
            this.disable = true;
            axios.post('/providers', this.model)
                .then(function (response) {
                    $('#modelForm').trigger("reset");
                    $('#ajaxProviderModel').modal('hide');
                    self.$swal({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Guardado correctamente.',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    self.disable = false;
                    $('#provider-table').DataTable().draw();
                })
                .catch(function (error) {
                    console.log('Error:', error);
                    self.disable = false;
                    self.alert = 'Error al guardar el proveedor.';
                });
        },
        checkBeforeSubmit() {
            this.alert = "";

            if (!this.model.name) {
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
        }
    },
    mounted() {
        let self = this;

        $('#createNewProvider').click(function () {
            self.title = 'Añadir nuevo proveedor';
            self.resetModel();
            $('#ajaxProviderModel').modal('show');
        });

        $('body').on('click', '.editProvider', function () {
            var id = $(this).data('id');
            axios.get('/providers/' + id + '/edit')
                .then(function (response) {
                    self.title = 'Editar proveedor';
                    $('#ajaxProviderModel').modal('show');
                    self.setModel(response.data);
                })
                .catch(function (error) {
                    console.log('Error:', error);
                });
        });

        $('body').on('click', '.deleteProvider', function () {
            var id = $(this).data("id");
            self.$swal({
                title: "¿Estás seguro?",
                text: "¿Estás seguro de que quieres eliminar este proveedor?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Eliminar',
                cancelButtonText: "Cancelar",
                closeOnConfirm: false,
                closeOnCancel: false
            }).then((data) => {
                if (data.isConfirmed) {
                    axios.delete('/providers/' + id)
                        .then(function (response) {
                            $('#provider-table').DataTable().draw();
                        })
                        .catch(function (error) {
                            console.log('Error:', error);
                        });
                }
            });
        });
    }
};
</script>