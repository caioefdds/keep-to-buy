<template>
    <div class="row">

        <div class="row" id="user-profile">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="col-12">
                            <div class="wideget-user">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-xl-6">
                                        <div class="wideget-user-desc d-flex">
                                            <div class="wideget-user-img" @click="openImageInput">
                                                <img class="" src="/assets/images/users/1.jpg" width="150px" height="150px" v-if="formData.image == null">
                                                <img class="" :src="formData.image" width="150px" height="150px" v-else>
                                            </div>
                                            <div class="my-auto">
                                                <div class="name_title">{{ formData.name }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="col-12">
                            <div class="row row-sm mb-3">
                                <div class="col-lg-12">
                                    <label class="form-label">Nome Completo</label>
                                    <input type="text" :class="'form-control ' + errors.name" v-model="formData.name">
                                </div>

                                <div class="col-lg">
                                    <div class="form-group">
                                        <label class="form-label">Gênero</label>
                                        <select :class="'form-control form-select select2 ' + errors.gender" data-bs-placeholder="Selecione um" v-model="formData.gender">
                                            <option label="--- Selecione ---" disabled></option>
                                            <option value="1">Masculino</option>
                                            <option value="2">Feminino</option>
                                            <option value="3">Outro</option>
                                        </select>
                                    </div>
                                </div>

                                <input id="imageInput" type="file" name="image" accept="image/png, image/gif, image/jpeg" @change="getImage" style="display: none"/>

                                <div class="col-lg">
                                    <label class="form-label">Data de nascimento</label>
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                        </div>
                                        <input id="dateRegistry" :class="'form-control fc-datepicker ' + errors.birth_date" placeholder="dd/mm/aaaa" type="text">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="btn-list">
                                    <a href="#" class="btn btn-primary" @click="save()">Salvar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ProfilePage",
    props: {
        data: {
            default: () => {}
        }
    },
    data() {
        return {
            formData: JSON.parse(this.data),
            selectors: {
                dateInput: '#dateRegistry'
            },
            errors: {
                name: '',
                birthDate: '',
                oldPassword: '',
                newPassword1: '',
                newPassword2: '',
                gender: 1,
            }
        }
    },
    mounted() {
        $(this.selectors.dateInput).val(this.formData.birth_date);
    },
    methods: {
        openImageInput() {
            $("#imageInput").click()
        },
        async getImage(event) {
            let file = event.target.files[0];
            const reader = new FileReader();

            let rawImg;
            reader.onloadend = () => {
                rawImg = reader.result;
                this.formData.image = rawImg;
            }
            reader.readAsDataURL(file);
        },
        setValueField() {
            this.formData.birth_date = $(this.selectors.dateInput).val();
        },
        save() {
            this.resetErrorFields();
            this.setValueField();

            this.axios.post('/admin/profile/update', this.formData).then((response) => {
                this.$toast.open(response.data.msg);

                if (response.status === 201) {
                    window.location.reload();
                }
            }).catch((error) => {
                this.getErrors(error.response.data);
            });
        },
        getErrors(error) {
            if (error.errors !== null && error.errors !== undefined) {
                Object.entries(error.errors).forEach(([key, value]) => {
                    this.$toast.error(value[0]);
                    this.errors[key] = 'is-invalid state-invalid';
                });
            }
        },
        resetErrorFields() {
            this.errors = {
                name: '',
                birth_date: '',
                gender: ''
            }
        }
    }
}
</script>

<style scoped>
.card-pay .tabs-menu li a.active {
    background: #006bab !important;
    color: #fff;
}
.card-pay .tabs-menu li a {
    color: black
}
</style>
