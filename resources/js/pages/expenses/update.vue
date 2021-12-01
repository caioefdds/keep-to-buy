<template>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title m-2">Editar despesa </h1>
                    <span class="text-warning"> (Ao atualizar o registro, todos lançamentos da fatura serão atualizados)</span>
                </div>

                <div class="card-body pb-2">
                    <div class="row row-sm">
                        <div class="card-pay">
                            <ul class="tabs-menu nav justify-content-center opacity-60">
                                <li><a :class="parseInt(formData.type) === 1 ? 'active' : ''"><i class="fa fa-calendar-check-o"></i> Despesa Fixa</a></li>
                                <li><a :class="parseInt(formData.type) === 2 ? 'active' : ''"><i class="fa fa-credit-card"></i>  Despesa Variável</a></li>
                            </ul>
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
                                    <option value="1">Pago</option>
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
                                <input id="dateRegistry" v-if="parseInt(formData.type) === 1" :class="'form-control fc-datepicker ' + errors.date" placeholder="dd/mm/aaaa" type="text">
                                <input id="dateRegistry" v-else :class="'form-control fc-datepicker ' + errors.date" placeholder="dd/mm/aaaa" type="text" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row row-sm mb-3 opacity-50" id="repeatOptions">
                        <div class="col-lg">
                            <div class="form-group">
                                <div class="form-label">Possui repetição?</div>
                                <label class="custom-switch">
                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" v-model="formData.repeat" @change="changeRepeat()" readonly disabled>
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description"> Marque caso tenha mais de um lançamento</span>
                                </label>
                            </div>
                        </div>

                        <div class="col-lg repeatDiv">
                            <label class="form-label">Quantidade de repetições</label>
                            <input type="number" :class="'form-control ' + errors.repeat_times" min="1" v-model="formData.repeat_times" readonly disabled>
                        </div>

                        <div class="col-lg repeatDiv">
                            <div class="form-group">
                                <label class="form-label">Frequência da repetição</label>
                                <select class="form-control form-select select2" data-bs-placeholder="Selecione um" v-model="formData.repeat_type" readonly disabled>
                                    <option label="Selecione" disabled></option>
                                    <option value="1">Semanalmente</option>
                                    <option value="2">Mensalmente</option>
                                    <option value="3">Anualmente</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="btn-list">
                            <a href="#" class="btn btn-danger" @click="back()">Voltar</a>
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
    props: {
        data: {
            default: () => []
        }
    },
    data() {
        return {
            formData: JSON.parse(this.data),
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
        this.setValue();
        this.changeType(this.formData.type);
        this.changeRepeat();
    },
    methods: {
        setValue() {
            $(this.selectors.moneyInput).val(this.formData.value);
            $(this.selectors.dateInput).val(this.formData.date);
        },
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
        save() {
            this.resetErrorFields();
            this.setValueField();

            this.axios.post('/admin/expenses/update', this.formData).then((result) => {
                this.$toast.open(result.data.msg);
                window.location.href = '/admin/expenses';
            }).catch((error) => {
                this.getErrors(error.response.data);
            });
        },
        back() {
            window.location.href = '/admin/expenses';
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
.opacity-50 {
    opacity: 0.5;
}
.opacity-60 {
    opacity: 0.6;
}
.opacity-75 {
    opacity: 0.75;
}
.card-pay .tabs-menu li a.active {
    background: #de223d !important;
    color: #fff;
}
</style>
