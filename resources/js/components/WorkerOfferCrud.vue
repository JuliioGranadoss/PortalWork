<template>
    <div class="modal fade" id="ajaxWorkerOffer" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">{{ title }}</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="checkBeforeSubmit" id="WorkerOfferForm" name="WorkerOfferForm"
                        class="form-horizontal">
                        <div v-if="alert" class="card bg-danger text-white shadow m-2">
                            <div class="card-body p-3">
                                Alerta
                                <div class="text-white-50 small">{{ alert }}</div>
                            </div>
                        </div>
                        <input type="hidden" name="worker_id" v-model="worker_id">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="offer_id" class="control-label">Oferta</label>
                                <select class="form-control" name="offer_id" v-model="model.offer_id" required>
                                    <option v-for="offer in availableOffers" :value="offer.id">{{ offer.name }}</option>
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
            title: 'Asignar oferta al trabajador',
            alert: null,
            disable: false,
            worker_id: $('#worker_id').val(),
            model: {
                worker_id: this.worker_id,
                offer_id: null,
            },
            availableOffers: [] // Lista de ofertas disponibles
        }
    },
    methods: {
        // Método para obtener las ofertas disponibles
        getAvailableOffers() {
            axios.get('/workeroffers/'+this.worker_id+'/available-offers')
                .then(response => {
                    this.availableOffers = response.data;
                })
                .catch(error => {
                    console.error('Error al obtener las ofertas:', error);
                });
        },
        // Método para enviar el formulario
        submit() {
            let self = this;
            this.disable = true;
            axios.post('/workeroffers', this.model)
                .then(function (response) {
                    $('#WorkerOfferForm').trigger("reset");
                    $('#ajaxWorkerOffer').modal('hide');
                    self.$swal({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Guardado correctamente.',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    self.disable = false;
                    $('#workeroffer-table').DataTable().draw();
                })
                .catch(function (error) {
                    console.log('Error:', error);
                    self.disable = false;
                    self.alert = 'Error al guardar la oferta.';
                });
        },

        // Método para verificar el formulario antes de enviar
        checkBeforeSubmit() {
            this.alert = "";
            if (!this.model.offer_id) {
                this.alert = "Debes seleccionar una oferta.";
                return;
            }
            this.submit();
        },

        // Método para reiniciar el modelo del formulario
        resetModel() {
            this.model = {
                worker_id: this.worker_id,
                offer_id: null,
            };
        },
        // Método para ajustar la tabla de ofertas
        ajustTable() {
            $('#workeroffer-table').DataTable().columns.adjust().draw();
        }
    },
    mounted() {
        let self = this;

        // Ajustar la tabla cuando se muestra la pestaña de ofertas
        $('#nav-workeroffers-tab[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            self.ajustTable();
        });

        // Obtener las ofertas disponibles al abrir el modal
        $('#ajaxWorkerOffer').on('show.bs.modal', function (e) {
            self.getAvailableOffers(); // Llamar al método para cargar las ofertas disponibles
        });

        $('#createNewWorkerOffer').click(function () {
            self.title = 'Seleccionar oferta';
            self.resetModel();
            $('#ajaxWorkerOffer').modal('show');
        });

        $('body').on('click', '.deleteWorkerOffer', function () {
            var offer_id = $(this).data("offer_id");
            var worker_id = $(this).data("worker_id");
            self.$swal({
                title: "¿Estás seguro?",
                text: "¿Estás seguro de que quieres eliminar esta oferta?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Eliminar',
                cancelButtonText: "Cancelar",
                closeOnConfirm: false,
                closeOnCancel: false
            }).then((data) => {
                if (data.isConfirmed) {
                    axios.delete('/workeroffers/' + worker_id +'/'+ offer_id + '/destroy')
                        .then(function (response) {
                            $('#workeroffer-table').DataTable().draw();
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
