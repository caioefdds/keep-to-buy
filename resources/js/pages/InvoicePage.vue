<template>
    <div class="col-12">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-4 col-xl-4">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="counter-icon bg-success-gradient box-shadow-success brround ms-auto me-auto">
                            <i class="fe fe-dollar-sign text-white mb-5 "></i>
                        </div>
                        <h5>Receitas</h5>
                        <h2>{{ this.totalProfits }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-4 col-xl-4">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="counter-icon bg-danger-gradient box-shadow-danger brround ms-auto me-auto">
                            <i class="fe fe-dollar-sign text-white mb-5 "></i>
                        </div>
                        <h5>Despesas</h5>
                        <h2>{{ this.totalExpenses }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="col-12 d-flex justify-content-center">
                                                    <span class="year_name text-primary">{{ this.dateYear }}</span>
                                                </div>
                                                <div class="col-12 mb-5">
                                                    <div class="d-flex justify-content-center">
                                                        <div class="d-flex">
                                                            <button class="arrow_month_button" @click="modifyDate(false)">
                                                                <i class="fa fa-chevron-left"></i>
                                                            </button>
                                                        </div>
                                                        <div class="month_name">
                                                            <button class="month_button">
                                                                <i aria-label="fa fa-calendar-o" class="fa fa-calendar-o"></i>&nbsp&nbsp
                                                                {{ this.dateMonthName }}
                                                            </button>
                                                        </div>
                                                        <div class="d-flex">
                                                            <button class="arrow_month_button" @click="modifyDate(true)">
                                                                <i class="fa fa-chevron-right"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered text-nowrap border-bottom w-100" id="responsive-datatable-invoices">
                                                        <thead>
                                                        <tr>
                                                            <th class="wd-15p border-bottom-0">Situação</th>
                                                            <th class="wd-15p border-bottom-0">Data</th>
                                                            <th class="wd-20p border-bottom-0">Descrição</th>
                                                            <!--                                    <th class="wd-15p border-bottom-0">Categoria</th>-->
                                                            <th class="wd-15p border-bottom-0">Valor</th>
                                                            <!--                                    <th class="wd-15p border-bottom-0">Parcelas</th>-->
                                                            <th class="wd-15p border-bottom-0">Ações</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr v-for="item in dataTable" :class="(parseInt(item.record_type) === 1) ? 'bg-profit' : 'bg-expense'">
                                                            <td v-if="parseInt(item.record_type) === 1">
                                                                <div class="d-flex" v-if="parseInt(item.status) === 1">
                                                                    <a href="#" class="icons-table-b text-success" @click="receiveRegistry(item)">
                                                                        <i class="side-menu__icon fa fa-money"></i>
                                                                    </a>
                                                                    <div class="my-auto">RECEBIDO</div>
                                                                </div>
                                                                <div class="d-flex" v-else>
                                                                    <a href="#" class="icons-table-b text-dark" @click="receiveRegistry(item)">
                                                                        <i class="side-menu__icon fa fa-money"></i>
                                                                    </a>
                                                                    <div class="my-auto">PENDENTE</div>
                                                                </div>
                                                            </td>
                                                            <td v-else>
                                                                <div class="d-flex" v-if="parseInt(item.status) === 1">
                                                                    <a href="#" class="icons-table-b text-danger" @click="payRegistry(item)">
                                                                        <i class="side-menu__icon fa fa-money"></i>
                                                                    </a>
                                                                    <div class="my-auto">PAGO</div>
                                                                </div>
                                                                <div class="d-flex" v-else>
                                                                    <a href="#" class="icons-table-b text-dark" @click="payRegistry(item)">
                                                                        <i class="side-menu__icon fa fa-money"></i>
                                                                    </a>
                                                                    <div class="my-auto">PENDENTE</div>
                                                                </div>
                                                            </td>
                                                            <td>{{ item.date }}</td>
                                                            <td>{{ item.name }}</td>
                                                            <!--                                    <td>{{ item.category }}</td>-->
                                                            <td>{{ item.value }}</td>
                                                            <!--                                    <td>{{ item.repeat }}</td>-->
                                                            <!--                                    <td>{{ item.repeat_times }}</td>-->
                                                            <td class="d-flex justify-content-center p-auto">
                                                                <a href="#" class="icons-table text-warning" @click="editModal(item)" data-toggle="tooltip" data-placement="top" title="Editar registro">
                                                                    <i class="side-menu__icon fa fa-edit"></i>
                                                                </a>
                                                                <a href="#" class="icons-table text-danger" @click="deleteModal(item)" data-toggle="tooltip" data-placement="top" title="Deletar registro">
                                                                    <i class="side-menu__icon fa fa-trash"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="modalEdit">
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body p-4">
                                                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" ><span aria-hidden="true">&times;</span></button>
                                                    <div>
                                                        <h4>Editar dados</h4>
                                                        <hr>
                                                        <div class="row mb-5">
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
                                                                    <div class="form-label">Como deseja editar?</div>
                                                                    <div class="custom-controls-stacked">
                                                                        <label class="custom-control custom-radio">
                                                                            <input type="radio" class="custom-control-input" name="example-radios" :value="1" v-model="formData.typeAction" checked>
                                                                            <span class="custom-control-label">Editar somente essa</span>
                                                                        </label>
                                                                        <label class="custom-control custom-radio">
                                                                            <input type="radio" class="custom-control-input" name="example-radios" :value="2" v-model="formData.typeAction">
                                                                            <span class="custom-control-label">Editar todas pendentes</span>
                                                                        </label>
                                                                        <label class="custom-control custom-radio">
                                                                            <input type="radio" class="custom-control-input" name="example-radios" :value="3" v-model="formData.typeAction">
                                                                            <span class="custom-control-label">Editar todas (incluindo as concluídas)</span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-12 d-flex justify-content-end">
                                                                <button class="btn btn-danger pd-x-25 me-2" data-bs-dismiss="modal">Cancelar</button>
                                                                <button class="btn btn-success pd-x-25" @click="update">Salvar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="modalDelete">
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body p-4">
                                                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" ><span aria-hidden="true">&times;</span></button>
                                                    <div>
                                                        <h4>Deletar dados</h4>
                                                        <hr>
                                                        <div class="row mb-5">
                                                            <div class="col-lg">
                                                                <div class="form-group">
                                                                    <div class="form-label">Como deseja deletar?</div>
                                                                    <div class="custom-controls-stacked">
                                                                        <label class="custom-control custom-radio">
                                                                            <input type="radio" class="custom-control-input" name="example-radios" :value="1" v-model="typeActionDelete" checked>
                                                                            <span class="custom-control-label">Deletar somente essa</span>
                                                                        </label>
                                                                        <label class="custom-control custom-radio">
                                                                            <input type="radio" class="custom-control-input" name="example-radios" :value="2" v-model="typeActionDelete">
                                                                            <span class="custom-control-label">Deletar todas pendentes</span>
                                                                        </label>
                                                                        <label class="custom-control custom-radio">
                                                                            <input type="radio" class="custom-control-input" name="example-radios" :value="3" v-model="typeActionDelete">
                                                                            <span class="custom-control-label">Deletar todas (incluindo as concluídas)</span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-12 d-flex justify-content-end">
                                                                <button class="btn btn-danger pd-x-25 me-2" data-bs-dismiss="modal">Cancelar</button>
                                                                <button class="btn btn-success pd-x-25" @click="deleteRecord()">Salvar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
    name: "index",
    props: {
        data: {
            default: () => []
        },
        profits: {},
        expenses: {}
    },
    data() {
        return {
            dataTable: JSON.parse(this.data),
            dateMonth: '',
            dateMonthName: '',
            dateYear: '',
            editData: null,
            deleteData: null,
            typeData: null,
            increment: 0,
            consultKey: 0,
            formData: {
                name: "",
                value: "",
                typeAction: 1
            },
            totalProfits: JSON.parse(this.profits),
            totalExpenses: JSON.parse(this.expenses),
            typeActionDelete: 1,
            errors: {}
        }
    },
    mounted() {
        let date = new Date();
        this.dateMonthName = this.getMonthName(date.getMonth());
        this.dateMonth = date.getMonth() + 1;
        this.dateYear = date.getFullYear();

        $("#money").maskMoney({
            prefix: "R$ ",
            decimal: ",",
            thousands: "."
        });
    },
    methods: {
        editModal(data) {
            this.editData = data;
            this.formData.name = data.name;
            this.formData.value = data.value;
            $('#money').val(this.formData.value);
            $('#modalEdit').modal('show');
        },
        deleteModal(data) {
            this.deleteData = data;
            $('#modalDelete').modal('show');
        },
        update() {
            this.formData.value = $('#money').val();
            let urlKey = 'invoice_items';
            if (parseInt(this.editData.record_type) === 1) {
                urlKey = 'profit_records';
            }
            this.axios.post('/admin/' + urlKey + '/editRegistry', {
                data: {
                    formData: this.formData,
                    editData: this.editData
                }
            }).then((response) => {
                if (response.status === 201) {
                    this.getInvoice(this.dateMonth, this.dateYear);
                    this.$toast.open(response.data.msg);
                    $('#modalEdit').modal('hide');
                }
            }).catch((error) => {
            });
        },
        deleteRecord() {
            let urlKey = 'invoice_items';
            if (parseInt(this.deleteData.record_type) === 1) {
                urlKey = 'profit_records';
            }
            this.axios.post('/admin/' + urlKey + '/deleteRegistry', {
                data: {
                    deleteData: this.deleteData,
                    typeActionDelete: this.typeActionDelete
                }
            }).then((response) => {
                if (response.status === 201) {
                    this.getInvoice(this.dateMonth, this.dateYear);
                    this.$toast.open(response.data.msg);
                    $('#modalDelete').modal('hide');
                }
            }).catch((error) => {
            });
        },
        getInvoice(month, year) {
            let loader = this.$loading.show({
                canCancel: false,
                color: '#8373e1',
                opacity: 0.8,
            });
            this.axios.post('/admin/invoices/get', {
                month: month,
                year: year
            }).then((response) => {
                loader.hide();
                this.consultKey++;
                this.dataTable = response.data.data['data'];
                this.totalProfits = response.data.data['totalProfits'];
                this.totalExpenses = response.data.data['totalExpenses'];
            }).catch((error) => {
                loader.hide();
                if (error.response.status === 419) {
                    window.location.reload();
                }
            })
        },
        async modifyDate(type) {
            let date = new Date();
            let month = date.getMonth();
            let year = date.getFullYear();

            if (type) {
                this.increment++;
            } else {
                this.increment--;
            }

            let newDate = new Date (year, month + this.increment, 1);
            let newMonth = newDate.getMonth();
            let newYear = newDate.getFullYear();

            this.dateMonth = newMonth + 1;
            this.dateMonthName = this.getMonthName(newMonth);
            this.dateYear = newYear;

            await this.getInvoice(newMonth + 1, newYear);
        },
        getMonthName(month) {
            let monthName;

            switch (month) {
                case 0:
                    monthName = "Janeiro";
                    break;
                case 1:
                    monthName = "Fevereiro";
                    break;
                case 2:
                    monthName = "Março";
                    break;
                case 3:
                    monthName = "Abril";
                    break;
                case 4:
                    monthName = "Maio";
                    break;
                case 5:
                    monthName = "Junho";
                    break;
                case 6:
                    monthName = "Julho";
                    break;
                case 7:
                    monthName = "Agosto";
                    break;
                case 8:
                    monthName = "Setembro";
                    break;
                case 9:
                    monthName = "Outubro";
                    break;
                case 10:
                    monthName = "Novembro";
                    break;
                case 11:
                    monthName = "Dezembro";
                    break;
            }

            return monthName;
        },
        async payRegistry(data) {
            await this.axios.post('/admin/invoice_items/pay', {
                data: data
            }).then((response) => {
                if (response.status === 201) {
                    this.getInvoice(this.dateMonth, this.dateYear);
                }
            }).catch((error) => {
            });
        },
        async receiveRegistry(data) {
            await this.axios.post('/admin/profit_records/receive', {
                data: data
            }).then((response) => {
                if (response.status === 201) {
                    this.getInvoice(this.dateMonth, this.dateYear);
                }
            }).catch((error) => {
            });
        },
    }
}
</script>
