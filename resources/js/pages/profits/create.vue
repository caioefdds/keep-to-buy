<template>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">Lançamento de receitas</h1>
                </div>

                <div class="card-body pb-2">
                    <div class="row row-sm">
                        <div class="card-pay">
                            <ul class="tabs-menu nav justify-content-center">
                                <li @click="changeType(1)"><a href="#tab20" class="active" data-bs-toggle="tab"><i class="fa fa-calendar-check-o"></i> Receita Fixa</a></li>
                                <li @click="changeType(2)"><a href="#tab21" data-bs-toggle="tab" class=""><i class="fa fa-credit-card"></i>  Receita Variável</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active show" id="tab20">

                                </div>
                                <div class="tab-pane" id="tab21">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body pb-5">
                    <div class="row row-sm mb-3">
                        <div class="col-lg">
                            <label class="form-label">Descrição</label>
                            <input type="text" :class="'form-control ' + errors.name" v-model="formData.name">
                        </div>

                        <div class="col-lg">
                            <label class="form-label">Valor</label>
                            <input type="text" id="money" :class="'form-control ' + errors.value">
                        </div>

                        <div class="col-lg">
                            <div class="form-group">
                                <label class="form-label">Qual status?</label>
                                <select :class="'form-control form-select select2 ' + errors.status" data-bs-placeholder="Selecione um" v-model="formData.status">
                                    <option label="--- Selecione ---" disabled></option>
                                    <option value="1">Recebido</option>
                                    <option value="2">Pendente</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg">
                            <label class="form-label">Data</label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                </div>
                                <input id="dateRegistry" :class="'form-control fc-datepicker ' + errors.date" placeholder="dd/mm/aaaa" type="text">
                            </div>
                        </div>
                    </div>

                    <div class="row row-sm mb-3" id="repeatOptions">
                        <div class="col-lg">
                            <div class="form-group">
                                <div class="form-label">Possui repetição?</div>
                                <label class="custom-switch">
                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" v-model="formData.repeat" @change="changeRepeat()">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description"> Marque caso tenha mais de um lançamento</span>
                                </label>
                            </div>
                        </div>

                        <div class="col-lg repeatDiv">
                            <label class="form-label">Quantidade de repetições</label>
                            <input type="number" :class="'form-control ' + errors.repeat_times" min="1" v-model="formData.repeat_times">
                        </div>

                        <div class="col-lg repeatDiv">
                            <div class="form-group">
                                <label class="form-label">Frequência da repetição</label>
                                <select class="form-control form-select select2" data-bs-placeholder="Selecione um" v-model="formData.repeat_type">
                                    <option label="Selecione" disabled></option>
<!--                                    <option value="1">Semanalmente</option>-->
                                    <option value="2">Mensalmente</option>
<!--                                    <option value="3">Anualmente</option>-->
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="btn-list">
                            <a href="#" class="btn btn-danger" @click="back()">Voltar</a>
                            <a href="#" class="btn btn-primary" @click="saveAndInsert()">Concluir e inserir outro</a>
                            <a href="#" class="btn btn-success" @click="save()">Concluir</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "create",
    data() {
        return {
            formData: {
                name: '',
                type: 1,
                date: '',
                value: 0,
                repeat: 0,
                repeat_times: 1,
                repeat_type: 2,
                status: 2,
            },
            selectors: {
                typeDiv: '#repeatOptions',
                repeatDiv: '.repeatDiv',
                moneyInput: '#money',
                dateInput: '#dateRegistry'
            },
            errors: {
                name: '',
                date: '',
                value: '',
                repeat_times: '',
                status: '',
            }
        }
    },
    mounted() {
        this.changeType();
        this.changeRepeat();
    },
    methods: {
        changeType(option = null) {
            if (option === 2) {
                this.formData.type = 2;
                $(this.selectors.typeDiv).show();
                return;
            }
            this.formData.type = 1;
            $(this.selectors.typeDiv).hide();
        },
        changeRepeat() {
            if (!this.formData.repeat) {
                $(this.selectors.repeatDiv).hide();
                return;
            }
            $(this.selectors.repeatDiv).show();
        },
        setValueField() {
            this.formData.value = $(this.selectors.moneyInput).val();
            this.formData.date = $(this.selectors.dateInput).val();
            this.formData.repeat = this.formData.repeat ? 1 : 0;
        },
        saveAndInsert() {
            this.save(false);

            $(this.selectors.moneyInput).val('');
            $(this.selectors.dateInput).val('');
            this.formData = {
                name: '',
                type: 1,
                date: '',
                value: 0,
                repeat: 0,
                repeat_times: 1,
                repeat_type: 2,
                status: 2,
            };
        },
        save(redirect = true) {
            this.resetErrorFields();
            this.setValueField();

            this.axios.post('/admin/profits/create', this.formData).then((result) => {
                this.$toast.open(result.data.msg);

                if (redirect) {
                    window.location.href = '/admin/profits';
                }
            }).catch((error) => {
                this.getErrors(error.response.data);
            });
        },
        back() {
            window.location.href = '/admin/profits';
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
                date: '',
                value: '',
                repeat_times: '',
                status: ''
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
</style>
