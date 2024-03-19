<template>
    <form @submit.prevent="checkBeforeSubmit" id="modelForm" name="modelForm" class="form-horizontal">
        <div v-if="alert" class="card bg-danger text-white shadow m-2">
            <div class="card-body p-3">
                Alerta
                <div class="text-white-50 small">{{ alert }}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name" class="col-sm-12 control-label">Nombre de la empresa*</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" v-model="model.name" required>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                        <div class="form-group">
                <label for="cif" class="col-sm-12 control-label">C.I.F.*</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" v-model="model.cif" required>
                </div>
            </div>

            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="address" class="col-sm-12 control-label">Dirección*</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" v-model="model.address" required>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="zip_code" class="col-sm-12 control-label">Código postal*</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" v-model="model.zip_code" required>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="town" class="col-sm-12 control-label">Municipio*</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" v-model="model.town" required>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="province" class="col-sm-12 control-label">Provincia*</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" v-model="model.province" required>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="phone" class="col-sm-12 control-label">Teléfono*</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" v-model="model.phone" required>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email" class="col-sm-12 control-label">Email*</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" v-model="model.email" required>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email" class="col-sm-12 control-label">Nombre de aplicación*</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" v-model="model.company_app" required>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email" class="col-sm-12 control-label">Número total de usuarios*</label>
                    <div class="col-sm-12">
                        <input type="number" min="0" step="1" class="form-control" v-model="model.max_user_number" required>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="theme_color" class="col-sm-12 control-label">Color del thema*</label>
                    <div class="col-sm-12">
                        <color-picker v-model:pureColor="model.theme_color"/>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email" class="col-sm-12 control-label">Logo</label>
                    <div class="col-sm-12">
                        <div class="input-group  mb-3">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" v-on:change="onLogoChange">
                                <label id="logo-label" class="custom-file-label">Buscar</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email" class="col-sm-12 control-label">Minilogo</label>
                    <div class="col-sm-12">
                        <div class="input-group  mb-3">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" v-on:change="onMiniLogoChange">
                                <label id="minilogo-label" class="custom-file-label">Buscar</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email" class="col-sm-12 control-label">Favicon</label>
                    <div class="col-sm-12">
                        <div class="input-group  mb-3">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" v-on:change="onFaviconChange">
                                <label id="favicon-label" class="custom-file-label">Buscar</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 text-right">
                <button type="submit" class="btn btn-primary" v-bind:disabled="disable">Guardar</button>
            </div>
        </div>
    </form>
</template>

<script>
    import { ColorPicker } from "vue3-colorpicker";
    import "vue3-colorpicker/style.css";

    export default {
        data() {
            return {
                title: null,
                alert: null,
                disable: false,
                model: {
                    theme_color: '#000000'
                }
            }
        },
        components: { ColorPicker },
        methods: {
            onLogoChange(e) {
                this.model.logo = e.target.files[0];
                $('#logo-label').html(e.target.files[0].name);
            },
            onMiniLogoChange(e) {
                this.model.minilogo = e.target.files[0];
                $('#minilogo-label').html(e.target.files[0].name);
            },
            onFaviconChange(e) {
                this.model.favicon = e.target.files[0];
                $('#favicon-label').html(e.target.files[0].name);
            },
            submit() {
                let self = this;
                this.disable = true;
                let formData = new FormData();
                formData.append('name', this.model.name);
                formData.append('cif', this.model.cif);
                formData.append('address', this.model.address);
                formData.append('zip_code', this.model.zip_code);
                formData.append('town', this.model.town);
                formData.append('province', this.model.province);
                formData.append('phone', this.model.phone);
                formData.append('email', this.model.email);
                formData.append('company_app', this.model.company_app);
                formData.append('max_user_number', this.model.max_user_number);
                formData.append('theme_color', this.model.theme_color);

                formData.append('logo', this.model.logo);
                formData.append('minilogo', this.model.minilogo);
                formData.append('favicon', this.model.favicon);

                axios.post('/config/save', formData)
                .then(function (response) {
                    self.$swal({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Guardado correctamente.',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    self.disable = false;
                })
                .catch(function (error) {
                    console.log('Error:', error);
                    $('#saveBtn').html('Guardar cambios');
                });
            },
            checkBeforeSubmit() {
                this.alert = "";

                if (!this.model.name) {
                    this.alert = "Nombre de la empresa es un campo obligatorio";
                    return;
                }
                if (!this.model.cif) {
                    this.alert = "C.I.F. es un campo obligatorio";
                    return;
                }
                if (!this.model.address) {
                    this.alert = "Dirección es un campo obligatorio";
                    return;
                }
                if (!this.model.zip_code) {
                    this.alert = "Código postal es un campo obligatorio";
                    return;
                }
                if (!this.model.town) {
                    this.alert = "Municipio es un campo obligatorio";
                    return;
                }
                if (!this.model.province) {
                    this.alert = "Provincia es un campo obligatorio";
                    return;
                }
                if (!this.model.phone) {
                    this.alert = "Teléfono es un campo obligatorio";
                    return;
                }
                if (!this.model.email) {
                    this.alert = "Email es un campo obligatorio";
                    return;
                }
                if (!this.model.company_app) {
                    this.alert = "Nombre de aplicación es un campo obligatorio";
                    return;
                }
                if (!this.model.max_user_number) {
                    this.alert = "Número de usuario es un campo obligatorio";
                    return;
                }

                this.submit();
            },
            setModel(data) {
                this.model = data;
            },
        },
        mounted() {
            let self = this;
            $('.modal').modal({ backdrop: 'static', keyboard: false });
            
            $(document).ready(function () {
                axios.get('/config/data')
                .then(function (response) {
                    self.setModel(response.data);
                })
                .catch(function (error) {
                    console.log('Error:', error);
                });
            });
        }
    }
</script>
