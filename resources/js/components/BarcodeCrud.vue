<template>
    <div class="modal fade" id="ajaxBarcode" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">{{ title }}</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="checkBeforeSubmit" id="BarcodeForm" name="BarcodeForm" class="form-horizontal">
                        <div v-if="alert" class="card bg-danger text-white shadow m-2">
                            <div class="card-body p-3">
                                Alerta
                                <div class="text-white-50 small">{{ alert }}</div>
                            </div>
                        </div>
                        <input type="hidden" name="id" v-model="model.id">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="code" class="control-label">Código*</label>
                                <input type="text" class="form-control" v-model="model.code" required>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary" v-bind:disabled="disable">Guardar código</button>
                            </div>
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
                product_id: $('#product_id').val(),
                code: null
            }
        }
    },
    methods: {
        submit() {
            let self = this;
            this.disable = true;
            axios.post('/barcodes', this.model)
                .then(function (response) {
                    $('#BarcodeForm').trigger("reset");
                    $('#ajaxBarcode').modal('hide');
                    self.$swal({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Guardado correctamente.',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    self.disable = false;
                    $('#barcode-table').DataTable().draw();
                })
                .catch(function (error) {
                    console.log('Error:', error);
                    self.disable = false;
                    self.alert = 'Error al guardar el código de barras.';
                });
        },
        checkBeforeSubmit() {
            this.alert = "";

            if (!this.model.code) {
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
                product_id: $('#product_id').val(),
                code: null
            };
        },
        ajustTable() {
            $('#barcode-table').DataTable().columns.adjust().draw();
        }
    },
    mounted() {
        let self = this;

        $('#nav-barcodes-tab[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            self.ajustTable();
        });

        $('#createNewBarcode').click(function () {
            self.title = 'Añadir nuevo código de barras';
            self.resetModel();
            $('#ajaxBarcode').modal('show');
        });

        $('body').on('click', '.editBarcode', function () {
            var id = $(this).data('id');
            axios.get('/barcodes/' + id + '/edit')
                .then(function (response) {
                    self.title = 'Editar código de barras';
                    $('#ajaxBarcode').modal('show');
                    self.setModel(response.data);
                })
                .catch(function (error) {
                    console.log('Error:', error);
                });
        });

        $('body').on('click', '.deleteBarcode', function () {
            var id = $(this).data("id");
            self.$swal({
                title: "¿Estás seguro?",
                text: "¿Estás seguro de que quieres eliminar este código de barras?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Eliminar',
                cancelButtonText: "Cancelar",
                closeOnConfirm: false,
                closeOnCancel: false
            }).then((data) => {
                if (data.isConfirmed) {
                    axios.delete('/barcodes/' + id)
                        .then(function (response) {
                            $('#barcode-table').DataTable().draw();
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
